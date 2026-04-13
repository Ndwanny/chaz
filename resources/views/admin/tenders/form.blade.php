@extends('admin.layouts.app')
@section('title', $tender ? 'Edit Tender' : 'New Tender')
@section('page-title', $tender ? 'Edit Tender' : 'New Tender')

@section('content')
<div class="page-header">
    <div><div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / <a href="{{ route('admin.tenders.index') }}">Tenders</a> / {{ $tender ? 'Edit' : 'New' }}</div><h2>{{ $tender ? 'Edit Tender' : 'Create Tender' }}</h2></div>
    <a href="{{ route('admin.tenders.index') }}" class="btn btn-outline"><i class="fa fa-arrow-left"></i> Back</a>
</div>

<div class="card" style="max-width:800px;">
    <div class="card-header"><h3>Tender Information</h3></div>
    <div class="card-body">
        <form action="{{ $action }}" method="POST">
            @csrf @if($tender) @method('PUT') @endif
            <div class="form-grid form-grid--2">
                <div class="form-group">
                    <label class="form-label">Reference Number <span>*</span></label>
                    <input type="text" name="reference" class="form-control" value="{{ old('reference', $tender?->reference) }}" required placeholder="CHAZ/T/2026/001">
                </div>
                <div class="form-group">
                    <label class="form-label">Category <span>*</span></label>
                    <input type="text" name="category" class="form-control" value="{{ old('category', $tender?->category) }}" required list="cat-list" placeholder="e.g. Medical Supplies">
                    <datalist id="cat-list">
                        @foreach(['Medical Supplies','Pharmaceuticals','Construction','Information Technology','Consultancy','Transport','Office Supplies'] as $c)
                        <option value="{{ $c }}">
                        @endforeach
                    </datalist>
                </div>
                <div class="form-group span-2">
                    <label class="form-label">Title <span>*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $tender?->title) }}" required>
                </div>
                <div class="form-group span-2">
                    <label class="form-label">Description <span>*</span></label>
                    <textarea name="description" class="form-control" rows="5" required>{{ old('description', $tender?->description) }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Issue Date <span>*</span></label>
                    <input type="date" name="issued_at" class="form-control" value="{{ old('issued_at', $tender?->issued_at?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Closing Deadline <span>*</span></label>
                    <input type="date" name="deadline" class="form-control" value="{{ old('deadline', $tender?->deadline?->format('Y-m-d')) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Status <span>*</span></label>
                    <select name="status" class="form-control">
                        @foreach(['open','closed','awarded'] as $s)
                        <option value="{{ $s }}" {{ old('status', $tender?->status) === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <hr class="divider">
            <div style="display:flex;gap:0.75rem;">
                <button type="submit" class="btn btn-forest"><i class="fa fa-floppy-disk"></i> {{ $tender ? 'Save Changes' : 'Create Tender' }}</button>
                <a href="{{ route('admin.tenders.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
