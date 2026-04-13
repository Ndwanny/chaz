<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\{Payslip, PayslipItem};

class PortalPayslipController extends Controller
{
    public function index()
    {
        $payslips = Payslip::where('employee_id', session('portal_employee_id'))
            ->with('payrollPeriod')
            ->latest('issued_at')
            ->paginate(12);

        return view('portal.payslips.index', compact('payslips'));
    }

    public function show(Payslip $payslip)
    {
        if ($payslip->employee_id !== session('portal_employee_id')) {
            abort(403);
        }

        $payslip->load(['employee.department', 'employee.salaryGrade', 'payrollPeriod', 'items']);

        $allowances  = $payslip->items->where('type', 'allowance');
        $deductions  = $payslip->items->where('type', 'deduction');
        $taxes       = $payslip->items->where('type', 'tax');

        return view('portal.payslips.show', compact('payslip', 'allowances', 'deductions', 'taxes'));
    }
}
