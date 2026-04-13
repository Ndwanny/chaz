@extends('admin.layouts.app')
@section('title', $employee->full_name)
@section('breadcrumb', 'HR / Employees / ' . $employee->full_name)

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">{{ $employee->full_name }}</div>
        <div class="page-subtitle">{{ $employee->staff_number }} &bull; {{ $employee->job_title }} &bull; {{ $employee->department->name ?? 'No Department' }}</div>
    </div>
    <div style="display:flex;gap:8px;">
        @if(admin_can('manage_employees'))
        <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-outline"><i class="fas fa-pen"></i> Edit</a>
        @endif
        <a href="{{ route('admin.employees.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
    {{-- Personal Info --}}
    <div class="card">
        <div class="card-header"><span class="card-title">Personal Information</span></div>
        <div class="card-body">
            <table style="width:100%;font-size:.84rem;">
                <tr><td style="color:var(--text-muted);width:40%;padding:5px 0;">Full Name</td><td>{{ $employee->full_name }}</td></tr>
                <tr><td style="color:var(--text-muted);">Gender</td><td>{{ ucfirst($employee->gender) }}</td></tr>
                <tr><td style="color:var(--text-muted);">Date of Birth</td><td>{{ $employee->date_of_birth?->format('d M Y') }} ({{ $employee->age }} yrs)</td></tr>
                <tr><td style="color:var(--text-muted);">National ID</td><td>{{ $employee->national_id ?? '—' }}</td></tr>
                <tr><td style="color:var(--text-muted);">Email</td><td>{{ $employee->email ?? '—' }}</td></tr>
                <tr><td style="color:var(--text-muted);">Phone</td><td>{{ $employee->phone ?? '—' }}</td></tr>
                <tr><td style="color:var(--text-muted);">Address</td><td>{{ $employee->address ?? '—' }}</td></tr>
            </table>
        </div>
    </div>

    {{-- Employment Info --}}
    <div class="card">
        <div class="card-header"><span class="card-title">Employment Details</span></div>
        <div class="card-body">
            <table style="width:100%;font-size:.84rem;">
                <tr><td style="color:var(--text-muted);width:40%;padding:5px 0;">Staff Number</td><td><code>{{ $employee->staff_number }}</code></td></tr>
                <tr><td style="color:var(--text-muted);">Department</td><td>{{ $employee->department->name ?? '—' }}</td></tr>
                <tr><td style="color:var(--text-muted);">Job Title</td><td>{{ $employee->job_title }}</td></tr>
                <tr><td style="color:var(--text-muted);">Employment Type</td><td><span class="badge badge-blue">{{ ucfirst($employee->employment_type) }}</span></td></tr>
                <tr><td style="color:var(--text-muted);">Status</td><td><span class="badge badge-green">{{ ucfirst(str_replace('_',' ',$employee->employment_status)) }}</span></td></tr>
                <tr><td style="color:var(--text-muted);">Hire Date</td><td>{{ $employee->hire_date?->format('d M Y') }}</td></tr>
                <tr><td style="color:var(--text-muted);">Salary Grade</td><td>{{ $employee->salaryGrade->code ?? '—' }} {{ $employee->salaryGrade ? '('.$employee->salaryGrade->name.')' : '' }}</td></tr>
                <tr><td style="color:var(--text-muted);">Basic Salary</td><td>{{ $employee->currentSalary ? format_zmw((float)$employee->currentSalary->basic_salary) : '—' }}</td></tr>
            </table>
        </div>
    </div>
</div>

{{-- Portal Account Status --}}
@if(admin_can('manage_hr') || admin_can('super_admin'))
<div class="card" style="margin-top:20px;border-left:4px solid {{ $employee->portal_active ? '#16A34A' : '#9CA3AF' }};">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
        <span class="card-title"><i class="fas fa-id-card" style="margin-right:.4rem;"></i> Self-Service Portal Account</span>
        <a href="{{ route('admin.portal-accounts.index') }}?search={{ $employee->staff_number }}" class="btn btn-outline btn-sm">Manage</a>
    </div>
    <div class="card-body">
        <div style="display:flex;flex-wrap:wrap;gap:1.5rem;font-size:.85rem;">
            <div>
                <div style="color:var(--text-muted);font-size:.75rem;margin-bottom:.25rem;">Portal Access</div>
                @if($employee->portal_active)
                    <span class="badge badge-green"><i class="fas fa-check-circle"></i> Enabled</span>
                @else
                    <span class="badge badge-secondary"><i class="fas fa-ban"></i> Disabled</span>
                @endif
            </div>
            <div>
                <div style="color:var(--text-muted);font-size:.75rem;margin-bottom:.25rem;">Password</div>
                @if($employee->portal_password)
                    <span class="badge badge-blue"><i class="fas fa-key"></i> Custom password set</span>
                @else
                    <span class="badge badge-warning"><i class="fas fa-unlock"></i> Default ({{ strtolower($employee->staff_number) }})</span>
                @endif
            </div>
            <div>
                <div style="color:var(--text-muted);font-size:.75rem;margin-bottom:.25rem;">Last Portal Login</div>
                <div style="font-weight:600;">{{ $employee->portal_last_login?->format('d M Y, H:i') ?? 'Never logged in' }}</div>
            </div>
        </div>
        @if(!$employee->portal_active)
        <div style="margin-top:1rem;">
            <form method="POST" action="{{ route('admin.portal-accounts.activate', $employee) }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fas fa-check"></i> Activate Portal Access
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endif

{{-- Leave Requests --}}
<div class="card" style="margin-top:20px;">
    <div class="card-header">
        <span class="card-title">Leave History</span>
        @if(admin_can('manage_hr') || admin_can('view_leave'))
        <a href="{{ route('admin.leave.index') }}?employee_id={{ $employee->id }}" class="btn btn-sm btn-outline">All Leave</a>
        @endif
    </div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Type</th><th>From</th><th>To</th><th>Days</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($employee->leaveRequests->take(5) as $leave)
            <tr>
                <td>{{ $leave->leaveType->name ?? '—' }}</td>
                <td>{{ $leave->start_date?->format('d M Y') }}</td>
                <td>{{ $leave->end_date?->format('d M Y') }}</td>
                <td>{{ $leave->days_requested }}</td>
                <td><span class="badge badge-{{ $leave->status === 'approved' ? 'green' : ($leave->status === 'pending' ? 'orange' : 'red') }}">{{ ucfirst($leave->status) }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:var(--text-muted);">No leave records.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Recent Payslips --}}
@if(admin_can('view_payroll') || admin_can('manage_payroll'))
<div class="card" style="margin-top:20px;">
    <div class="card-header"><span class="card-title">Recent Payslips</span></div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Period</th><th>Gross</th><th>Deductions</th><th>Net Pay</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse($employee->payslips->take(6) as $slip)
            <tr>
                <td>{{ $slip->payrollRun->payrollPeriod->name ?? '—' }}</td>
                <td>{{ format_zmw((float)$slip->gross_salary) }}</td>
                <td>{{ format_zmw((float)$slip->total_deductions) }}</td>
                <td style="font-weight:600;">{{ format_zmw((float)$slip->net_salary) }}</td>
                <td><span class="badge badge-{{ $slip->isPaid() ? 'green' : 'orange' }}">{{ ucfirst($slip->status) }}</span></td>
                <td><a href="{{ route('admin.payroll.payslip', $slip) }}" class="btn btn-xs btn-outline">View</a></td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:var(--text-muted);">No payslips.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
