@extends('admin.layouts.app')
@section('title', 'Budgets')
@section('breadcrumb', 'Finance / Budgets')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Budgets</div>
        @if($activePeriod)<div class="page-subtitle">{{ $activePeriod->name }}</div>@endif
    </div>
    <div style="display:flex;gap:8px;">
        <a href="{{ route('admin.finance.budgets.periods') }}" class="btn btn-outline"><i class="fas fa-calendar-alt"></i> Periods</a>
        @if(admin_can('manage_finance'))
        <a href="{{ route('admin.finance.budgets.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New Budget</a>
        @endif
    </div>
</div>

{{-- Period filter --}}
@if($periods->count() > 1)
<div class="card" style="margin-bottom:16px;">
    <div class="card-body">
        <form method="GET" style="display:flex;gap:12px;align-items:flex-end;">
            <div>
                <label style="font-size:.78rem;font-weight:600;">Period</label>
                <select name="period_id" class="form-control" onchange="this.form.submit()">
                    @foreach($periods as $p)
                    <option value="{{ $p->id }}" {{ $periodId == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>
@endif

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Department</th><th>Period</th><th>Total Budget</th><th>Spent</th><th>Remaining</th><th>Utilisation</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse($budgets as $budget)
            @php $c=['draft'=>'grey','submitted'=>'orange','approved'=>'green','rejected'=>'red']; @endphp
            <tr>
                <td><strong>{{ $budget->department->name ?? '—' }}</strong></td>
                <td>{{ $budget->budgetPeriod->name ?? '—' }}</td>
                <td>ZMW {{ number_format($budget->total_budget, 2) }}</td>
                <td>ZMW {{ number_format($budget->total_spent, 2) }}</td>
                <td style="{{ $budget->remaining < 0 ? 'color:#dc2626;font-weight:700;' : '' }}">ZMW {{ number_format($budget->remaining, 2) }}</td>
                <td>
                    <div style="display:flex;align-items:center;gap:6px;">
                        <div style="flex:1;background:#e5e7eb;border-radius:4px;height:6px;"><div style="background:{{ $budget->utilization > 90 ? '#dc2626' : 'var(--primary)' }};width:{{ min($budget->utilization,100) }}%;height:6px;border-radius:4px;"></div></div>
                        <span style="font-size:.75rem;">{{ $budget->utilization }}%</span>
                    </div>
                </td>
                <td><span class="badge badge-{{ $c[$budget->status] ?? 'grey' }}">{{ ucfirst($budget->status) }}</span></td>
                <td style="white-space:nowrap;">
                    <a href="{{ route('admin.finance.budgets.show', $budget) }}" class="btn btn-xs btn-outline"><i class="fas fa-eye"></i></a>
                    @if($budget->status === 'draft' && admin_can('manage_finance'))
                    <form method="POST" action="{{ route('admin.finance.budgets.approve', $budget) }}" style="display:inline;">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-xs btn-success">Approve</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:var(--text-muted);">No budgets for this period.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;">{{ $budgets->links() }}</div>
</div>
@endsection
