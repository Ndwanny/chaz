@extends('portal.layouts.app')
@section('page_title', 'Payslip')
@section('breadcrumb', 'Payslips / ' . ($payslip->payrollPeriod->name ?? ''))

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
    <a href="{{ route('portal.payslips.index') }}" class="p-btn outline"><i class="fas fa-arrow-left"></i> Back</a>
    <button onclick="window.print()" class="p-btn outline"><i class="fas fa-print"></i> Print</button>
</div>

<div class="p-card" style="max-width:760px;margin:0 auto;" id="payslip-print">
    {{-- Header --}}
    <div style="text-align:center;padding-bottom:1.25rem;border-bottom:3px solid var(--portal-green);margin-bottom:1.5rem;">
        <div style="font-size:1.1rem;font-weight:800;color:var(--portal-green);">Churches Health Association of Zambia</div>
        <div style="font-size:.85rem;color:var(--portal-muted);margin-top:.25rem;">Employee Payslip — {{ $payslip->payrollPeriod->name ?? '' }}</div>
    </div>

    {{-- Employee info --}}
    <div class="payslip-info-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem;font-size:.85rem;">
        <div>
            <div style="color:var(--portal-muted);font-size:.72rem;margin-bottom:.15rem;">Employee Name</div>
            <div style="font-weight:700;">{{ $payslip->employee->full_name }}</div>
            <div style="color:var(--portal-muted);font-size:.72rem;margin-top:.6rem;margin-bottom:.15rem;">Staff Number</div>
            <div>{{ $payslip->employee->staff_number }}</div>
            <div style="color:var(--portal-muted);font-size:.72rem;margin-top:.6rem;margin-bottom:.15rem;">Department</div>
            <div>{{ $payslip->employee->department->name ?? '—' }}</div>
        </div>
        <div>
            <div style="color:var(--portal-muted);font-size:.72rem;margin-bottom:.15rem;">Designation</div>
            <div style="font-weight:600;">{{ $payslip->employee->designation ?? '—' }}</div>
            <div style="color:var(--portal-muted);font-size:.72rem;margin-top:.6rem;margin-bottom:.15rem;">Period</div>
            <div>{{ $payslip->payrollPeriod->name ?? '—' }}</div>
            <div style="color:var(--portal-muted);font-size:.72rem;margin-top:.6rem;margin-bottom:.15rem;">Date Issued</div>
            <div>{{ $payslip->issued_at?->format('d M Y') ?? '—' }}</div>
        </div>
    </div>

    {{-- Earnings --}}
    <table style="width:100%;border-collapse:collapse;font-size:.85rem;margin-bottom:.5rem;">
        <thead>
            <tr style="background:#F0FDF4;">
                <th style="padding:.6rem .75rem;text-align:left;font-size:.75rem;color:#065F46;">Earnings</th>
                <th style="padding:.6rem .75rem;text-align:right;font-size:.75rem;color:#065F46;">Amount (ZMW)</th>
            </tr>
        </thead>
        <tbody>
            <tr style="border-bottom:1px solid #F1F5F9;"><td style="padding:.55rem .75rem;">Basic Salary</td><td style="text-align:right;">{{ number_format($payslip->basic_salary, 2) }}</td></tr>
            @foreach($allowances as $item)
            <tr style="border-bottom:1px solid #F1F5F9;"><td style="padding:.55rem .75rem;">{{ $item->name }}</td><td style="text-align:right;">{{ number_format($item->amount, 2) }}</td></tr>
            @endforeach
            <tr style="background:#F0FDF4;font-weight:700;">
                <td style="padding:.65rem .75rem;">Gross Pay</td>
                <td style="text-align:right;">{{ number_format($payslip->basic_salary + $payslip->total_allowances, 2) }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Deductions --}}
    <table style="width:100%;border-collapse:collapse;font-size:.85rem;margin-bottom:1.25rem;">
        <thead>
            <tr style="background:#FFF1F2;">
                <th style="padding:.6rem .75rem;text-align:left;font-size:.75rem;color:#991B1B;">Deductions</th>
                <th style="padding:.6rem .75rem;text-align:right;font-size:.75rem;color:#991B1B;">Amount (ZMW)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($deductions as $item)
            <tr style="border-bottom:1px solid #F1F5F9;"><td style="padding:.55rem .75rem;">{{ $item->name }}</td><td style="text-align:right;">{{ number_format($item->amount, 2) }}</td></tr>
            @endforeach
            @foreach($taxes as $item)
            <tr style="border-bottom:1px solid #F1F5F9;"><td style="padding:.55rem .75rem;">{{ $item->name }}</td><td style="text-align:right;">{{ number_format($item->amount, 2) }}</td></tr>
            @endforeach
            <tr style="background:#FFF1F2;font-weight:700;">
                <td style="padding:.65rem .75rem;">Total Deductions</td>
                <td style="text-align:right;">{{ number_format($payslip->total_deductions + $payslip->total_tax, 2) }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Net Pay --}}
    <div style="background:var(--portal-green);color:#fff;border-radius:10px;padding:1.1rem 1.25rem;display:flex;justify-content:space-between;align-items:center;">
        <span style="font-weight:700;font-size:1rem;">NET PAY</span>
        <span style="font-weight:800;font-size:1.5rem;">ZMW {{ number_format($payslip->net_pay, 2) }}</span>
    </div>

    {{-- Working days info --}}
    <div style="margin-top:1rem;display:flex;gap:1.5rem;font-size:.78rem;color:var(--portal-muted);padding:.75rem;background:#F7FAFC;border-radius:8px;">
        <span>Working Days: <strong>{{ $payslip->working_days }}</strong></span>
        <span>Days Worked: <strong>{{ $payslip->days_worked }}</strong></span>
        @if($payslip->leave_days_deducted > 0)<span>Leave Deducted: <strong>{{ $payslip->leave_days_deducted }}</strong></span>@endif
    </div>

    <div style="margin-top:1rem;text-align:center;font-size:.72rem;color:var(--portal-muted);">
        This is a computer-generated payslip. No signature required.
    </div>
</div>

@push('styles')
<style>
#payslip-print { padding: 1rem; }
@media (max-width:600px) {
    #payslip-print .payslip-info-grid { grid-template-columns:1fr !important; }
}
@media print {
    .p-sidebar,.p-topbar,.p-hamburger,a.p-btn,button { display:none!important; }
    .p-main { margin-left:0!important; }
    #payslip-print { box-shadow:none; max-width:100%; padding:0; }
}
</style>
@endpush
@endsection
