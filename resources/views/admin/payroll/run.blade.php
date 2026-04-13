@extends('admin.layouts.app')
@section('title', 'Payroll Run')
@section('breadcrumb', 'Payroll / Run #' . $run->id)

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Payroll Run — {{ $run->payrollPeriod->name ?? '' }}</div>
        <div class="page-subtitle">Run by {{ $run->runBy->name ?? '—' }} on {{ $run->run_date?->format('d M Y H:i') }}</div>
    </div>
    <div style="display:flex;gap:8px;">
        @if($run->isDraft() && admin_can('manage_payroll'))
        <form method="POST" action="{{ route('admin.payroll.run.approve', $run) }}" onsubmit="return confirm('Approve this payroll run?')">
            @csrf @method('PATCH')
            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Approve Run</button>
        </form>
        @endif
        <a href="{{ route('admin.payroll.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

{{-- Summary stats --}}
<div class="stats-grid" style="margin-bottom:24px;">
    <div class="stat-card"><div class="stat-icon blue"><i class="fas fa-users"></i></div><div><div class="stat-value">{{ $run->employee_count }}</div><div class="stat-label">Employees</div></div></div>
    <div class="stat-card"><div class="stat-icon green"><i class="fas fa-arrow-up"></i></div><div><div class="stat-value">{{ number_format(($run->total_basic + $run->total_allowances)/1000,0) }}K</div><div class="stat-label">Total Gross (ZMW)</div></div></div>
    <div class="stat-card"><div class="stat-icon red"><i class="fas fa-arrow-down"></i></div><div><div class="stat-value">{{ number_format($run->total_deductions/1000,0) }}K</div><div class="stat-label">Total Deductions</div></div></div>
    <div class="stat-card"><div class="stat-icon teal"><i class="fas fa-wallet"></i></div><div><div class="stat-value">{{ number_format($run->total_net/1000,0) }}K</div><div class="stat-label">Total Net Pay</div></div></div>
    <div class="stat-card"><div class="stat-icon orange"><i class="fas fa-landmark"></i></div><div><div class="stat-value"><span class="badge badge-{{ $run->isDraft() ? 'orange' : ($run->isApproved() ? 'blue' : 'green') }}">{{ ucfirst($run->status) }}</span></div><div class="stat-label">Run Status</div></div></div>
</div>

<div class="card">
    <div class="card-header"><span class="card-title">Payslips ({{ $run->payslips->count() }})</span></div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Staff #</th><th>Employee</th><th>Department</th><th>Basic</th><th>Gross</th><th>Deductions</th><th>Net Pay</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @foreach($run->payslips as $slip)
            <tr>
                <td><code>{{ $slip->employee->staff_number }}</code></td>
                <td>{{ $slip->employee->full_name }}</td>
                <td>{{ $slip->employee->department->name ?? '—' }}</td>
                <td>{{ number_format($slip->basic_salary, 2) }}</td>
                <td>{{ number_format($slip->basic_salary + $slip->total_allowances, 2) }}</td>
                <td>{{ number_format($slip->total_deductions + $slip->total_tax, 2) }}</td>
                <td style="font-weight:700;">{{ number_format($slip->net_pay, 2) }}</td>
                <td><span class="badge badge-{{ $slip->isPaid() ? 'green' : 'orange' }}">{{ ucfirst($slip->status) }}</span></td>
                <td><a href="{{ route('admin.payroll.payslip', $slip) }}" class="btn btn-xs btn-outline">View</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
