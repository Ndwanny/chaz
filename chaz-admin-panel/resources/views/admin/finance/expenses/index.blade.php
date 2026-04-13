@extends('admin.layouts.app')
@section('title', 'Expenses')
@section('breadcrumb', 'Finance / Expenses')

@section('content')
<div class="page-header">
    <div><div class="page-title">Expense Claims</div></div>
    <a href="{{ route('admin.finance.expenses.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Submit Expense</a>
</div>

{{-- Summary Cards --}}
<div class="stats-grid" style="margin-bottom:20px;">
    <div class="stat-card"><div class="stat-icon orange"><i class="fas fa-hourglass-half"></i></div><div><div class="stat-value">{{ format_zmw($totals['pending']) }}</div><div class="stat-label">Pending</div></div></div>
    <div class="stat-card"><div class="stat-icon blue"><i class="fas fa-thumbs-up"></i></div><div><div class="stat-value">{{ format_zmw($totals['approved']) }}</div><div class="stat-label">Approved</div></div></div>
    <div class="stat-card"><div class="stat-icon green"><i class="fas fa-check-double"></i></div><div><div class="stat-value">{{ format_zmw($totals['paid']) }}</div><div class="stat-label">Paid</div></div></div>
</div>

<div class="filter-bar">
    <form method="GET" style="display:contents;">
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="">All</option>
                @foreach(['pending','approved','paid','rejected'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Category</label>
            <select name="category_id" class="form-control">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Department</label>
            <select name="department_id" class="form-control">
                <option value="">All</option>
                @foreach($departments as $dept)
                <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-sm" style="align-self:flex-end;">Filter</button>
        <a href="{{ route('admin.finance.expenses.index') }}" class="btn btn-outline btn-sm" style="align-self:flex-end;">Reset</a>
    </form>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>#</th><th>Title</th><th>Department</th><th>Category</th><th>Date</th><th>Amount (ZMW)</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($expenses as $exp)
            <tr>
                <td><code>{{ $exp->exp_number }}</code></td>
                <td>
                    <div style="font-weight:600;">{{ $exp->title }}</div>
                    <div style="font-size:.75rem;color:var(--text-muted);">By {{ $exp->submittedBy->name ?? '—' }}</div>
                </td>
                <td>{{ $exp->department->name ?? '—' }}</td>
                <td>{{ $exp->category->name ?? '—' }}</td>
                <td>{{ $exp->expense_date?->format('d M Y') }}</td>
                <td>{{ number_format($exp->amount_zmw, 2) }}</td>
                <td>
                    @php $c=['pending'=>'orange','approved'=>'blue','paid'=>'green','rejected'=>'red']; @endphp
                    <span class="badge badge-{{ $c[$exp->status] ?? 'grey' }}">{{ ucfirst($exp->status) }}</span>
                </td>
                <td>
                    <a href="{{ route('admin.finance.expenses.show', $exp) }}" class="btn btn-xs btn-outline"><i class="fas fa-eye"></i></a>
                    @if($exp->isPending() && admin_can('manage_finance'))
                    <form method="POST" action="{{ route('admin.finance.expenses.approve', $exp) }}" style="display:inline;">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-xs btn-success">Approve</button>
                    </form>
                    @endif
                    @if($exp->isApproved() && admin_can('manage_finance'))
                    <form method="POST" action="{{ route('admin.finance.expenses.pay', $exp) }}" style="display:inline;">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-xs btn-primary">Mark Paid</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:var(--text-muted);">No expenses found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;">{{ $expenses->links() }}</div>
</div>
@endsection
