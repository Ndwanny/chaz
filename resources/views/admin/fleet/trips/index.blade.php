@extends('admin.layouts.app')
@section('title', 'Trips')
@section('breadcrumb', 'Fleet / Trips')

@section('content')
<div class="page-header">
    <div><div class="page-title">Trip Logs</div></div>
    @if(admin_can('manage_fleet'))
    <a href="{{ route('admin.fleet.trips.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New Trip</a>
    @endif
</div>

{{-- Filters --}}
<div class="card" style="margin-bottom:16px;">
    <div class="card-body">
        <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
            <div>
                <label style="font-size:.78rem;font-weight:600;">Vehicle</label>
                <select name="vehicle_id" class="form-control" style="min-width:180px;">
                    <option value="">All Vehicles</option>
                    @foreach($vehicles as $v)
                    <option value="{{ $v->id }}" {{ request('vehicle_id') == $v->id ? 'selected' : '' }}>{{ $v->registration_number }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="font-size:.78rem;font-weight:600;">Status</label>
                <select name="status" class="form-control">
                    <option value="">All</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.fleet.trips.index') }}" class="btn btn-outline">Reset</a>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Trip #</th><th>Vehicle</th><th>Driver</th><th>Destination</th><th>Departure</th><th>Distance</th><th>Status</th><th></th></tr></thead>
            <tbody>
            @forelse($trips as $trip)
            @php $statusColors = ['pending'=>'orange','approved'=>'blue','ongoing'=>'teal','completed'=>'green','cancelled'=>'red']; @endphp
            <tr>
                <td><code>{{ $trip->trip_number }}</code></td>
                <td>{{ $trip->vehicle->registration_number ?? '—' }}</td>
                <td>{{ $trip->driver?->full_name ?? '—' }}</td>
                <td>
                    <div>{{ $trip->destination }}</div>
                    <div style="font-size:.75rem;color:var(--text-muted);">from {{ $trip->departure_location }}</div>
                </td>
                <td>{{ $trip->departure_date?->format('d M Y') }}</td>
                <td>{{ $trip->distance_km ? number_format($trip->distance_km) . ' km' : '—' }}</td>
                <td><span class="badge badge-{{ $statusColors[$trip->status] ?? 'grey' }}">{{ ucfirst($trip->status) }}</span></td>
                <td style="white-space:nowrap;">
                    @if(admin_can('manage_fleet'))
                        @if($trip->status === 'pending')
                        <form method="POST" action="{{ route('admin.fleet.trips.approve', $trip) }}" style="display:inline;">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-xs btn-success">Approve</button>
                        </form>
                        @elseif($trip->status === 'approved')
                        <form method="POST" action="{{ route('admin.fleet.trips.depart', $trip) }}" style="display:inline;">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-xs btn-primary">Depart</button>
                        </form>
                        @elseif($trip->status === 'ongoing')
                        <button type="button" class="btn btn-xs btn-outline" onclick="document.getElementById('complete-{{ $trip->id }}').style.display='block'">Complete</button>
                        <form id="complete-{{ $trip->id }}" method="POST" action="{{ route('admin.fleet.trips.complete', $trip) }}" style="display:none;margin-top:4px;">
                            @csrf @method('PATCH')
                            <input type="number" name="ending_odometer" placeholder="End odometer (km)" class="form-control" style="width:160px;display:inline-block;" required>
                            <button type="submit" class="btn btn-xs btn-success">Save</button>
                        </form>
                        @endif
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:var(--text-muted);">No trips found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;">{{ $trips->links() }}</div>
</div>
@endsection
