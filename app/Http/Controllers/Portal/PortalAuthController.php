<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PortalAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'staff_number' => 'required|string',
            'password'     => 'required|string',
        ]);

        $employee = Employee::where('staff_number', strtoupper(trim($request->staff_number)))
                            ->where('status', 'active')
                            ->first();

        if (!$employee) {
            return back()->with('error', 'Invalid staff number or password.')->withInput($request->only('staff_number'));
        }

        // If no portal password set, default is staff_number (lowercase)
        $storedHash = $employee->portal_password ?: Hash::make(strtolower($employee->staff_number));
        $testPass   = $employee->portal_password ? $request->password : strtolower($request->password);

        if (!Hash::check($testPass, $storedHash)) {
            // Also try matching against raw staff_number as default
            if ($request->password !== strtolower($employee->staff_number) && $request->password !== $employee->staff_number) {
                return back()->with('error', 'Invalid staff number or password.')->withInput($request->only('staff_number'));
            }
        }

        if (!$employee->portal_active) {
            return back()->with('error', 'Your portal access has been suspended. Contact HR.');
        }

        session([
            'portal_employee_id'     => $employee->id,
            'portal_employee_name'   => $employee->full_name,
            'portal_staff_number'    => $employee->staff_number,
            'portal_department_id'   => $employee->department_id,
        ]);

        try { $employee->update(['portal_last_login' => now()]); } catch (\Exception $e) {}

        return redirect()->route('portal.dashboard');
    }

    public function logout(Request $request)
    {
        session()->forget(['portal_employee_id','portal_employee_name','portal_staff_number','portal_department_id']);
        return redirect()->route('employee-portal')->with('success', 'You have been signed out.');
    }
}
