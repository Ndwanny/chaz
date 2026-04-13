<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Job;
use App\Models\Tender;
use App\Models\Member;
use App\Models\Download;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Website content stats
        $stats = [
            'news'            => News::count(),
            'news_published'  => News::published()->count(),
            'jobs'            => Job::count(),
            'jobs_open'       => Job::open()->count(),
            'tenders'         => Tender::count(),
            'tenders_open'    => Tender::open()->count(),
            'members'         => Member::count(),
            'downloads'       => Download::count(),
            'messages'        => ContactMessage::count(),
            'unread_messages' => ContactMessage::unread()->count(),
        ];

        $recentNews     = News::latest()->take(5)->get();
        $recentMessages = ContactMessage::latest()->take(5)->get();

        $today = now()->toDateString();

        // HR
        $stats['total_employees']  = DB::table('employees')->where('status', 'active')->whereNull('deleted_at')->count();
        $stats['on_leave_today']   = DB::table('leave_requests')->where('status', 'approved')->where('start_date', '<=', $today)->where('end_date', '>=', $today)->count();
        $stats['pending_leave']    = DB::table('leave_requests')->where('status', 'pending')->count();

        // Payroll
        $lastRun = DB::table('payroll_runs')
            ->join('payroll_periods', 'payroll_runs.payroll_period_id', '=', 'payroll_periods.id')
            ->orderByDesc('payroll_runs.id')
            ->select('payroll_runs.total_net', 'payroll_runs.employee_count', 'payroll_runs.status', 'payroll_periods.name as period_name')
            ->first();

        $stats['last_payroll_net']   = $lastRun->total_net ?? 0;
        $stats['last_payroll_month'] = $lastRun->period_name ?? 'None';
        $stats['last_payroll_count'] = $lastRun->employee_count ?? 0;

        // Procurement
        $stats['pending_pos']   = DB::table('purchase_orders')->where('status', 'submitted')->count();
        $stats['low_stock']     = DB::table('items')->where('is_active', true)->where('current_stock', '>', 0)->whereColumn('current_stock', '<=', 'reorder_level')->count();
        $stats['out_of_stock']  = DB::table('items')->where('is_active', true)->where('current_stock', 0)->count();

        // Fleet
        $stats['total_vehicles']  = DB::table('vehicles')->count();
        $stats['active_vehicles'] = DB::table('vehicles')->whereIn('status', ['active', 'available'])->count();
        $stats['maintenance_due'] = DB::table('maintenance_records')->where('next_service_date', '<=', now()->addDays(14)->toDateString())->where('status', '!=', 'completed')->count();

        // Finance
        $stats['pending_expenses']        = DB::table('expenses')->where('status', 'submitted')->count();
        $stats['pending_expenses_amount'] = DB::table('expenses')->where('status', 'submitted')->sum('amount');
        $stats['ytd_expenses']            = DB::table('expenses')->whereYear('expense_date', now()->year)->sum('amount');

        // Recent activity
        $recentAnnouncements = \App\Models\Announcement::published()->latest('published_at')->limit(5)->get();
        $recentExpenses      = \App\Models\Expense::with(['category', 'department', 'employee'])->latest('expense_date')->limit(6)->get();
        $recentLeave         = \App\Models\LeaveRequest::with(['employee.department', 'leaveType'])->where('status', 'pending')->latest()->limit(6)->get();

        return view('admin.dashboard', compact(
            'stats', 'recentNews', 'recentMessages',
            'recentAnnouncements', 'recentExpenses', 'recentLeave'
        ));
    }
}
