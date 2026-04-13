@extends('admin.layouts.app')
@section('title', 'Expenses')
@section('breadcrumb', 'Finance / Expenses')

@section('content')
<div class="page-header">
    <div><div class="page-title">Expense Claims</div></div>
    <a href="{{ route('admin.finance.expenses.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Submit Expense</a>
</div>

<div class="stats-grid" style="margin-bottom:20px;">
    <div class="stat-card"><div class="stat-icon orange"><i class="fas fa-hourglass-half"></i></div><div><div class="stat-value">ZMW {{ number_format($totals['pending'], 2) }}</div><div class="stat-label">Pending</div></div></div>
    <div class="stat-card"><div class="stat-icon blue"><i class="fas fa-thumbs-up"></i></div><div><div class="stat-value">ZMW {{ number_format($totals['approved'], 2) }}</div><div class="stat-label">Approved</div></div></div>
    <div class="stat-card"><div class="stat-icon green"><i class="fas fa-check-double"></i></div><div><div class="stat-value">ZMW {{ number_format($totals['paid'], 2) }}</div><div class="stat-label">Paid</div></div></div>
</div>

<div class="card" style="margin-bottom:16px;">
    <div class="card-body">
        <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
            <div>
                <label style="font-size:.78rem;font-weight:600;">Status</label>
                <select name="status" class="form-control">
                    <option value="">All</option>
                    @foreach(['pending','approved','paid','rejected'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="font-size:.78rem;font-weight:600;">Category</label>
                <select name="expense_category_id" class="form-control">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('expense_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="font-size:.78rem;font-weight:600;">Department</label>
                <select name="department_id" class="form-control">
                    <option value="">All</option>
                    @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.finance.expenses.index') }}" class="btn btn-outline">Reset</a>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>#</th><th>Description</th><th>Department</th><th>Category</th><th>Date</th><th>Amount (ZMW)</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse($expenses as $exp)
            <tr>
                <td><code>{{ $exp->expense_number }}</code></td>
                <td>
                    <div style="font-weight:600;">{{ Str::limit($exp->description, 60) }}</div>
                    <div style="font-size:.75rem;color:var(--text-muted);">By {{ $exp->createdBy->name ?? '—' }}</div>
                </td>
                <td>{{ $exp->department->name ?? '—' }}</td>
                <td>{{ $exp->category->name ?? '—' }}</td>
                <td>{{ $exp->expense_date?->format('d M Y') }}</td>
                <td style="font-weight:700;">{{ number_format($exp->amount, 2) }}</td>
                <td>
                    @php $c=['pending'=>'orange','approved'=>'blue','paid'=>'green','rejected'=>'red']; @endphp
                    <span class="badge badge-{{ $c[$exp->status] ?? 'grey' }}">{{ ucfirst($exp->status) }}</span>
                </td>
                <td style="white-space:nowrap;">
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
