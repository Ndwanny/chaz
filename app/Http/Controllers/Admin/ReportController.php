<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Employee, LeaveRequest, PayrollRun, Payslip, PurchaseOrder, Expense, FuelLog, Vehicle, Department, AuditLog};
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function hrReport(Request $request)
    {
        $deptId = $request->department_id;

        $data = [
            'total_employees'   => Employee::active()->when($deptId, fn($q) => $q->where('department_id', $deptId))->count(),
            'by_department'     => Employee::active()->selectRaw('department_id, count(*) as total')->groupBy('department_id')->with('department')->get(),
            'by_type'           => Employee::active()->selectRaw('employment_type, count(*) as total')->groupBy('employment_type')->get(),
            'by_gender'         => Employee::active()->selectRaw('gender, count(*) as total')->groupBy('gender')->get(),
            'leave_summary'     => LeaveRequest::selectRaw('status, count(*) as total')->whereYear('created_at', now()->year)->groupBy('status')->get(),
            'on_probation'      => Employee::where('employment_type', 'intern')->active()->count(),
        ];

        $departments = Department::active()->orderBy('name')->get();
        return view('admin.reports.hr', compact('data', 'departments', 'deptId'));
    }

    public function payrollReport(Request $request)
    {
        $year = $request->get('year', now()->year);

        $runs = PayrollRun::whereHas('payrollPeriod', fn($q) => $q->where('year', $year))
            ->with('payrollPeriod')
            ->orderBy('id')
            ->get();

        $runIds = $runs->pluck('id');
        $data = [
            'total_net'         => $runs->whereIn('status', ['approved', 'paid'])->sum('total_net'),
            'total_tax'         => Payslip::whereIn('payroll_run_id', $runIds)->sum('total_tax'),
            'total_deductions'  => Payslip::whereIn('payroll_run_id', $runIds)->sum('total_deductions'),
            'monthly_breakdown' => $runs,
        ];

        return view('admin.reports.payroll', compact('data', 'year'));
    }

    public function fleetReport(Request $request)
    {
        $year = $request->get('year', now()->year);

        $data = [
            'total_vehicles'    => Vehicle::count(),
            'active_vehicles'   => Vehicle::active()->count(),
            'total_fuel_cost'   => FuelLog::whereYear('log_date', $year)->sum('total_cost'),
            'total_fuel_litres' => FuelLog::whereYear('log_date', $year)->sum('litres'),
            'fuel_by_vehicle'   => FuelLog::whereYear('log_date', $year)->selectRaw('vehicle_id, sum(litres) as litres, sum(total_cost) as cost')->groupBy('vehicle_id')->with('vehicle')->get(),
        ];

        return view('admin.reports.fleet', compact('data', 'year'));
    }

    public function financeReport(Request $request)
    {
        $year = $request->get('year', now()->year);

        $data = [
            'total_expenses'      => Expense::whereYear('expense_date', $year)->sum('amount'),
            'paid_expenses'       => Expense::whereYear('expense_date', $year)->paid()->sum('amount'),
            'pending_expenses'    => Expense::whereYear('expense_date', $year)->pending()->sum('amount'),
            'by_department'       => Expense::whereYear('expense_date', $year)->selectRaw('department_id, sum(amount) as total')->groupBy('department_id')->with('department')->get(),
            'by_category'         => Expense::whereYear('expense_date', $year)->selectRaw('expense_category_id, sum(amount) as total')->groupBy('expense_category_id')->with('category')->get(),
            'po_total'            => PurchaseOrder::whereYear('created_at', $year)->whereIn('status', ['approved', 'delivered'])->sum('grand_total'),
        ];

        return view('admin.reports.finance', compact('data', 'year'));
    }

    public function auditLog(Request $request)
    {
        $logs = AuditLog::with('admin')->latest()->paginate(50);
        return view('admin.reports.audit', compact('logs'));
    }
}
