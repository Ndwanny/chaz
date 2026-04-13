@extends('admin.layouts.app')
@section('title', 'Budget — ' . ($budget->department->name ?? ''))
@section('breadcrumb', 'Finance / Budgets / ' . ($budget->department->name ?? ''))

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">{{ $budget->department->name ?? 'Budget' }}</div>
        <div class="page-subtitle">{{ $budget->budgetPeriod->name ?? '' }}</div>
    </div>
    <div style="display:flex;gap:8px;">
        @if($budget->status === 'draft' && admin_can('manage_finance'))
        <form method="POST" action="{{ route('admin.finance.budgets.approve', $budget) }}">
            @csrf @method('PATCH')
            <button type="submit" class="btn btn-success">Approve Budget</button>
        </form>
        @endif
        <a href="{{ route('admin.finance.budgets.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

@php $c=['draft'=>'grey','submitted'=>'orange','approved'=>'green','rejected'=>'red']; @endphp

<div class="stats-grid" style="margin-bottom:24px;">
    <div class="stat-card"><div class="stat-icon blue"><i class="fas fa-wallet"></i></div><div><div class="stat-value">ZMW {{ number_format($budget->total_budget, 2) }}</div><div class="stat-label">Total Budget</div></div></div>
    <div class="stat-card"><div class="stat-icon orange"><i class="fas fa-coins"></i></div><div><div class="stat-value">ZMW {{ number_format($budget->total_spent, 2) }}</div><div class="stat-label">Spent</div></div></div>
    <div class="stat-card"><div class="stat-icon {{ $budget->remaining < 0 ? 'red' : 'green' }}"><i class="fas fa-balance-scale"></i></div><div><div class="stat-value">ZMW {{ number_format($budget->remaining, 2) }}</div><div class="stat-label">Remaining</div></div></div>
    <div class="stat-card"><div class="stat-icon teal"><i class="fas fa-chart-pie"></i></div><div><div class="stat-value">{{ $budget->utilization }}%</div><div class="stat-label">Utilisation</div></div></div>
</div>

<div class="card" style="margin-bottom:1.5rem;">
    <div class="card-header"><span class="card-title">Budget Lines</span></div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Account Code</th><th>Description</th><th>Budgeted</th><th>Spent</th><th>Remaining</th><th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th></tr></thead>
            <tbody>
            @forelse($budget->lines as $line)
            <tr>
                <td><code>{{ $line->account_code }}</code></td>
                <td>{{ $line->description }}</td>
                <td>{{ number_format($line->budgeted_amount, 2) }}</td>
                <td>{{ number_format($line->spent_amount, 2) }}</td>
                <td style="{{ $line->remaining < 0 ? 'color:#dc2626;font-weight:700;' : '' }}">{{ number_format($line->remaining, 2) }}</td>
                <td>{{ $line->q1_budget ? number_format($line->q1_budget, 2) : '—' }}</td>
                <td>{{ $line->q2_budget ? number_format($line->q2_budget, 2) : '—' }}</td>
                <td>{{ $line->q3_budget ? number_format($line->q3_budget, 2) : '—' }}</td>
                <td>{{ $line->q4_budget ? number_format($line->q4_budget, 2) : '—' }}</td>
            </tr>
            @empty
            <tr><td colspan="9" style="text-align:center;color:var(--text-muted);">No budget lines.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header"><span class="card-title">Expenses Against This Budget</span></div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>#</th><th>Description</th><th>Date</th><th>Amount</th><th>Status</th></tr></thead>
            <tbody>
            @php $allExpenses = $budget->lines->flatMap(fn($l) => $l->expenses); @endphp
            @forelse($allExpenses as $exp)
            @php $ec=['pending'=>'orange','approved'=>'blue','paid'=>'green','rejected'=>'red']; @endphp
            <tr>
                <td><code>{{ $exp->expense_number }}</code></td>
                <td>{{ Str::limit($exp->description, 60) }}</td>
                <td>{{ $exp->expense_date?->format('d M Y') }}</td>
                <td>ZMW {{ number_format($exp->amount, 2) }}</td>
                <td><span class="badge badge-{{ $ec[$exp->status] ?? 'grey' }}">{{ ucfirst($exp->status) }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:var(--text-muted);">No expenses recorded.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
