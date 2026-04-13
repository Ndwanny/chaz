@extends('admin.layouts.app')
@section('title', 'Requisitions')
@section('breadcrumb', 'Procurement / Requisitions')

@section('content')
<div class="page-header">
    <div><div class="page-title">Purchase Requisitions</div><div class="page-subtitle">{{ $requisitions->total() }} requisitions</div></div>
    <a href="{{ route('admin.requisitions.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New Requisition</a>
</div>

<div class="filter-bar">
    <form method="GET" style="display:contents;">
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="">All</option>
                @foreach(['pending','approved','rejected','converted'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Department</label>
            <select name="department_id" class="form-control">
                <option value="">All Departments</option>
                @foreach($departments as $dept)
                <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-sm" style="align-self:flex-end;">Filter</button>
        <a href="{{ route('admin.requisitions.index') }}" class="btn btn-outline btn-sm" style="align-self:flex-end;">Reset</a>
    </form>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>REQ #</th><th>Department</th><th>Requested By</th><th>Purpose</th><th>Priority</th><th>Required By</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($requisitions as $req)
            @php $c=['pending'=>'orange','approved'=>'green','rejected'=>'red','converted'=>'blue']; $p=['low'=>'grey','normal'=>'blue','high'=>'orange','urgent'=>'red']; @endphp
            <tr>
                <td><code>{{ $req->req_number }}</code></td>
                <td>{{ $req->department->name ?? '—' }}</td>
                <td>{{ $req->requestedBy->name ?? '—' }}</td>
                <td>{{ \Str::limit($req->purpose, 50) }}</td>
                <td><span class="badge badge-{{ $p[$req->priority] ?? 'grey' }}">{{ ucfirst($req->priority) }}</span></td>
                <td>{{ $req->required_by?->format('d M Y') }}</td>
                <td><span class="badge badge-{{ $c[$req->status] ?? 'grey' }}">{{ ucfirst($req->status) }}</span></td>
                <td>
                    <a href="{{ route('admin.requisitions.show', $req) }}" class="btn btn-xs btn-outline"><i class="fas fa-eye"></i></a>
                    @if($req->isPending() && admin_can('manage_procurement'))
                    <form method="POST" action="{{ route('admin.requisitions.approve', $req) }}" style="display:inline;">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-xs btn-success">Approve</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:var(--text-muted);">No requisitions found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;">{{ $requisitions->links() }}</div>
</div>
@endsection
