@extends('admin.layouts.app')
@section('title', 'Budget Periods')
@section('breadcrumb', 'Finance / Budget Periods')

@section('content')
<div class="page-header">
    <div><div class="page-title">Budget Periods</div></div>
    <a href="{{ route('admin.finance.budgets.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back to Budgets</a>
</div>

@if(admin_can('manage_finance'))
<div class="card" style="max-width:600px;margin-bottom:24px;">
    <div class="card-header"><span class="card-title">Create New Period</span></div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.finance.budgets.periods.store') }}">
            @csrf
            @if($errors->any())
            <div style="margin-bottom:12px;padding:10px 14px;background:#fee2e2;border-radius:6px;color:#991b1b;font-size:.85rem;">
                <ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                <div style="grid-column:1/-1;">
                    <label class="form-label">Period Name <span style="color:red;">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Financial Year 2026/2027" required>
                </div>
                <div>
                    <label class="form-label">Financial Year <span style="color:red;">*</span></label>
                    <input type="text" name="financial_year" class="form-control" value="{{ old('financial_year') }}" placeholder="2026/2027" maxlength="9" required>
                </div>
                <div>
                    <label class="form-label">Start Date <span style="color:red;">*</span></label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                </div>
                <div>
                    <label class="form-label">End Date <span style="color:red;">*</span></label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                </div>
            </div>
            <div style="margin-top:14px;">
                <button type="submit" class="btn btn-primary">Create Period</button>
            </div>
        </form>
    </div>
</div>
@endif

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Name</th><th>Financial Year</th><th>Start</th><th>End</th><th>Budgets</th><th>Active</th></tr></thead>
            <tbody>
            @forelse($periods as $period)
            <tr>
                <td><strong>{{ $period->name }}</strong></td>
                <td>{{ $period->financial_year }}</td>
                <td>{{ $period->start_date?->format('d M Y') }}</td>
                <td>{{ $period->end_date?->format('d M Y') }}</td>
                <td>{{ $period->budgets_count }}</td>
                <td>
                    @if($period->is_active)
                    <span class="badge badge-green">Active</span>
                    @else
                    <span class="badge badge-grey">Inactive</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:var(--text-muted);">No periods created yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
