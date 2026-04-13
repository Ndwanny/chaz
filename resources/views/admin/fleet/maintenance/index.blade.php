@extends('admin.layouts.app')
@section('title', 'Maintenance')
@section('breadcrumb', 'Fleet / Maintenance')

@section('content')
<div class="page-header">
    <div><div class="page-title">Vehicle Maintenance</div></div>
    @if(admin_can('manage_fleet'))
    <a href="{{ route('admin.fleet.maintenance.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Record</a>
    @endif
</div>

@if($upcoming->count())
<div class="card" style="margin-bottom:16px;border-left:4px solid var(--warning, #f59e0b);">
    <div class="card-header"><span class="card-title" style="color:#b45309;"><i class="fas fa-exclamation-triangle"></i> Due for Service (next 30 days)</span></div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Vehicle</th><th>Type</th><th>Due Date</th><th>Mileage Due</th></tr></thead>
            <tbody>
            @foreach($upcoming as $u)
            <tr>
                <td><strong>{{ $u->vehicle->registration_number ?? '—' }}</strong> — {{ $u->vehicle ? $u->vehicle->make . ' ' . $u->vehicle->model : '' }}</td>
                <td>{{ $u->type_label }}</td>
                <td>{{ $u->next_service_date?->format('d M Y') }}</td>
                <td>{{ $u->next_service_mileage ? number_format($u->next_service_mileage) . ' km' : '—' }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Filters --}}
<div class="card" style="margin-bottom:16px;">
    <div class="card-body">
        <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
            <div>
                <label style="font-size:.78rem;font-weight:600;">Vehicle</label>
                <select name="vehicle_id" class="form-control" style="min-width:180px;">
                    <option value="">All Vehicles</option>
                    @foreach($vehicles as $v)
                    <option value="{{ $v->id }}" {{ request('vehicle_id') == $v->id ? 'selected' : '' }}>{{ $v->registration_number }} — {{ $v->make }} {{ $v->model }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="font-size:.78rem;font-weight:600;">Status</label>
                <select name="status" class="form-control">
                    <option value="">All</option>
                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.fleet.maintenance.index') }}" class="btn btn-outline">Reset</a>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Vehicle</th><th>Type</th><th>Start Date</th><th>Workshop</th><th>Cost</th><th>Next Service</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse($records as $record)
            @php $statusColors = ['pending'=>'orange','in_progress'=>'blue','completed'=>'green','scheduled'=>'teal']; @endphp
            <tr>
                <td>
                    <div style="font-weight:600;">{{ $record->vehicle->registration_number ?? '—' }}</div>
                    <div style="font-size:.75rem;color:var(--text-muted);">{{ $record->vehicle ? $record->vehicle->make . ' ' . $record->vehicle->model : '' }}</div>
                </td>
                <td>{{ $record->type_label }}</td>
                <td>{{ $record->start_date?->format('d M Y') }}</td>
                <td>{{ $record->workshop ?? '—' }}</td>
                <td>ZMW {{ number_format($record->cost, 2) }}</td>
                <td>{{ $record->next_service_date?->format('d M Y') ?? '—' }}</td>
                <td><span class="badge badge-{{ $statusColors[$record->status] ?? 'grey' }}">{{ ucfirst(str_replace('_', ' ', $record->status)) }}</span></td>
                <td>
                    @if($record->status === 'in_progress' && admin_can('manage_fleet'))
                    <form method="POST" action="{{ route('admin.fleet.maintenance.complete', $record) }}" style="display:inline;" onsubmit="return confirm('Mark as completed?')">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-xs btn-success">Complete</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:var(--text-muted);">No maintenance records found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;">{{ $records->links() }}</div>
</div>
@endsection
