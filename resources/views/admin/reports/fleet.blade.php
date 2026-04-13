@extends('admin.layouts.app')
@section('title', 'Fleet Report')
@section('page-title', 'Reports')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Fleet Report</div>
        <div class="page-subtitle">Vehicle and fuel usage — {{ $year }}</div>
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
        <div class="stat-icon blue"><i class="fas fa-car"></i></div>
        <div><div class="stat-value">{{ $data['total_vehicles'] }}</div><div class="stat-label">Total Vehicles</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-car-side"></i></div>
        <div><div class="stat-value">{{ $data['active_vehicles'] }}</div><div class="stat-label">Active / Available</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-gas-pump"></i></div>
        <div><div class="stat-value">{{ number_format($data['total_fuel_litres'], 0) }} L</div><div class="stat-label">Fuel Used ({{ $year }})</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-money-bill-wave"></i></div>
        <div><div class="stat-value">ZMW {{ number_format($data['total_fuel_cost'], 0) }}</div><div class="stat-label">Fuel Cost ({{ $year }})</div></div>
    </div>
</div>

{{-- Fuel by vehicle --}}
<div class="card">
    <div class="card-header"><span class="card-title">Fuel Usage by Vehicle — {{ $year }}</span></div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Vehicle</th>
                    <th>Registration</th>
                    <th style="text-align:right;">Litres</th>
                    <th style="text-align:right;">Cost (ZMW)</th>
                    <th style="text-align:right;">Avg Cost/L</th>
                </tr>
            </thead>
            <tbody>
            @forelse($data['fuel_by_vehicle']->sortByDesc('cost') as $row)
            <tr>
                <td style="font-size:.875rem;">{{ $row->vehicle->make ?? '—' }} {{ $row->vehicle->model ?? '' }}</td>
                <td><code>{{ $row->vehicle->registration_number ?? '—' }}</code></td>
                <td style="text-align:right;">{{ number_format($row->litres, 1) }}</td>
                <td style="text-align:right;font-weight:600;">{{ number_format($row->cost, 2) }}</td>
                <td style="text-align:right;color:var(--slate-mid);font-size:.85rem;">
                    {{ $row->litres > 0 ? number_format($row->cost / $row->litres, 2) : '—' }}
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--slate-mid);">No fuel records for {{ $year }}.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
