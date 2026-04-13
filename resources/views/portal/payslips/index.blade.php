@extends('portal.layouts.app')
@section('page_title', 'My Payslips')
@section('breadcrumb', 'Payslips')

@section('content')
<div class="p-card">
    <div class="p-card__header">
        <span class="p-card__title">All Payslips</span>
    </div>
    <div class="p-table-wrap"><table class="p-table">
        <thead>
            <tr>
                <th>Period</th>
                <th>Issued</th>
                <th>Gross Pay</th>
                <th>Deductions</th>
                <th>Net Pay</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse($payslips as $slip)
        <tr>
            <td style="font-weight:600;">{{ $slip->payrollPeriod->name ?? 'Period #' . $slip->payroll_period_id }}</td>
            <td>{{ $slip->issued_at?->format('d M Y') ?? '—' }}</td>
            <td>ZMW {{ number_format($slip->basic_salary + $slip->total_allowances, 2) }}</td>
            <td style="color:#DC2626;">- ZMW {{ number_format($slip->total_deductions + $slip->total_tax, 2) }}</td>
            <td style="font-weight:700;color:var(--portal-green);">ZMW {{ number_format($slip->net_pay, 2) }}</td>
            <td>
                @php $sc=['draft'=>'grey','issued'=>'green','paid'=>'blue']; @endphp
                <span class="p-badge {{ $sc[$slip->status] ?? 'grey' }}">{{ ucfirst($slip->status) }}</span>
            </td>
            <td>
                <a href="{{ route('portal.payslips.show', $slip) }}" class="p-btn outline sm"><i class="fas fa-eye"></i> View</a>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;color:var(--portal-muted);padding:2rem;">No payslips found.</td></tr>
        @endforelse
        </tbody>
    </table></div>
    <div style="padding:1rem 0;">{{ $payslips->links() }}</div>
</div>
@endsection
