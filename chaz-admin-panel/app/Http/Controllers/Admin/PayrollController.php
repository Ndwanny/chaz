<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{PayrollPeriod, PayrollRun, Payslip, PayslipItem, SalaryGrade, SalaryComponent, Employee, AuditLog};
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $periods = PayrollPeriod::withCount('payrollRuns')->orderByDesc('year')->orderByDesc('month')->paginate(12);
        return view('admin.payroll.index', compact('periods'));
    }

    public function createPeriod()
    {
        return view('admin.payroll.period-form');
    }

    public function storePeriod(Request $request)
    {
        $data = $request->validate([
            'year'         => 'required|integer|min:2020|max:2099',
            'month'        => 'required|integer|min:1|max:12',
            'payment_date' => 'required|date',
        ]);

        $data['name']       = \Carbon\Carbon::create($data['year'], $data['month'])->format('F Y');
        $data['start_date'] = \Carbon\Carbon::create($data['year'], $data['month'])->startOfMonth();
        $data['end_date']   = \Carbon\Carbon::create($data['year'], $data['month'])->endOfMonth();
        $data['status']     = 'open';

        $period = PayrollPeriod::create($data);

        return redirect()->route('admin.payroll.index')->with('success', 'Payroll period created: ' . $period->name);
    }

    public function runPayroll(Request $request, PayrollPeriod $period)
    {
        if ($period->isClosed()) {
            return back()->with('error', 'This payroll period is already closed.');
        }

        $employees  = Employee::active()->with(['currentSalary.salaryGrade'])->get();
        $components = SalaryComponent::active()->get();

        $run = PayrollRun::create([
            'payroll_period_id' => $period->id,
            'run_by'            => session('admin_id'),
            'status'            => 'draft',
            'run_at'            => now(),
        ]);

        $totalGross = 0; $totalDeductions = 0; $totalNet = 0; $count = 0;

        foreach ($employees as $employee) {
            $currentSalary = $employee->currentSalary;
            if (!$currentSalary) continue;

            $basicSalary     = (float) $currentSalary->basic_salary;
            $totalAllowances = 0; $totalDed = 0; $paye = 0;
            $napsa = $basicSalary * 0.05;
            $nhima = $basicSalary * 0.01;
            $payslipItemsData = [];

            foreach ($components as $component) {
                $amount = $component->calculate($basicSalary);
                if ($amount == 0) continue;

                $payslipItemsData[] = [
                    'salary_component_id' => $component->id,
                    'item_type'           => $component->type,
                    'name'                => $component->name,
                    'calculation_type'    => $component->calculation_type,
                    'rate'                => $component->value,
                    'amount'              => $amount,
                ];

                if ($component->type === 'allowance')     $totalAllowances += $amount;
                elseif ($component->type === 'deduction') $totalDed += $amount;
                elseif ($component->type === 'tax')       $paye += $amount;
            }

            $grossSalary     = $basicSalary + $totalAllowances;
            $totalDeductionsFull = $totalDed + $napsa + $nhima + $paye;
            $netSalary       = $grossSalary - $totalDeductionsFull;

            $payslip = $run->payslips()->create([
                'employee_id'      => $employee->id,
                'basic_salary'     => $basicSalary,
                'total_allowances' => $totalAllowances,
                'gross_salary'     => $grossSalary,
                'total_deductions' => $totalDeductionsFull,
                'net_salary'       => max(0, $netSalary),
                'paye'             => $paye,
                'napsa_employee'   => $napsa,
                'napsa_employer'   => $napsa,
                'nhima_employee'   => $nhima,
                'nhima_employer'   => $nhima,
                'status'           => 'pending',
            ]);

            foreach ($payslipItemsData as $item) {
                $payslip->items()->create($item);
            }

            $totalGross      += $grossSalary;
            $totalDeductions += $totalDeductionsFull;
            $totalNet        += max(0, $netSalary);
            $count++;
        }

        $run->update([
            'total_gross'      => $totalGross,
            'total_deductions' => $totalDeductions,
            'total_net'        => $totalNet,
            'employee_count'   => $count,
        ]);

        AuditLog::record('ran_payroll', 'PayrollRun', $run->id);

        return redirect()->route('admin.payroll.run', $run)->with('success', "Payroll run complete. {$count} payslips generated.");
    }

    public function showRun(PayrollRun $run)
    {
        $run->load(['payslips.employee.department', 'payrollPeriod', 'runBy']);
        return view('admin.payroll.run', compact('run'));
    }

    public function approveRun(PayrollRun $run)
    {
        $run->update(['status' => 'approved', 'approved_by' => session('admin_id'), 'approved_at' => now()]);
        $run->payslips()->update(['status' => 'pending']);
        AuditLog::record('approved_payroll_run', 'PayrollRun', $run->id);
        return back()->with('success', 'Payroll run approved.');
    }

    public function showPayslip(Payslip $payslip)
    {
        $payslip->load(['employee.department', 'items.salaryComponent', 'payrollRun.payrollPeriod']);
        return view('admin.payroll.payslip', compact('payslip'));
    }

    public function grades()
    {
        $grades = SalaryGrade::withCount('employees')->orderBy('code')->get();
        return view('admin.payroll.grades', compact('grades'));
    }
}
