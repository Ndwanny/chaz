@extends('admin.layouts.app')
@section('title', 'Fuel Logs')
@section('breadcrumb', 'Fleet / Fuel')

@section('content')
<div class="page-header">
    <div><div class="page-title">Fuel Logs</div></div>
    @if(admin_can('manage_fleet'))
    <a href="{{ route('admin.fleet.fuel.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Record Fuel</a>
    @endif
</div>

{{-- Summary stats --}}
<div class="stats-grid" style="margin-bottom:24px;">
    <div class="stat-card"><div class="stat-icon blue"><i class="fas fa-gas-pump"></i></div><div><div class="stat-value">{{ number_format($totalLitres, 1) }}L</div><div class="stat-label">Total Litres</div></div></div>
    <div class="stat-card"><div class="stat-icon green"><i class="fas fa-coins"></i></div><div><div class="stat-value">ZMW {{ number_format($totalCost, 2) }}</div><div class="stat-label">Total Cost</div></div></div>
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
                    <option value="{{ $v->id }}" {{ request('vehicle_id') == $v->id ? 'selected' : '' }}>{{ $v->registration_number }} — {{ $v->make }} {{ $v->model }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="font-size:.78rem;font-weight:600;">Month</label>
                <input type="month" name="month" class="form-control" value="{{ request('month') }}">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.fleet.fuel.index') }}" class="btn btn-outline">Reset</a>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Date</th><th>Vehicle</th><th>Driver</th><th>Litres</th><th>Unit Cost</th><th>Total Cost</th><th>Odometer</th><th>Station</th><th>Receipt</th></tr>
            </thead>
            <tbody>
            @forelse($logs as $log)
            <tr>
                <td>{{ $log->log_date?->format('d M Y') }}</td>
                <td>
                    <div style="font-weight:600;">{{ $log->vehicle->registration_number ?? '—' }}</div>
                    <div style="font-size:.75rem;color:var(--text-muted);">{{ $log->vehicle ? $log->vehicle->make . ' ' . $log->vehicle->model : '' }}</div>
                </td>
                <td>{{ $log->driver?->full_name ?? '—' }}</td>
                <td>{{ number_format($log->litres, 2) }}L</td>
                <td>{{ number_format($log->unit_cost, 2) }}</td>
                <td style="font-weight:700;">{{ number_format($log->total_cost, 2) }}</td>
                <td>{{ $log->odometer_reading ? number_format($log->odometer_reading) . ' km' : '—' }}</td>
                <td>{{ $log->fuel_station ?? '—' }}</td>
                <td><code>{{ $log->receipt_number ?? '—' }}</code></td>
            </tr>
            @empty
            <tr><td colspan="9" style="text-align:center;color:var(--text-muted);">No fuel records found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;">{{ $logs->links() }}</div>
</div>
@endsection
