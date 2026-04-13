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

        $data = [
            'total_paid'        => $runs->where('status', 'paid')->sum('total_net'),
            'total_paye'        => Payslip::whereIn('payroll_run_id', $runs->pluck('id'))->sum('paye'),
            'total_napsa'       => Payslip::whereIn('payroll_run_id', $runs->pluck('id'))->sum('napsa_employee'),
            'total_nhima'       => Payslip::whereIn('payroll_run_id', $runs->pluck('id'))->sum('nhima_employee'),
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
            'total_fuel_cost'   => FuelLog::whereYear('date', $year)->sum('total_cost'),
            'total_fuel_litres' => FuelLog::whereYear('date', $year)->sum('quantity'),
            'fuel_by_vehicle'   => FuelLog::whereYear('date', $year)->selectRaw('vehicle_id, sum(quantity) as litres, sum(total_cost) as cost')->groupBy('vehicle_id')->with('vehicle')->get(),
        ];

        return view('admin.reports.fleet', compact('data', 'year'));
    }

    public function financeReport(Request $request)
    {
        $year = $request->get('year', now()->year);

        $data = [
            'total_expenses'      => Expense::whereYear('expense_date', $year)->sum('amount_zmw'),
            'paid_expenses'       => Expense::whereYear('expense_date', $year)->paid()->sum('amount_zmw'),
            'pending_expenses'    => Expense::whereYear('expense_date', $year)->pending()->sum('amount_zmw'),
            'by_department'       => Expense::whereYear('expense_date', $year)->selectRaw('department_id, sum(amount_zmw) as total')->groupBy('department_id')->with('department')->get(),
            'by_category'         => Expense::whereYear('expense_date', $year)->selectRaw('category_id, sum(amount_zmw) as total')->groupBy('category_id')->with('category')->get(),
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
