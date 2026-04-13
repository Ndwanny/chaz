<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Admin, Employee, LeaveRequest, PayrollRun, PurchaseOrder, Requisition, Vehicle, Expense, Announcement, TripLog, MaintenanceRecord};
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $role        = session('admin_role');
        $deptId      = session('admin_department');
        $permissions = session('admin_permissions', []);
        $isSuperAdmin = in_array('super_admin', $permissions);

        $stats = [];

        // Core stats everyone sees
        $stats['announcements'] = Announcement::published()->count();

        // HR stats
        if ($isSuperAdmin || in_array('manage_employees', $permissions) || in_array('view_employees', $permissions)) {
            $stats['total_employees']  = Employee::active()->count();
            $stats['on_leave']         = LeaveRequest::approved()->whereDate('start_date', '<=', now())->whereDate('end_date', '>=', now())->count();
            $stats['pending_leave']    = LeaveRequest::pending()->count();
        }

        // Payroll stats
        if ($isSuperAdmin || in_array('manage_payroll', $permissions) || in_array('view_payroll', $permissions)) {
            $lastRun = PayrollRun::latest()->first();
            $stats['last_payroll_net'] = $lastRun?->total_net ?? 0;
            $stats['last_payroll_date'] = $lastRun?->created_at;
        }

        // Procurement stats
        if ($isSuperAdmin || in_array('manage_procurement', $permissions) || in_array('view_procurement', $permissions)) {
            $stats['pending_pos']          = PurchaseOrder::pending()->count();
            $stats['pending_requisitions'] = Requisition::pending()->count();
        }

        // Fleet stats
        if ($isSuperAdmin || in_array('manage_fleet', $permissions) || in_array('view_fleet', $permissions)) {
            $stats['active_vehicles']  = Vehicle::active()->count();
            $stats['trips_today']      = TripLog::whereDate('departure_datetime', today())->count();
            $dueMaintenance            = MaintenanceRecord::where('next_service_date', '<=', now()->addDays(14))->where('status', '!=', 'completed')->count();
            $stats['due_maintenance']  = $dueMaintenance;
        }

        // Finance stats
        if ($isSuperAdmin || in_array('manage_finance', $permissions) || in_array('view_finance', $permissions)) {
            $stats['pending_expenses'] = Expense::pending()->count();
            $stats['total_expenses_month'] = Expense::whereMonth('expense_date', now()->month)->whereYear('expense_date', now()->year)->sum('amount_zmw');
        }

        // System stats (super_admin / admin only)
        if ($isSuperAdmin || in_array('manage_system', $permissions)) {
            $stats['total_admins'] = Admin::active()->count();
        }

        // Recent activity
        $recentAnnouncements = Announcement::published()->latest('published_at')->limit(5)->get();
        $recentExpenses      = Expense::with('category', 'department')->latest()->limit(5)->get();
        $recentLeave         = LeaveRequest::with('employee', 'leaveType')->pending()->latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentAnnouncements', 'recentExpenses', 'recentLeave', 'role'));
    }
}
