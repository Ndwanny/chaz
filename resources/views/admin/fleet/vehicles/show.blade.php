@extends('admin.layouts.app')
@section('title', $vehicle->registration_number)
@section('breadcrumb', 'Fleet / Vehicles / ' . $vehicle->registration_number)

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">{{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}</div>
        <div class="page-subtitle">{{ $vehicle->registration_number }} &nbsp;|&nbsp; {{ $vehicle->category->name ?? '' }}</div>
    </div>
    <div style="display:flex;gap:8px;">
        @if(admin_can('manage_fleet'))
        <a href="{{ route('admin.fleet.vehicles.edit', $vehicle) }}" class="btn btn-outline"><i class="fas fa-pen"></i> Edit</a>
        @endif
        <a href="{{ route('admin.fleet.vehicles.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
</div>

@php $statusColors = ['available'=>'green','active'=>'blue','maintenance'=>'orange','out_of_service'=>'red']; @endphp

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
    {{-- Details --}}
    <div class="card">
        <div class="card-header"><span class="card-title">Vehicle Details</span></div>
        <div class="card-body">
            <table style="width:100%;font-size:.88rem;">
                <tr><td style="padding:6px 0;color:var(--text-muted);width:45%;">Registration</td><td><strong>{{ $vehicle->registration_number }}</strong></td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Status</td><td><span class="badge badge-{{ $statusColors[$vehicle->status] ?? 'grey' }}">{{ ucfirst(str_replace('_',' ',$vehicle->status)) }}</span></td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Make / Model</td><td>{{ $vehicle->make }} {{ $vehicle->model }}</td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Year</td><td>{{ $vehicle->year }}</td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Color</td><td>{{ $vehicle->color ?? '—' }}</td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Fuel Type</td><td>{{ ucfirst($vehicle->fuel_type) }}</td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Engine</td><td>{{ $vehicle->engine_capacity ?? '—' }}</td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Seats</td><td>{{ $vehicle->seating_capacity ?? '—' }}</td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Chassis #</td><td>{{ $vehicle->chassis_number ?? '—' }}</td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Current Mileage</td><td>{{ number_format($vehicle->current_mileage ?? 0) }} km</td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Department</td><td>{{ $vehicle->department->name ?? '—' }}</td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Purchase Date</td><td>{{ $vehicle->purchase_date?->format('d M Y') ?? '—' }}</td></tr>
                <tr><td style="padding:6px 0;color:var(--text-muted);">Purchase Price</td><td>{{ $vehicle->purchase_price ? 'ZMW ' . number_format($vehicle->purchase_price, 2) : '—' }}</td></tr>
            </table>
        </div>
    </div>

    {{-- Insurance --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Insurance</span>
            @if(admin_can('manage_fleet'))
            <button type="button" class="btn btn-sm btn-outline" onclick="document.getElementById('ins-form').style.display=document.getElementById('ins-form').style.display==='none'?'block':'none'">
                <i class="fas fa-plus"></i> Add
            </button>
            @endif
        </div>
        <div id="ins-form" style="display:none;padding:16px;border-bottom:1px solid var(--border);">
            <form method="POST" action="{{ route('admin.fleet.vehicles.insurance.store', $vehicle) }}">
                @csrf
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div><label class="form-label">Insurer</label><input type="text" name="insurer" class="form-control" required></div>
                    <div><label class="form-label">Policy Number</label><input type="text" name="policy_number" class="form-control" required></div>
                    <div><label class="form-label">Type</label>
                        <select name="insurance_type" class="form-control" required>
                            <option value="comprehensive">Comprehensive</option>
                            <option value="third_party">Third Party</option>
                            <option value="fire_and_theft">Fire & Theft</option>
                        </select>
                    </div>
                    <div><label class="form-label">Premium (ZMW)</label><input type="number" name="premium_amount" class="form-control" step="0.01" min="0" required></div>
                    <div><label class="form-label">Start Date</label><input type="date" name="start_date" class="form-control" required></div>
                    <div><label class="form-label">Expiry Date</label><input type="date" name="expiry_date" class="form-control" required></div>
                </div>
                <div style="margin-top:10px;"><button type="submit" class="btn btn-sm btn-primary">Save Insurance</button></div>
            </form>
        </div>
        <div class="card-body" style="font-size:.85rem;">
            @if($vehicle->currentInsurance)
            @php $ins = $vehicle->currentInsurance; @endphp
            <div><strong>{{ $ins->insurer }}</strong> — {{ $ins->policy_number }}</div>
            <div>{{ ucfirst(str_replace('_',' ',$ins->insurance_type)) }}</div>
            <div>{{ $ins->start_date?->format('d M Y') }} — {{ $ins->expiry_date?->format('d M Y') }}</div>
            <div>ZMW {{ number_format($ins->premium_amount, 2) }}</div>
            @else
            <p style="color:var(--text-muted);">No active insurance on record.</p>
            @endif
        </div>
    </div>
</div>

{{-- Recent fuel --}}
<div class="card" style="margin-top:1.5rem;">
    <div class="card-header"><span class="card-title">Recent Fuel Logs</span></div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Date</th><th>Litres</th><th>Cost</th><th>Odometer</th><th>Station</th></tr></thead>
            <tbody>
            @forelse($vehicle->fuelLogs as $fl)
            <tr>
                <td>{{ $fl->log_date?->format('d M Y') }}</td>
                <td>{{ number_format($fl->litres, 2) }}L</td>
                <td>ZMW {{ number_format($fl->total_cost, 2) }}</td>
                <td>{{ $fl->odometer_reading ? number_format($fl->odometer_reading) . ' km' : '—' }}</td>
                <td>{{ $fl->fuel_station ?? '—' }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:var(--text-muted);">No fuel records.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Recent maintenance --}}
<div class="card" style="margin-top:1.5rem;">
    <div class="card-header"><span class="card-title">Recent Maintenance</span></div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Date</th><th>Type</th><th>Workshop</th><th>Cost</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($vehicle->maintenanceRecords as $mr)
            @php $sc = ['pending'=>'orange','in_progress'=>'blue','completed'=>'green','scheduled'=>'teal']; @endphp
            <tr>
                <td>{{ $mr->start_date?->format('d M Y') }}</td>
                <td>{{ $mr->type_label }}</td>
                <td>{{ $mr->workshop ?? '—' }}</td>
                <td>ZMW {{ number_format($mr->cost, 2) }}</td>
                <td><span class="badge badge-{{ $sc[$mr->status] ?? 'grey' }}">{{ ucfirst(str_replace('_',' ',$mr->status)) }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:var(--text-muted);">No maintenance records.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
