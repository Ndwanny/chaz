@extends('admin.layouts.app')
@section('title', $member ? 'Edit Member' : 'Add Member')
@section('page-title', $member ? 'Edit Member' : 'Add Member Institution')

@section('content')
<div class="page-header">
    <div><div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / <a href="{{ route('admin.members.index') }}">Members</a> / {{ $member ? 'Edit' : 'Add' }}</div><h2>{{ $member ? 'Edit: ' . $member->name : 'Add Member Institution' }}</h2></div>
    <a href="{{ route('admin.members.index') }}" class="btn btn-outline"><i class="fa fa-arrow-left"></i> Back</a>
</div>
<div class="card" style="max-width:700px;">
    <div class="card-header"><h3>Institution Details</h3></div>
    <div class="card-body">
        <form action="{{ $action }}" method="POST">
            @csrf @if($member) @method('PUT') @endif
            <div class="form-grid form-grid--2">
                <div class="form-group span-2">
                    <label class="form-label">Institution Name <span>*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $member?->name) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Type <span>*</span></label>
                    <select name="type" class="form-control" required>
                        <option value="hospital" {{ old('type', $member?->type) === 'hospital' ? 'selected' : '' }}>Hospital</option>
                        <option value="centre"   {{ old('type', $member?->type) === 'centre'   ? 'selected' : '' }}>Health Centre</option>
                        <option value="cbo"      {{ old('type', $member?->type) === 'cbo'      ? 'selected' : '' }}>CBO</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Province <span>*</span></label>
                    <select name="province" class="form-control" required>
                        @foreach(['Central','Copperbelt','Eastern','Luapula','Lusaka','Muchinga','Northern','North-Western','Southern','Western'] as $prov)
                        <option value="{{ $prov }}" {{ old('province', $member?->province) === $prov ? 'selected' : '' }}>{{ $prov }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group span-2">
                    <label class="form-label">Denomination <span>*</span></label>
                    <input type="text" name="denomination" class="form-control" value="{{ old('denomination', $member?->denomination) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">District</label>
                    <input type="text" name="district" class="form-control" value="{{ old('district', $member?->district) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Contact</label>
                    <input type="text" name="contact" class="form-control" value="{{ old('contact', $member?->contact) }}" placeholder="+260...">
                </div>
                <div class="form-group span-2" style="flex-direction:row;align-items:center;gap:0.75rem;">
                    <input type="checkbox" name="active" id="active" value="1" {{ old('active', $member?->active ?? true) ? 'checked' : '' }} style="width:16px;height:16px;cursor:pointer;">
                    <label for="active" class="form-label" style="margin:0;cursor:pointer;">Active (visible on website)</label>
                </div>
            </div>
            <hr class="divider">
            <div style="display:flex;gap:0.75rem;">
                <button type="submit" class="btn btn-forest"><i class="fa fa-floppy-disk"></i> {{ $member ? 'Save Changes' : 'Add Member' }}</button>
                <a href="{{ route('admin.members.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
