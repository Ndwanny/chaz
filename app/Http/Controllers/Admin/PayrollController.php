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
            'year'  => 'required|integer|min:2020|max:2099',
            'month' => 'required|integer|min:1|max:12',
        ]);

        $date = \Carbon\Carbon::create($data['year'], $data['month'], 1);

        $data['name']       = $date->format('F Y');
        $data['start_date'] = $date->copy()->startOfMonth()->toDateString();
        $data['end_date']   = $date->copy()->endOfMonth()->toDateString();
        $data['status']     = 'open';

        // Prevent duplicate periods
        if (PayrollPeriod::where('year', $data['year'])->where('month', $data['month'])->exists()) {
            return back()->withErrors(['month' => 'A payroll period for ' . $data['name'] . ' already exists.'])->withInput();
        }

        $period = PayrollPeriod::create($data);

        return redirect()->route('admin.payroll.index')->with('success', 'Payroll period created: ' . $period->name);
    }

    public function runPayroll(Request $request, PayrollPeriod $period)
    {
        if ($period->status === 'closed') {
            return back()->with('error', 'This payroll period is already closed.');
        }

        $employees  = Employee::where('status', 'active')->with(['currentSalary'])->get();
        $components = SalaryComponent::where('is_active', true)->orderBy('sort_order')->get();

        $run = PayrollRun::create([
            'payroll_period_id' => $period->id,
            'run_by'            => session('admin_id'),
            'status'            => 'draft',
            'run_date'          => now(),
        ]);

        $totalBasic = 0; $totalAllowances = 0; $totalDeductions = 0; $totalTax = 0; $totalNet = 0; $count = 0;

        foreach ($employees as $employee) {
            $currentSalary = $employee->currentSalary;
            if (!$currentSalary) continue;

            $basicSalary       = (float) $currentSalary->basic_salary;
            $empAllowances     = 0;
            $empDeductions     = 0;
            $empTax            = 0;
            $payslipItemsData  = [];

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

                if ($component->type === 'allowance')     $empAllowances += $amount;
                elseif ($component->type === 'deduction') $empDeductions += $amount;
                elseif ($component->type === 'tax')       $empTax += $amount;
            }

            $netPay = max(0, $basicSalary + $empAllowances - $empDeductions - $empTax);

            $payslip = $run->payslips()->create([
                'employee_id'       => $employee->id,
                'payroll_period_id' => $period->id,
                'basic_salary'      => $basicSalary,
                'total_allowances'  => $empAllowances,
                'total_deductions'  => $empDeductions,
                'total_tax'         => $empTax,
                'net_pay'           => $netPay,
                'working_days'      => $period->working_days ?? 22,
                'days_worked'       => $period->working_days ?? 22,
                'status'            => 'draft',
            ]);

            foreach ($payslipItemsData as $item) {
                $payslip->items()->create($item);
            }

            $totalBasic      += $basicSalary;
            $totalAllowances += $empAllowances;
            $totalDeductions += $empDeductions;
            $totalTax        += $empTax;
            $totalNet        += $netPay;
            $count++;
        }

        $run->update([
            'total_basic'      => $totalBasic,
            'total_allowances' => $totalAllowances,
            'total_deductions' => $totalDeductions,
            'total_tax'        => $totalTax,
            'total_net'        => $totalNet,
            'employee_count'   => $count,
        ]);

        AuditLog::record('ran_payroll', 'PayrollRun', $run->id);

        return redirect()->route('admin.payroll.run.show', $run)
            ->with('success', "Payroll run complete. {$count} payslips generated.");
    }

    public function showRun(PayrollRun $run)
    {
        $run->load(['payslips.employee.department', 'payrollPeriod', 'runBy']);
        return view('admin.payroll.run', compact('run'));
    }

    public function approveRun(PayrollRun $run)
    {
        $run->update([
            'status'      => 'approved',
            'approved_by' => session('admin_id'),
            'approved_at' => now(),
        ]);
        $run->payslips()->update(['status' => 'issued', 'issued_at' => now()]);
        AuditLog::record('approved_payroll_run', 'PayrollRun', $run->id);
        return back()->with('success', 'Payroll run approved and payslips issued.');
    }

    public function showPayslip(Payslip $payslip)
    {
        $payslip->load(['employee.department', 'allowances', 'deductions', 'taxes', 'payrollRun.payrollPeriod']);
        return view('admin.payroll.payslip', compact('payslip'));
    }

    public function grades()
    {
        $grades     = SalaryGrade::withCount('employees')->orderBy('code')->get();
        $components = SalaryComponent::orderBy('sort_order')->get();
        return view('admin.payroll.grades', compact('grades', 'components'));
    }
}
