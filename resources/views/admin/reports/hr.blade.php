@extends('admin.layouts.app')
@section('title', 'HR Report')
@section('page-title', 'Reports')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">HR Report</div>
        <div class="page-subtitle">Workforce overview — {{ now()->format('F Y') }}</div>
    </div>
    <a href="{{ route('admin.reports.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Reports</a>
</div>

{{-- Department filter --}}
<div class="card" style="margin-bottom:1rem;">
    <div class="card-body" style="padding:.75rem 1rem;">
        <form method="GET" style="display:flex;gap:.75rem;align-items:flex-end;flex-wrap:wrap;">
            <div class="form-group" style="margin:0;flex:1;min-width:200px;">
                <select name="department_id" class="form-control">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ $deptId == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
            @if($deptId)
            <a href="{{ route('admin.reports.hr') }}" class="btn btn-outline">Clear</a>
            @endif
        </form>
    </div>
</div>

{{-- Stats --}}
<div class="stats-grid" style="margin-bottom:1.5rem;">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-users"></i></div>
        <div><div class="stat-value">{{ $data['total_employees'] }}</div><div class="stat-label">Active Employees</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-user-clock"></i></div>
        <div><div class="stat-value">{{ $data['on_probation'] }}</div><div class="stat-label">Interns / Probation</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-calendar-check"></i></div>
        <div><div class="stat-value">{{ $data['leave_summary']->where('status','approved')->first()?->total ?? 0 }}</div><div class="stat-label">Leave Approved ({{ now()->year }})</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-calendar-times"></i></div>
        <div><div class="stat-value">{{ $data['leave_summary']->where('status','pending')->first()?->total ?? 0 }}</div><div class="stat-label">Leave Pending</div></div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1.25rem;">

    {{-- By Department --}}
    <div class="card">
        <div class="card-header"><span class="card-title">By Department</span></div>
        <div class="table-responsive">
            <table>
                <thead><tr><th>Department</th><th style="text-align:right;">Count</th></tr></thead>
                <tbody>
                @foreach($data['by_department']->sortByDesc('total') as $row)
                <tr>
                    <td style="font-size:.875rem;">{{ $row->department->name ?? 'Unknown' }}</td>
                    <td style="text-align:right;font-weight:600;">{{ $row->total }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- By Employment Type --}}
    <div class="card">
        <div class="card-header"><span class="card-title">By Employment Type</span></div>
        <div class="table-responsive">
            <table>
                <thead><tr><th>Type</th><th style="text-align:right;">Count</th></tr></thead>
                <tbody>
                @foreach($data['by_type'] as $row)
                <tr>
                    <td style="font-size:.875rem;text-transform:capitalize;">{{ str_replace('_', ' ', $row->employment_type ?? 'Unknown') }}</td>
                    <td style="text-align:right;font-weight:600;">{{ $row->total }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- By Gender --}}
    <div class="card">
        <div class="card-header"><span class="card-title">By Gender</span></div>
        <div class="table-responsive">
            <table>
                <thead><tr><th>Gender</th><th style="text-align:right;">Count</th></tr></thead>
                <tbody>
                @foreach($data['by_gender'] as $row)
                <tr>
                    <td style="font-size:.875rem;text-transform:capitalize;">{{ $row->gender ?? 'Not specified' }}</td>
                    <td style="text-align:right;font-weight:600;">{{ $row->total }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-header" style="margin-top:.5rem;border-top:1px solid var(--border);"><span class="card-title">Leave Summary ({{ now()->year }})</span></div>
        <div class="table-responsive">
            <table>
                <thead><tr><th>Status</th><th style="text-align:right;">Requests</th></tr></thead>
                <tbody>
                @foreach($data['leave_summary'] as $row)
                <tr>
                    <td><span class="badge badge-{{ $row->status === 'approved' ? 'success' : ($row->status === 'pending' ? 'gold' : 'secondary') }}">{{ ucfirst($row->status) }}</span></td>
                    <td style="text-align:right;font-weight:600;">{{ $row->total }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('styles')
<style>
@media (max-width: 900px) {
    div[style*="grid-template-columns:1fr 1fr 1fr"] { grid-template-columns: 1fr !important; }
}
</style>
@endpush
@endsection
