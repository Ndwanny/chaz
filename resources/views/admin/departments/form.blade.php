@extends('admin.layouts.app')
@section('title', isset($department) ? 'Edit Department' : 'New Department')
@section('page-title', isset($department) ? 'Edit Department' : 'New Department')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">{{ isset($department) ? 'Edit: ' . $department->name : 'New Department' }}</div>
        <div class="page-subtitle">{{ isset($department) ? 'Update department details' : 'Add a new organisational unit' }}</div>
    </div>
    <a href="{{ route('admin.departments.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

@if($errors->any())
<div class="alert alert-danger">
    <ul style="margin:0;padding-left:1.2rem;">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
</div>
@endif

<div class="card" style="max-width:700px;">
    <div class="card-body">
        <form method="POST" action="{{ isset($department) ? route('admin.departments.update', $department) : route('admin.departments.store') }}">
            @csrf
            @if(isset($department)) @method('PUT') @endif

            <div class="form-grid form-grid--2">
                <div class="form-group">
                    <label class="form-label">Department Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $department->name ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Code <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control" value="{{ old('code', $department->code ?? '') }}" required placeholder="e.g. HR, FIN, IT">
                </div>
            </div>

            <div class="form-grid form-grid--2">
                <div class="form-group">
                    <label class="form-label">Type <span class="text-danger">*</span></label>
                    <select name="type" class="form-control" required>
                        <option value="">— Select Type —</option>
                        @foreach(['executive' => 'Executive', 'operational' => 'Operational', 'support' => 'Support', 'provincial' => 'Provincial'] as $val => $label)
                        <option value="{{ $val }}" {{ old('type', $department->type ?? '') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Province / Location</label>
                    <input type="text" name="province" class="form-control" value="{{ old('province', $department->province ?? '') }}" placeholder="e.g. Lusaka, Copperbelt">
                </div>
            </div>

            <div class="form-grid form-grid--2">
                <div class="form-group">
                    <label class="form-label">Parent Department</label>
                    <select name="parent_id" class="form-control">
                        <option value="">— None (Top-level) —</option>
                        @foreach($parents as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id', $department->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Department Head</label>
                    <select name="head_id" class="form-control">
                        <option value="">— Unassigned —</option>
                        @foreach($heads as $head)
                        <option value="{{ $head->id }}" {{ old('head_id', $department->head_id ?? '') == $head->id ? 'selected' : '' }}>
                            {{ $head->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Brief description of this department's role">{{ old('description', $department->description ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;font-size:.875rem;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $department->is_active ?? true) ? 'checked' : '' }}>
                    Active
                </label>
            </div>

            <div style="display:flex;gap:.75rem;margin-top:1.25rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ isset($department) ? 'Update Department' : 'Create Department' }}
                </button>
                <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
