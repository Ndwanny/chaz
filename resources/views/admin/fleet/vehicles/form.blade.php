@extends('admin.layouts.app')
@section('title', isset($vehicle) ? 'Edit Vehicle' : 'Add Vehicle')
@section('breadcrumb', 'Fleet / Vehicles / ' . (isset($vehicle) ? 'Edit' : 'Add'))

@section('content')
<div class="page-header">
    <div><div class="page-title">{{ isset($vehicle) ? 'Edit Vehicle' : 'Add Vehicle' }}</div></div>
    <a href="{{ route('admin.fleet.vehicles.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div class="card" style="max-width:720px;">
    <div class="card-body">
        <form method="POST" action="{{ isset($vehicle) ? route('admin.fleet.vehicles.update', $vehicle) : route('admin.fleet.vehicles.store') }}">
            @csrf
            @if(isset($vehicle)) @method('PUT') @endif
            @if($errors->any())
            <div style="margin-bottom:16px;padding:10px 14px;background:#fee2e2;border-radius:6px;color:#991b1b;font-size:.85rem;">
                <ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div>
                    <label class="form-label">Registration Number <span style="color:red;">*</span></label>
                    <input type="text" name="registration_number" class="form-control" value="{{ old('registration_number', $vehicle->registration_number ?? '') }}" maxlength="20" required>
                </div>
                <div>
                    <label class="form-label">Status <span style="color:red;">*</span></label>
                    <select name="status" class="form-control" required>
                        @foreach(['available','active','maintenance','out_of_service'] as $s)
                        <option value="{{ $s }}" {{ old('status', $vehicle->status ?? 'available') == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Make <span style="color:red;">*</span></label>
                    <input type="text" name="make" class="form-control" value="{{ old('make', $vehicle->make ?? '') }}" maxlength="60" required>
                </div>
                <div>
                    <label class="form-label">Model <span style="color:red;">*</span></label>
                    <input type="text" name="model" class="form-control" value="{{ old('model', $vehicle->model ?? '') }}" maxlength="60" required>
                </div>
                <div>
                    <label class="form-label">Year <span style="color:red;">*</span></label>
                    <input type="number" name="year" class="form-control" value="{{ old('year', $vehicle->year ?? date('Y')) }}" min="1990" max="{{ date('Y') + 1 }}" required>
                </div>
                <div>
                    <label class="form-label">Color</label>
                    <input type="text" name="color" class="form-control" value="{{ old('color', $vehicle->color ?? '') }}" maxlength="30">
                </div>
                <div>
                    <label class="form-label">Category <span style="color:red;">*</span></label>
                    <select name="category_id" class="form-control" required>
                        <option value="">— Select —</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $vehicle->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Department</label>
                    <select name="department_id" class="form-control">
                        <option value="">— None —</option>
                        @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id', $vehicle->department_id ?? '') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Fuel Type <span style="color:red;">*</span></label>
                    <select name="fuel_type" class="form-control" required>
                        @foreach(['petrol','diesel','electric','hybrid'] as $ft)
                        <option value="{{ $ft }}" {{ old('fuel_type', $vehicle->fuel_type ?? 'diesel') == $ft ? 'selected' : '' }}>{{ ucfirst($ft) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Engine Capacity</label>
                    <input type="text" name="engine_capacity" class="form-control" value="{{ old('engine_capacity', $vehicle->engine_capacity ?? '') }}" maxlength="20" placeholder="e.g. 3.0L">
                </div>
                <div>
                    <label class="form-label">Seating Capacity</label>
                    <input type="number" name="seating_capacity" class="form-control" value="{{ old('seating_capacity', $vehicle->seating_capacity ?? '') }}" min="1">
                </div>
                <div>
                    <label class="form-label">Current Mileage (km)</label>
                    <input type="number" name="current_mileage" class="form-control" value="{{ old('current_mileage', $vehicle->current_mileage ?? 0) }}" min="0">
                </div>
                <div>
                    <label class="form-label">Chassis Number</label>
                    <input type="text" name="chassis_number" class="form-control" value="{{ old('chassis_number', $vehicle->chassis_number ?? '') }}" maxlength="50">
                </div>
                <div>
                    <label class="form-label">Engine Number</label>
                    <input type="text" name="engine_number" class="form-control" value="{{ old('engine_number', $vehicle->engine_number ?? '') }}" maxlength="50">
                </div>
                <div>
                    <label class="form-label">Purchase Date</label>
                    <input type="date" name="purchase_date" class="form-control" value="{{ old('purchase_date', $vehicle?->purchase_date?->format('Y-m-d') ?? '') }}">
                </div>
                <div>
                    <label class="form-label">Purchase Price (ZMW)</label>
                    <input type="number" name="purchase_price" class="form-control" value="{{ old('purchase_price', $vehicle->purchase_price ?? '') }}" step="0.01" min="0">
                </div>
                <div style="grid-column:1/-1;">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes', $vehicle->notes ?? '') }}</textarea>
                </div>
            </div>

            <div style="margin-top:20px;display:flex;gap:10px;">
                <button type="submit" class="btn btn-primary">{{ isset($vehicle) ? 'Update Vehicle' : 'Add Vehicle' }}</button>
                <a href="{{ route('admin.fleet.vehicles.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
