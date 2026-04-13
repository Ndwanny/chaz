<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Employee;

class PortalAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('portal_employee_id')) {
            return redirect()->route('employee-portal')->with('error', 'Please sign in to access your portal.');
        }

        try {
            $employee = Employee::with(['department', 'salaryGrade'])->find(session('portal_employee_id'));
            if (!$employee || !$employee->portal_active || $employee->status !== 'active') {
                session()->forget(['portal_employee_id','portal_employee_name','portal_staff_number','portal_department_id']);
                return redirect()->route('employee-portal')->with('error', 'Your portal access has been suspended. Contact HR.');
            }
            view()->share('portalEmployee', $employee);
        } catch (\Exception $e) {
            // graceful fallback
        }

        return $next($request);
    }
}
