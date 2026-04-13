@extends('admin.layouts.app')
@section('title', 'Add Maintenance Record')
@section('breadcrumb', 'Fleet / Maintenance / Add')

@section('content')
<div class="page-header">
    <div><div class="page-title">Add Maintenance Record</div></div>
    <a href="{{ route('admin.fleet.maintenance.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div class="card" style="max-width:720px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.fleet.maintenance.store') }}">
            @csrf
            @if($errors->any())
            <div class="alert alert-danger" style="margin-bottom:16px;padding:10px 14px;background:#fee2e2;border-radius:6px;color:#991b1b;font-size:.85rem;">
                <ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div style="grid-column:1/-1;">
                    <label class="form-label">Vehicle <span style="color:red;">*</span></label>
                    <select name="vehicle_id" class="form-control" required>
                        <option value="">— Select Vehicle —</option>
                        @foreach($vehicles as $v)
                        <option value="{{ $v->id }}" {{ old('vehicle_id') == $v->id ? 'selected' : '' }}>{{ $v->registration_number }} — {{ $v->make }} {{ $v->model }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Maintenance Type <span style="color:red;">*</span></label>
                    <select name="maintenance_type" class="form-control" required>
                        <option value="">— Select Type —</option>
                        <option value="preventive" {{ old('maintenance_type') == 'preventive' ? 'selected' : '' }}>Preventive</option>
                        <option value="corrective" {{ old('maintenance_type') == 'corrective' ? 'selected' : '' }}>Corrective</option>
                        <option value="inspection" {{ old('maintenance_type') == 'inspection' ? 'selected' : '' }}>Inspection</option>
                        <option value="oil_change" {{ old('maintenance_type') == 'oil_change' ? 'selected' : '' }}>Oil Change</option>
                        <option value="tyres" {{ old('maintenance_type') == 'tyres' ? 'selected' : '' }}>Tyres</option>
                        <option value="service" {{ old('maintenance_type') == 'service' ? 'selected' : '' }}>Full Service</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Status <span style="color:red;">*</span></label>
                    <select name="status" class="form-control" required>
                        <option value="scheduled" {{ old('status','scheduled') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Start Date <span style="color:red;">*</span></label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', date('Y-m-d')) }}" required>
                </div>
                <div>
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                </div>
                <div>
                    <label class="form-label">Next Service Date</label>
                    <input type="date" name="next_service_date" class="form-control" value="{{ old('next_service_date') }}">
                </div>
                <div>
                    <label class="form-label">Mileage at Service (km)</label>
                    <input type="number" name="mileage_at_service" class="form-control" value="{{ old('mileage_at_service') }}" min="0">
                </div>
                <div>
                    <label class="form-label">Next Service Mileage (km)</label>
                    <input type="number" name="next_service_mileage" class="form-control" value="{{ old('next_service_mileage') }}" min="0">
                </div>
                <div>
                    <label class="form-label">Cost (ZMW) <span style="color:red;">*</span></label>
                    <input type="number" name="cost" class="form-control" value="{{ old('cost') }}" step="0.01" min="0" required>
                </div>
                <div>
                    <label class="form-label">Workshop / Service Provider</label>
                    <input type="text" name="workshop" class="form-control" value="{{ old('workshop') }}" maxlength="150">
                </div>
                <div>
                    <label class="form-label">Invoice Number</label>
                    <input type="text" name="invoice_number" class="form-control" value="{{ old('invoice_number') }}" maxlength="30">
                </div>
                <div style="grid-column:1/-1;">
                    <label class="form-label">Description <span style="color:red;">*</span></label>
                    <textarea name="description" class="form-control" rows="2" required>{{ old('description') }}</textarea>
                </div>
                <div style="grid-column:1/-1;">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div style="margin-top:20px;display:flex;gap:10px;">
                <button type="submit" class="btn btn-primary">Save Record</button>
                <a href="{{ route('admin.fleet.maintenance.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
