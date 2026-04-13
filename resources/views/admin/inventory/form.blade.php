@extends('admin.layouts.app')
@section('title', isset($item) ? 'Edit Item' : 'Add Item')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">{{ isset($item) ? 'Edit Item' : 'New Item' }}</div>
        <div class="page-subtitle">{{ isset($item) ? $item->name : 'Add item to inventory catalogue' }}</div>
    </div>
    <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
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
        <form method="POST" action="{{ isset($item) ? route('admin.inventory.update', $item) : route('admin.inventory.store') }}">
            @csrf
            @if(isset($item)) @method('PUT') @endif

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label class="form-label">Item Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $item->name ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Item Code <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control" value="{{ old('code', $item->code ?? '') }}" required placeholder="e.g. ITM-0001">
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-control" required>
                        <option value="">— Select Category —</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $item->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Unit of Measure <span class="text-danger">*</span></label>
                    <input type="text" name="unit_of_measure" class="form-control" value="{{ old('unit_of_measure', $item->unit_of_measure ?? '') }}" required placeholder="e.g. pcs, litres, kg, boxes">
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label class="form-label">Unit Cost (ZMW)</label>
                    <input type="number" name="unit_cost" class="form-control" step="0.01" min="0" value="{{ old('unit_cost', $item->unit_cost ?? '') }}" placeholder="0.00">
                </div>
                <div class="form-group">
                    <label class="form-label">Reorder Level <span class="text-danger">*</span></label>
                    <input type="number" name="reorder_level" class="form-control" min="0" value="{{ old('reorder_level', $item->reorder_level ?? 10) }}" required>
                    <small class="text-muted">Alert when stock drops to this level</small>
                </div>
            </div>

            @if(!isset($item))
            <div class="form-group">
                <label class="form-label">Opening Stock</label>
                <input type="number" name="current_stock" class="form-control" step="0.01" min="0" value="{{ old('current_stock', 0) }}">
                <small class="text-muted">Current quantity on hand</small>
            </div>
            @endif

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="2">{{ old('description', $item->description ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Specifications / Notes</label>
                <textarea name="specifications" class="form-control" rows="2" placeholder="Technical specs, brand, model, etc.">{{ old('specifications', $item->specifications ?? '') }}</textarea>
            </div>

            @if(isset($item))
            <div class="form-group">
                <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
                    <span>Active (visible in procurement)</span>
                </label>
            </div>
            @endif

            <div style="display:flex;gap:.75rem;margin-top:1.5rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ isset($item) ? 'Update Item' : 'Create Item' }}
                </button>
                <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
