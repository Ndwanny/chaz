@extends('admin.layouts.app')
@section('title', 'Record Fuel')
@section('breadcrumb', 'Fleet / Fuel / Record')

@section('content')
<div class="page-header">
    <div><div class="page-title">Record Fuel</div></div>
    <a href="{{ route('admin.fleet.fuel.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div class="card" style="max-width:680px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.fleet.fuel.store') }}">
            @csrf
            @if($errors->any())
            <div class="alert alert-danger" style="margin-bottom:16px;padding:10px 14px;background:#fee2e2;border-radius:6px;color:#991b1b;font-size:.85rem;">
                <ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div>
                    <label class="form-label">Vehicle <span style="color:red;">*</span></label>
                    <select name="vehicle_id" class="form-control" required>
                        <option value="">— Select Vehicle —</option>
                        @foreach($vehicles as $v)
                        <option value="{{ $v->id }}" {{ old('vehicle_id') == $v->id ? 'selected' : '' }}>{{ $v->registration_number }} — {{ $v->make }} {{ $v->model }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Driver</label>
                    <select name="driver_id" class="form-control">
                        <option value="">— Select Driver —</option>
                        @foreach($drivers as $d)
                        <option value="{{ $d->id }}" {{ old('driver_id') == $d->id ? 'selected' : '' }}>{{ $d->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Date <span style="color:red;">*</span></label>
                    <input type="date" name="log_date" class="form-control" value="{{ old('log_date', date('Y-m-d')) }}" required>
                </div>
                <div>
                    <label class="form-label">Odometer Reading (km)</label>
                    <input type="number" name="odometer_reading" class="form-control" value="{{ old('odometer_reading') }}" min="0">
                </div>
                <div>
                    <label class="form-label">Litres <span style="color:red;">*</span></label>
                    <input type="number" name="litres" class="form-control" value="{{ old('litres') }}" step="0.01" min="0.1" required>
                </div>
                <div>
                    <label class="form-label">Unit Cost (ZMW/L) <span style="color:red;">*</span></label>
                    <input type="number" name="unit_cost" class="form-control" value="{{ old('unit_cost') }}" step="0.01" min="0" required>
                </div>
                <div>
                    <label class="form-label">Fuel Station</label>
                    <input type="text" name="fuel_station" class="form-control" value="{{ old('fuel_station') }}" maxlength="100">
                </div>
                <div>
                    <label class="form-label">Receipt Number</label>
                    <input type="text" name="receipt_number" class="form-control" value="{{ old('receipt_number') }}" maxlength="30">
                </div>
                <div style="grid-column:1/-1;">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div style="margin-top:20px;display:flex;gap:10px;">
                <button type="submit" class="btn btn-primary">Save Fuel Log</button>
                <a href="{{ route('admin.fleet.fuel.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
