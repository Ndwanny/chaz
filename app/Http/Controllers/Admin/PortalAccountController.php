<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Employee, Department, AuditLog};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PortalAccountController extends Controller
{
    private function authorizeHR()
    {
        $admin = view()->shared('currentAdmin');
        if (!$admin) abort(403, 'Unauthorized.');

        $slug = $admin->roleModel?->slug ?? $admin->role ?? '';
        $allowed = ['super_admin', 'superadmin', 'admin', 'hr_manager', 'hr_officer'];

        if (!in_array($slug, $allowed)) {
            abort(403, 'Only HR staff can manage employee portal accounts.');
        }
    }

    public function index(Request $request)
    {
        $this->authorizeHR();

        $query = Employee::with('department')
            ->where('status', 'active')
            ->orderBy('first_name');

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }
        if ($request->filled('portal_status')) {
            if ($request->portal_status === 'active') {
                $query->where('portal_active', true);
            } elseif ($request->portal_status === 'inactive') {
                $query->where(fn($q) => $q->where('portal_active', false)->orWhereNull('portal_active'));
            } elseif ($request->portal_status === 'no_account') {
                $query->whereNull('portal_password')->where(fn($q) => $q->where('portal_active', false)->orWhereNull('portal_active'));
            }
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('first_name', 'like', "%$s%")
                ->orWhere('last_name', 'like', "%$s%")
                ->orWhere('staff_number', 'like', "%$s%"));
        }

        $employees   = $query->paginate(25)->withQueryString();
        $departments = Department::active()->orderBy('name')->get();

        $stats = [
            'total'   => Employee::where('status', 'active')->count(),
            'active'  => Employee::where('status', 'active')->where('portal_active', true)->count(),
            'pending' => Employee::where('status', 'active')->where(fn($q) => $q->where('portal_active', false)->orWhereNull('portal_active'))->count(),
        ];

        return view('admin.portal-accounts.index', compact('employees', 'departments', 'stats'));
    }

    public function activate(Employee $employee)
    {
        $this->authorizeHR();

        $employee->update([
            'portal_active'   => true,
            'portal_password' => $employee->portal_password ?? null, // keep existing or leave null (default applies)
        ]);

        AuditLog::record('portal_account_activated', 'Employee', $employee->id);

        return back()->with('success', "Portal access activated for {$employee->full_name}. Default password: " . strtolower($employee->staff_number));
    }

    public function deactivate(Employee $employee)
    {
        $this->authorizeHR();

        $employee->update(['portal_active' => false]);

        AuditLog::record('portal_account_deactivated', 'Employee', $employee->id);

        return back()->with('success', "Portal access suspended for {$employee->full_name}.");
    }

    public function resetPassword(Employee $employee)
    {
        $this->authorizeHR();

        // Clear custom password — reverts to default (staff_number)
        $employee->update(['portal_password' => null]);

        AuditLog::record('portal_password_reset', 'Employee', $employee->id);

        return back()->with('success', "Password reset for {$employee->full_name}. New default: " . strtolower($employee->staff_number));
    }

    public function setPassword(Request $request, Employee $employee)
    {
        $this->authorizeHR();

        $request->validate([
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $employee->update([
            'portal_password' => Hash::make($request->new_password),
            'portal_active'   => true,
        ]);

        AuditLog::record('portal_password_set', 'Employee', $employee->id);

        return back()->with('success', "Password updated for {$employee->full_name}.");
    }

    public function bulkActivate(Request $request)
    {
        $this->authorizeHR();

        $request->validate(['department_id' => 'required|exists:departments,id']);

        $count = Employee::where('status', 'active')
            ->where('department_id', $request->department_id)
            ->where(fn($q) => $q->where('portal_active', false)->orWhereNull('portal_active'))
            ->update(['portal_active' => true]);

        $dept = Department::find($request->department_id);
        AuditLog::record('portal_bulk_activated', 'Department', $request->department_id);

        return back()->with('success', "Activated portal access for {$count} employee(s) in {$dept->name}.");
    }
}
