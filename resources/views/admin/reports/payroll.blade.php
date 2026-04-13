@extends('admin.layouts.app')
@section('title', 'Payroll Report')
@section('page-title', 'Reports')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Payroll Report</div>
        <div class="page-subtitle">Annual payroll summary — {{ $year }}</div>
    </div>
    <a href="{{ route('admin.reports.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Reports</a>
</div>

{{-- Year filter --}}
<div class="card" style="margin-bottom:1rem;">
    <div class="card-body" style="padding:.75rem 1rem;">
        <form method="GET" style="display:flex;gap:.75rem;align-items:flex-end;">
            <div class="form-group" style="margin:0;">
                <select name="year" class="form-control">
                    @foreach(range(now()->year - 2, now()->year) as $y)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
        </form>
    </div>
</div>

{{-- Summary stats --}}
<div class="stats-grid" style="margin-bottom:1.5rem;">
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-money-bill-wave"></i></div>
        <div><div class="stat-value">ZMW {{ number_format($data['total_net'] / 1000, 0) }}K</div><div class="stat-label">Total Net Paid</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-landmark"></i></div>
        <div><div class="stat-value">ZMW {{ number_format($data['total_tax'] / 1000, 0) }}K</div><div class="stat-label">Total Tax Deducted</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-minus-circle"></i></div>
        <div><div class="stat-value">ZMW {{ number_format($data['total_deductions'] / 1000, 0) }}K</div><div class="stat-label">Total Other Deductions</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-file-invoice"></i></div>
        <div><div class="stat-value">{{ $data['monthly_breakdown']->count() }}</div><div class="stat-label">Payroll Runs</div></div>
    </div>
</div>

{{-- Monthly breakdown --}}
<div class="card">
    <div class="card-header"><span class="card-title">Monthly Breakdown — {{ $year }}</span></div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Period</th>
                    <th>Employees</th>
                    <th style="text-align:right;">Basic (ZMW)</th>
                    <th style="text-align:right;">Allowances</th>
                    <th style="text-align:right;">Deductions</th>
                    <th style="text-align:right;">Tax</th>
                    <th style="text-align:right;">Net Pay</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @forelse($data['monthly_breakdown'] as $run)
            <tr>
                <td style="font-weight:600;">{{ $run->payrollPeriod->name ?? '—' }}</td>
                <td>{{ $run->employee_count }}</td>
                <td style="text-align:right;">{{ number_format($run->total_basic, 0) }}</td>
                <td style="text-align:right;">{{ number_format($run->total_allowances, 0) }}</td>
                <td style="text-align:right;">{{ number_format($run->total_deductions, 0) }}</td>
                <td style="text-align:right;">{{ number_format($run->total_tax, 0) }}</td>
                <td style="text-align:right;font-weight:700;color:var(--forest);">{{ number_format($run->total_net, 0) }}</td>
                <td><span class="badge badge-{{ $run->status === 'approved' ? 'success' : ($run->status === 'draft' ? 'gold' : 'grey') }}">{{ ucfirst($run->status) }}</span></td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;padding:2rem;color:var(--slate-mid);">No payroll runs for {{ $year }}.</td></tr>
            @endforelse
            </tbody>
            @if($data['monthly_breakdown']->count() > 1)
            <tfoot>
                <tr style="font-weight:700;background:var(--bg-alt);">
                    <td>Total</td>
                    <td>—</td>
                    <td style="text-align:right;">{{ number_format($data['monthly_breakdown']->sum('total_basic'), 0) }}</td>
                    <td style="text-align:right;">{{ number_format($data['monthly_breakdown']->sum('total_allowances'), 0) }}</td>
                    <td style="text-align:right;">{{ number_format($data['monthly_breakdown']->sum('total_deductions'), 0) }}</td>
                    <td style="text-align:right;">{{ number_format($data['monthly_breakdown']->sum('total_tax'), 0) }}</td>
                    <td style="text-align:right;color:var(--forest);">{{ number_format($data['monthly_breakdown']->sum('total_net'), 0) }}</td>
                    <td></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection
