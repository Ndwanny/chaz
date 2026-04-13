@extends('admin.layouts.app')
@section('title', 'Leave Management')
@section('breadcrumb', 'HR / Leave Management')

@section('content')
<div class="page-header">
    <div><div class="page-title">Leave Requests</div></div>
    <div style="display:flex;gap:8px;">
        @if(admin_can('manage_hr'))
        <a href="{{ route('admin.leave.types') }}" class="btn btn-outline"><i class="fas fa-list"></i> Leave Types</a>
        <a href="{{ route('admin.leave.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New Request</a>
        @endif
    </div>
</div>

<div class="filter-bar">
    <form method="GET" style="display:contents;">
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="">All</option>
                @foreach(['pending','approved','rejected','cancelled'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-sm" style="align-self:flex-end;">Filter</button>
        <a href="{{ route('admin.leave.index') }}" class="btn btn-outline btn-sm" style="align-self:flex-end;">Reset</a>
    </form>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Employee</th><th>Department</th><th>Leave Type</th><th>From</th><th>To</th><th>Days</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($requests as $req)
            <tr>
                <td>
                    <div style="font-weight:600;">{{ $req->employee->full_name ?? '—' }}</div>
                    <div style="font-size:.75rem;color:var(--text-muted);">{{ $req->employee->staff_number ?? '' }}</div>
                </td>
                <td>{{ $req->employee->department->name ?? '—' }}</td>
                <td>{{ $req->leaveType->name ?? '—' }}</td>
                <td>{{ $req->start_date?->format('d M Y') }}</td>
                <td>{{ $req->end_date?->format('d M Y') }}</td>
                <td>{{ $req->days_requested }}</td>
                <td>
                    @php $c=['pending'=>'orange','approved'=>'green','rejected'=>'red','cancelled'=>'grey']; @endphp
                    <span class="badge badge-{{ $c[$req->status] ?? 'grey' }}">{{ ucfirst($req->status) }}</span>
                </td>
                <td>
                    @if($req->isPending() && admin_can('manage_hr'))
                    <form method="POST" action="{{ route('admin.leave.approve', $req) }}" style="display:inline;">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-xs btn-success">Approve</button>
                    </form>
                    <button class="btn btn-xs btn-danger" onclick="document.getElementById('reject-{{ $req->id }}').style.display='block'">Reject</button>
                    <div id="reject-{{ $req->id }}" style="display:none;margin-top:6px;">
                        <form method="POST" action="{{ route('admin.leave.reject', $req) }}">
                            @csrf @method('PATCH')
                            <input type="text" name="rejection_reason" class="form-control" placeholder="Reason for rejection" required>
                            <button type="submit" class="btn btn-xs btn-danger" style="margin-top:4px;">Confirm Reject</button>
                        </form>
                    </div>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:var(--text-muted);">No leave requests.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;">{{ $requests->links() }}</div>
</div>
@endsection
