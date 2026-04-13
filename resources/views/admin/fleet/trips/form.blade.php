@extends('admin.layouts.app')
@section('title', 'New Trip Request')
@section('breadcrumb', 'Fleet / Trips / New')

@section('content')
<div class="page-header">
    <div><div class="page-title">New Trip Request</div></div>
    <a href="{{ route('admin.fleet.trips.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div class="card" style="max-width:720px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.fleet.trips.store') }}">
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
                    <label class="form-label">Driver <span style="color:red;">*</span></label>
                    <select name="driver_id" class="form-control" required>
                        <option value="">— Select Driver —</option>
                        @foreach($drivers as $d)
                        <option value="{{ $d->id }}" {{ old('driver_id') == $d->id ? 'selected' : '' }}>{{ $d->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="grid-column:1/-1;">
                    <label class="form-label">Purpose <span style="color:red;">*</span></label>
                    <input type="text" name="purpose" class="form-control" value="{{ old('purpose') }}" maxlength="300" required>
                </div>
                <div>
                    <label class="form-label">Departure Location <span style="color:red;">*</span></label>
                    <input type="text" name="departure_location" class="form-control" value="{{ old('departure_location') }}" maxlength="200" required>
                </div>
                <div>
                    <label class="form-label">Destination <span style="color:red;">*</span></label>
                    <input type="text" name="destination" class="form-control" value="{{ old('destination') }}" maxlength="200" required>
                </div>
                <div>
                    <label class="form-label">Departure Date <span style="color:red;">*</span></label>
                    <input type="date" name="departure_date" class="form-control" value="{{ old('departure_date', date('Y-m-d')) }}" required>
                </div>
                <div>
                    <label class="form-label">Departure Time</label>
                    <input type="time" name="departure_time" class="form-control" value="{{ old('departure_time') }}">
                </div>
                <div>
                    <label class="form-label">Expected Return Date</label>
                    <input type="date" name="return_date" class="form-control" value="{{ old('return_date') }}">
                </div>
                <div>
                    <label class="form-label">Expected Return Time</label>
                    <input type="time" name="return_time" class="form-control" value="{{ old('return_time') }}">
                </div>
                <div>
                    <label class="form-label">Passengers</label>
                    <input type="number" name="passenger_count" class="form-control" value="{{ old('passenger_count', 0) }}" min="0">
                </div>
                <div style="grid-column:1/-1;">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div style="margin-top:20px;display:flex;gap:10px;">
                <button type="submit" class="btn btn-primary">Submit Trip Request</button>
                <a href="{{ route('admin.fleet.trips.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
