@extends('admin.layouts.app')
@section('title', 'Fleet — Vehicles')
@section('breadcrumb', 'Fleet / Vehicles')

@section('content')
<div class="page-header">
    <div><div class="page-title">Fleet Vehicles</div><div class="page-subtitle">{{ $vehicles->total() }} vehicles registered</div></div>
    @if(admin_can('manage_fleet'))
    <a href="{{ route('admin.fleet.vehicles.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Vehicle</a>
    @endif
</div>

<div class="filter-bar">
    <form method="GET" style="display:contents;">
        <div class="form-group">
            <label>Category</label>
            <select name="category_id" class="form-control">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="">All</option>
                @foreach(['available','active','maintenance','out_of_service'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-sm" style="align-self:flex-end;">Filter</button>
        <a href="{{ route('admin.fleet.vehicles.index') }}" class="btn btn-outline btn-sm" style="align-self:flex-end;">Reset</a>
    </form>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Registration</th><th>Vehicle</th><th>Category</th><th>Fuel</th><th>Mileage</th><th>Status</th><th>Insurance</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($vehicles as $vehicle)
            @php
                $ins = $vehicle->currentInsurance;
                $insStatus = $ins ? ($ins->isExpiringSoon() ? 'orange' : 'green') : 'red';
                $statusColors = ['available'=>'green','active'=>'blue','maintenance'=>'orange','out_of_service'=>'red'];
            @endphp
            <tr>
                <td><strong>{{ $vehicle->registration_number }}</strong></td>
                <td>
                    <div>{{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}</div>
                    <div style="font-size:.75rem;color:var(--text-muted);">{{ $vehicle->color }}</div>
                </td>
                <td>{{ $vehicle->category->name ?? '—' }}</td>
                <td>{{ ucfirst($vehicle->fuel_type) }}</td>
                <td>{{ number_format($vehicle->current_mileage ?? 0) }} km</td>
                <td><span class="badge badge-{{ $statusColors[$vehicle->status] ?? 'grey' }}">{{ ucfirst(str_replace('_',' ',$vehicle->status)) }}</span></td>
                <td>
                    @if($ins)
                    <span class="badge badge-{{ $insStatus }}">{{ $ins->isExpiringSoon() ? 'Expiring Soon' : 'Valid' }}</span>
                    @else
                    <span class="badge badge-red">No Insurance</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.fleet.vehicles.show', $vehicle) }}" class="btn btn-xs btn-outline"><i class="fas fa-eye"></i></a>
                    @if(admin_can('manage_fleet'))
                    <a href="{{ route('admin.fleet.vehicles.edit', $vehicle) }}" class="btn btn-xs btn-outline"><i class="fas fa-pen"></i></a>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:var(--text-muted);">No vehicles found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;">{{ $vehicles->links() }}</div>
</div>
@endsection
