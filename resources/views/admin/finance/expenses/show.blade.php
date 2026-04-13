@extends('admin.layouts.app')
@section('title', $expense->expense_number)
@section('breadcrumb', 'Finance / Expenses / ' . $expense->expense_number)

@section('content')
<div class="page-header">
    <div><div class="page-title">{{ $expense->expense_number }}</div></div>
    <a href="{{ route('admin.finance.expenses.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

@php $c=['pending'=>'orange','approved'=>'blue','paid'=>'green','rejected'=>'red']; @endphp

<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;">
    <div class="card">
        <div class="card-header"><span class="card-title">Expense Details</span></div>
        <div class="card-body">
            <table style="width:100%;font-size:.88rem;">
                <tr><td style="padding:6px 0;color:var(--text-muted);width:35%;">Expense #</td><td><code>{{ $expense->expense_number }}</code></td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Status</td><td><span class="badge badge-{{ $c[$expense->status] ?? 'grey' }}">{{ ucfirst($expense->status) }}</span></td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Description</td><td>{{ $expense->description }}</td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Amount</td><td><strong>ZMW {{ number_format($expense->amount, 2) }}</strong></td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Date</td><td>{{ $expense->expense_date?->format('d M Y') }}</td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Category</td><td>{{ $expense->category->name ?? '—' }}</td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Department</td><td>{{ $expense->department->name ?? '—' }}</td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Employee</td><td>{{ $expense->employee?->full_name ?? '—' }}</td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Budget Line</td><td>{{ $expense->budgetLine ? $expense->budgetLine->account_code . ' — ' . $expense->budgetLine->description : '—' }}</td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Payment Method</td><td>{{ $expense->payment_method ? ucfirst(str_replace('_',' ',$expense->payment_method)) : '—' }}</td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Receipt #</td><td>{{ $expense->receipt_number ?? '—' }}</td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Submitted By</td><td>{{ $expense->createdBy->name ?? '—' }}</td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Approved By</td><td>{{ $expense->approvedBy->name ?? '—' }}{{ $expense->approved_at ? ' on ' . $expense->approved_at->format('d M Y') : '' }}</td></tr>
                @if($expense->rejection_reason)
                <tr><td style="padding:6px 0;color:var(--text-muted);">Rejection Reason</td><td style="color:#dc2626;">{{ $expense->rejection_reason }}</td></tr>
                @endif
                @if($expense->notes)
                <tr><td style="padding:6px 0;color:var(--text-muted);">Notes</td><td>{{ $expense->notes }}</td></tr>
                @endif
            </table>
            @if($expense->receipt_document)
            <div style="margin-top:12px;">
                <a href="{{ Storage::url($expense->receipt_document) }}" target="_blank" class="btn btn-outline btn-sm"><i class="fas fa-paperclip"></i> View Receipt</a>
            </div>
            @endif
        </div>
    </div>

    <div>
        @if($expense->isPending() && admin_can('manage_finance'))
        <div class="card" style="margin-bottom:1rem;">
            <div class="card-header"><span class="card-title">Actions</span></div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:8px;">
                <form method="POST" action="{{ route('admin.finance.expenses.approve', $expense) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-success" style="width:100%;">Approve</button>
                </form>
                <form method="POST" action="{{ route('admin.finance.expenses.reject', $expense) }}" onsubmit="return document.getElementById('rej-reason').value !== ''">
                    @csrf @method('PATCH')
                    <textarea id="rej-reason" name="rejection_reason" class="form-control" rows="2" placeholder="Reason for rejection (required)" style="margin-bottom:6px;"></textarea>
                    <button type="submit" class="btn btn-danger" style="width:100%;">Reject</button>
                </form>
            </div>
        </div>
        @endif
        @if($expense->isApproved() && admin_can('manage_finance'))
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.finance.expenses.pay', $expense) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-primary" style="width:100%;">Mark as Paid</button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
