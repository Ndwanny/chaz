@extends('admin.layouts.app')
@section('title', 'Finance Report')
@section('page-title', 'Reports')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Finance Report</div>
        <div class="page-subtitle">Expenses and procurement — {{ $year }}</div>
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

{{-- Stats --}}
<div class="stats-grid" style="margin-bottom:1.5rem;">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-receipt"></i></div>
        <div><div class="stat-value">ZMW {{ number_format($data['total_expenses'] / 1000, 0) }}K</div><div class="stat-label">Total Expenses</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
        <div><div class="stat-value">ZMW {{ number_format($data['paid_expenses'] / 1000, 0) }}K</div><div class="stat-label">Paid Expenses</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-clock"></i></div>
        <div><div class="stat-value">ZMW {{ number_format($data['pending_expenses'] / 1000, 0) }}K</div><div class="stat-label">Pending Approval</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon teal"><i class="fas fa-shopping-cart"></i></div>
        <div><div class="stat-value">ZMW {{ number_format($data['po_total'] / 1000, 0) }}K</div><div class="stat-label">Purchase Orders</div></div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">

    {{-- By Department --}}
    <div class="card">
        <div class="card-header"><span class="card-title">Expenses by Department</span></div>
        <div class="table-responsive">
            <table>
                <thead><tr><th>Department</th><th style="text-align:right;">Total (ZMW)</th></tr></thead>
                <tbody>
                @forelse($data['by_department']->sortByDesc('total') as $row)
                <tr>
                    <td style="font-size:.875rem;">{{ $row->department->name ?? 'Unknown' }}</td>
                    <td style="text-align:right;font-weight:600;">{{ number_format($row->total, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="2" style="text-align:center;padding:1.5rem;color:var(--slate-mid);">No data</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- By Category --}}
    <div class="card">
        <div class="card-header"><span class="card-title">Expenses by Category</span></div>
        <div class="table-responsive">
            <table>
                <thead><tr><th>Category</th><th style="text-align:right;">Total (ZMW)</th></tr></thead>
                <tbody>
                @forelse($data['by_category']->sortByDesc('total') as $row)
                <tr>
                    <td style="font-size:.875rem;">{{ $row->category->name ?? 'Unknown' }}</td>
                    <td style="text-align:right;font-weight:600;">{{ number_format($row->total, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="2" style="text-align:center;padding:1.5rem;color:var(--slate-mid);">No data</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('styles')
<style>
@media (max-width: 768px) {
    div[style*="grid-template-columns:1fr 1fr"] { grid-template-columns: 1fr !important; }
}
</style>
@endpush
@endsection
