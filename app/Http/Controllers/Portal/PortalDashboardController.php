<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\{Employee, LeaveRequest, LeaveType, Payslip, Announcement, PerformanceReview};

class PortalDashboardController extends Controller
{
    public function index()
    {
        $employee = Employee::with(['department','salaryGrade'])->find(session('portal_employee_id'));

        // Recent payslips
        $recentPayslips = Payslip::where('employee_id', $employee->id)
            ->latest('issued_at')->limit(3)->get();

        // Leave summary
        $leaveRequests = LeaveRequest::where('employee_id', $employee->id)
            ->with('leaveType')->latest()->limit(5)->get();

        $pendingLeave = LeaveRequest::where('employee_id', $employee->id)
            ->where('status', 'pending')->count();

        // Leave balances per type
        $leaveTypes = LeaveType::where('is_active', true)->get();
        $leaveBalances = $leaveTypes->map(function($type) use ($employee) {
            $used = LeaveRequest::where('employee_id', $employee->id)
                ->where('leave_type_id', $type->id)
                ->where('status', 'approved')
                ->whereYear('start_date', now()->year)
                ->sum('days_requested');
            return [
                'type'      => $type,
                'allowed'   => $type->days_allowed,
                'used'      => $used,
                'remaining' => max(0, $type->days_allowed - $used),
            ];
        })->filter(fn($b) => $b['allowed'] > 0);

        // Announcements
        $announcements = Announcement::where('is_published', true)
            ->where(fn($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>=', now()))
            ->where(fn($q) => $q->where('target_audience', 'all')
                ->orWhere(fn($q2) => $q2->where('target_audience', 'department')->where('target_id', $employee->department_id)))
            ->orderByDesc('priority')->orderByDesc('published_at')
            ->limit(5)->get();

        // Latest performance review
        $latestReview = PerformanceReview::where('employee_id', $employee->id)
            ->where('status', 'completed')->latest('period_end')->first();

        // Colleagues in same department
        $colleagues = Employee::where('department_id', $employee->department_id)
            ->where('id', '!=', $employee->id)
            ->where('status', 'active')
            ->limit(6)->get();

        return view('portal.dashboard', compact(
            'employee', 'recentPayslips', 'leaveRequests', 'pendingLeave',
            'leaveBalances', 'announcements', 'latestReview', 'colleagues'
        ));
    }
}
