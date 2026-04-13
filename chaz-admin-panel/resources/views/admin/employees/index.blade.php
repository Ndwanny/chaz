@extends('admin.layouts.app')
@section('title', 'Employees')
@section('breadcrumb', 'HR / Employees')

@section('content')
<div class="page-header">
    <div><div class="page-title">Employees</div><div class="page-subtitle">{{ $employees->total() }} records</div></div>
    @if(admin_can('manage_employees'))
    <a href="{{ route('admin.employees.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Employee</a>
    @endif
</div>

<div class="filter-bar">
    <form method="GET" style="display:contents;">
        <div class="form-group">
            <label>Department</label>
            <select name="department_id" class="form-control">
                <option value="">All Departments</option>
                @foreach($departments as $dept)
                <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="">All</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="on_leave" {{ request('status') === 'on_leave' ? 'selected' : '' }}>On Leave</option>
                <option value="terminated" {{ request('status') === 'terminated' ? 'selected' : '' }}>Terminated</option>
            </select>
        </div>
        <div class="form-group">
            <label>Search</label>
            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Name or staff number…">
        </div>
        <div class="form-group" style="justify-content:flex-end;">
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            <a href="{{ route('admin.employees.index') }}" class="btn btn-outline btn-sm">Reset</a>
        </div>
    </form>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Staff #</th><th>Name</th><th>Department</th><th>Job Title</th><th>Type</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($employees as $emp)
            <tr>
                <td><code>{{ $emp->staff_number }}</code></td>
                <td>
                    <div style="font-weight:600;">{{ $emp->full_name }}</div>
                    <div style="font-size:.75rem;color:var(--text-muted);">{{ $emp->email }}</div>
                </td>
                <td>{{ $emp->department->name ?? '—' }}</td>
                <td>{{ $emp->job_title }}</td>
                <td><span class="badge badge-blue">{{ ucfirst($emp->employment_type) }}</span></td>
                <td>
                    @php $statusColors = ['active'=>'green','on_leave'=>'orange','suspended'=>'red','terminated'=>'red','resigned'=>'grey']; @endphp
                    <span class="badge badge-{{ $statusColors[$emp->employment_status] ?? 'grey' }}">{{ ucfirst(str_replace('_',' ',$emp->employment_status)) }}</span>
                </td>
                <td>
                    <a href="{{ route('admin.employees.show', $emp) }}" class="btn btn-sm btn-outline"><i class="fas fa-eye"></i></a>
                    @if(admin_can('manage_employees'))
                    <a href="{{ route('admin.employees.edit', $emp) }}" class="btn btn-sm btn-outline"><i class="fas fa-pen"></i></a>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:var(--text-muted);">No employees found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;">{{ $employees->links() }}</div>
</div>
@endsection
