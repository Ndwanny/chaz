@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Welcome back, {{ session('admin_name') }}</div>
        <div class="page-subtitle">{{ session('admin_role_label') }} &mdash; {{ now()->format('l, d F Y') }}</div>
    </div>
</div>

{{-- Stats Grid --}}
<div class="stats-grid">
    @if(isset($stats['total_employees']))
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-id-badge"></i></div>
        <div><div class="stat-value">{{ number_format($stats['total_employees']) }}</div><div class="stat-label">Active Employees</div></div>
    </div>
    @endif
    @if(isset($stats['on_leave']))
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-calendar-minus"></i></div>
        <div><div class="stat-value">{{ $stats['on_leave'] }}</div><div class="stat-label">Currently on Leave</div></div>
    </div>
    @endif
    @if(isset($stats['pending_leave']))
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-hourglass-half"></i></div>
        <div><div class="stat-value">{{ $stats['pending_leave'] }}</div><div class="stat-label">Pending Leave Requests</div></div>
    </div>
    @endif
    @if(isset($stats['last_payroll_net']))
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-money-bill-wave"></i></div>
        <div><div class="stat-value">{{ number_format($stats['last_payroll_net'] / 1000, 0) }}K</div><div class="stat-label">Last Payroll Net (ZMW)</div></div>
    </div>
    @endif
    @if(isset($stats['pending_pos']))
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-file-invoice"></i></div>
        <div><div class="stat-value">{{ $stats['pending_pos'] }}</div><div class="stat-label">Pending Purchase Orders</div></div>
    </div>
    @endif
    @if(isset($stats['pending_requisitions']))
    <div class="stat-card">
        <div class="stat-icon purple"><i class="fas fa-file-lines"></i></div>
        <div><div class="stat-value">{{ $stats['pending_requisitions'] }}</div><div class="stat-label">Pending Requisitions</div></div>
    </div>
    @endif
    @if(isset($stats['active_vehicles']))
    <div class="stat-card">
        <div class="stat-icon teal"><i class="fas fa-car"></i></div>
        <div><div class="stat-value">{{ $stats['active_vehicles'] }}</div><div class="stat-label">Active Vehicles</div></div>
    </div>
    @endif
    @if(isset($stats['trips_today']))
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-route"></i></div>
        <div><div class="stat-value">{{ $stats['trips_today'] }}</div><div class="stat-label">Trips Today</div></div>
    </div>
    @endif
    @if(isset($stats['due_maintenance']))
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-wrench"></i></div>
        <div><div class="stat-value">{{ $stats['due_maintenance'] }}</div><div class="stat-label">Maintenance Due</div></div>
    </div>
    @endif
    @if(isset($stats['pending_expenses']))
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-receipt"></i></div>
        <div><div class="stat-value">{{ $stats['pending_expenses'] }}</div><div class="stat-label">Pending Expenses</div></div>
    </div>
    @endif
    @if(isset($stats['total_admins']))
    <div class="stat-card">
        <div class="stat-icon purple"><i class="fas fa-users-cog"></i></div>
        <div><div class="stat-value">{{ $stats['total_admins'] }}</div><div class="stat-label">Admin Users</div></div>
    </div>
    @endif
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-bullhorn"></i></div>
        <div><div class="stat-value">{{ $stats['announcements'] }}</div><div class="stat-label">Active Announcements</div></div>
    </div>
</div>

{{-- Three column section --}}
<div style="display:grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 4px;">

    {{-- Recent Announcements --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-bullhorn" style="margin-right:6px;color:var(--accent)"></i>Announcements</span>
            @if(admin_can('manage_content') || admin_can('manage_comms'))
            <a href="{{ route('admin.announcements.index') }}" class="btn btn-sm btn-outline">View All</a>
            @endif
        </div>
        <div class="card-body" style="padding:0;">
            @forelse($recentAnnouncements as $ann)
            <div style="padding:12px 16px; border-bottom:1px solid var(--border); display:flex; gap:10px; align-items:flex-start;">
                <span class="badge badge-{{ $ann->priority === 'urgent' ? 'red' : ($ann->priority === 'high' ? 'orange' : 'blue') }}" style="flex-shrink:0;">{{ ucfirst($ann->priority) }}</span>
                <div>
                    <div style="font-weight:600;font-size:.84rem;">{{ $ann->title }}</div>
                    <div style="font-size:.75rem;color:var(--text-muted);">{{ $ann->published_at?->diffForHumans() }}</div>
                </div>
            </div>
            @empty
            <div style="padding:20px;text-align:center;color:var(--text-muted);font-size:.84rem;">No announcements.</div>
            @endforelse
        </div>
    </div>

    {{-- Pending Leave Requests --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title"><i class="fas fa-calendar-minus" style="margin-right:6px;color:var(--warning)"></i>Leave Requests</span>
            @if(admin_can('view_leave') || admin_can('manage_hr'))
            <a href="{{ route('admin.leave.index') }}" class="btn btn-sm btn-outline">View All</a>
            @endif
        </div>
        <div class="card-body" style="padding:0;">
            @forelse($recentLeave as $leave)
            <div style="padding:11px 16px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <div style="font-weight:600;font-size:.84rem;">{{ $leave->employee->full_name ?? 'N/A' }}</div>
                    <div style="font-size:.75rem;color:var(--text-muted);">{{ $leave->leaveType->name ?? '' }} &bull; {{ $leave->days_requested }} day(s)</div>
                </div>
                <span class="badge badge-orange">Pending</span>
            </div>
            @empty
            <div style="padding:20px;text-align:center;color:var(--text-muted);font-size:.84rem;">No pending requests.</div>
            @endforelse
        </div>
    </div>

</div>

{{-- Recent Expenses --}}
@if(isset($stats['pending_expenses']) || admin_can('manage_finance'))
<div class="card" style="margin-top:20px;">
    <div class="card-header">
        <span class="card-title"><i class="fas fa-receipt" style="margin-right:6px;color:var(--success)"></i>Recent Expenses</span>
        <a href="{{ route('admin.finance.expenses.index') }}" class="btn btn-sm btn-outline">View All</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>#</th><th>Title</th><th>Department</th><th>Category</th><th>Amount (ZMW)</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($recentExpenses as $exp)
            <tr>
                <td>{{ $exp->exp_number }}</td>
                <td>{{ $exp->title }}</td>
                <td>{{ $exp->department->name ?? '—' }}</td>
                <td>{{ $exp->category->name ?? '—' }}</td>
                <td>{{ number_format($exp->amount_zmw, 2) }}</td>
                <td><span class="badge badge-{{ $exp->isPending() ? 'orange' : ($exp->isPaid() ? 'green' : 'blue') }}">{{ ucfirst($exp->status) }}</span></td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:var(--text-muted);">No expenses found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
