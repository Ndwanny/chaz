@extends('admin.layouts.app')
@section('title', 'Payslip')
@section('breadcrumb', 'Payroll / Payslip')

@section('content')
<div class="page-header">
    <div><div class="page-title">Payslip</div><div class="page-subtitle">{{ $payslip->payrollRun->payrollPeriod->name ?? '' }}</div></div>
    <div style="display:flex;gap:8px;">
        <button onclick="window.print()" class="btn btn-outline"><i class="fas fa-print"></i> Print</button>
        <a href="{{ route('admin.payroll.run.show', $payslip->payrollRun) }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

<div class="card" style="max-width:780px;margin:0 auto;" id="payslip-print">
    <div class="card-body">
        {{-- Header --}}
        <div style="text-align:center;margin-bottom:24px;padding-bottom:16px;border-bottom:2px solid var(--primary);">
            <div style="font-size:1.2rem;font-weight:800;color:var(--primary);">CHAZ — Churches Health Association of Zambia</div>
            <div style="font-size:.84rem;color:var(--text-muted);">Employee Payslip — {{ $payslip->payrollRun->payrollPeriod->name ?? '' }}</div>
        </div>

        {{-- Employee Details --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
            <div>
                <div style="font-size:.78rem;color:var(--text-muted);">Employee Name</div>
                <div style="font-weight:600;">{{ $payslip->employee->full_name }}</div>
                <div style="font-size:.78rem;color:var(--text-muted);margin-top:8px;">Staff Number</div>
                <div>{{ $payslip->employee->staff_number }}</div>
                <div style="font-size:.78rem;color:var(--text-muted);margin-top:8px;">Department</div>
                <div>{{ $payslip->employee->department->name ?? '—' }}</div>
            </div>
            <div>
                <div style="font-size:.78rem;color:var(--text-muted);">Job Title</div>
                <div style="font-weight:600;">{{ $payslip->employee->job_title }}</div>
                <div style="font-size:.78rem;color:var(--text-muted);margin-top:8px;">Period End Date</div>
                <div>{{ $payslip->payrollRun->payrollPeriod->end_date?->format('d M Y') ?? '—' }}</div>
                <div style="font-size:.78rem;color:var(--text-muted);margin-top:8px;">Status</div>
                <div><span class="badge badge-{{ $payslip->isPaid() ? 'green' : 'orange' }}">{{ ucfirst($payslip->status) }}</span></div>
            </div>
        </div>

        {{-- Earnings --}}
        <table style="width:100%;margin-bottom:8px;">
            <thead><tr style="background:var(--primary-light);">
                <th style="padding:8px;text-align:left;">Earnings</th>
                <th style="padding:8px;text-align:right;">Amount (ZMW)</th>
            </tr></thead>
            <tbody>
            <tr><td style="padding:7px;">Basic Salary</td><td style="text-align:right;">{{ number_format($payslip->basic_salary, 2) }}</td></tr>
            @foreach($payslip->allowances as $item)
            <tr><td style="padding:7px;">{{ $item->name }}</td><td style="text-align:right;">{{ number_format($item->amount, 2) }}</td></tr>
            @endforeach
            <tr style="font-weight:700;background:var(--bg);">
                <td style="padding:8px;">Gross Salary</td>
                <td style="text-align:right;">{{ number_format($payslip->basic_salary + $payslip->total_allowances, 2) }}</td>
            </tr>
            </tbody>
        </table>

        {{-- Deductions --}}
        <table style="width:100%;margin-bottom:16px;">
            <thead><tr style="background:#fee2e2;">
                <th style="padding:8px;text-align:left;">Deductions</th>
                <th style="padding:8px;text-align:right;">Amount (ZMW)</th>
            </tr></thead>
            <tbody>
            @foreach($payslip->deductions as $item)
            <tr><td style="padding:7px;">{{ $item->name }}</td><td style="text-align:right;">{{ number_format($item->amount, 2) }}</td></tr>
            @endforeach
            @foreach($payslip->taxes as $item)
            <tr><td style="padding:7px;">{{ $item->name }}</td><td style="text-align:right;">{{ number_format($item->amount, 2) }}</td></tr>
            @endforeach
            <tr style="font-weight:700;background:var(--bg);">
                <td style="padding:8px;">Total Deductions</td>
                <td style="text-align:right;">{{ number_format($payslip->total_deductions + $payslip->total_tax, 2) }}</td>
            </tr>
            </tbody>
        </table>

        {{-- Net Pay --}}
        <div style="background:var(--primary);color:#fff;border-radius:8px;padding:16px 20px;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-size:1rem;font-weight:600;">NET PAY</span>
            <span style="font-size:1.5rem;font-weight:800;">ZMW {{ number_format($payslip->net_pay, 2) }}</span>
        </div>

        {{-- Employer contributions --}}
        @php $napsa = round($payslip->basic_salary * 0.05, 2); $nhima = round($payslip->basic_salary * 0.01, 2); @endphp
        <div style="margin-top:14px;padding:12px;background:var(--bg);border-radius:6px;font-size:.78rem;color:var(--text-muted);">
            Employer Contributions (not deducted from pay): NAPSA {{ number_format($napsa, 2) }} | NHIMA {{ number_format($nhima, 2) }}
        </div>

        <div style="margin-top:16px;text-align:center;font-size:.72rem;color:var(--text-muted);">
            This is a computer-generated payslip. No signature required. Generated on {{ now()->format('d M Y H:i') }}.
        </div>
    </div>
</div>

<style>@media print { .admin-sidebar, .admin-topbar, .page-header .btn, .page-header { display: none !important; } .admin-main { margin-left: 0 !important; } #payslip-print { box-shadow: none; max-width: 100%; } }</style>
@endsection
