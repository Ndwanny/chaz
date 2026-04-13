@extends('admin.layouts.app')
@section('title', isset($supplier) ? 'Edit Supplier' : 'New Supplier')
@section('page-title', isset($supplier) ? 'Edit Supplier' : 'New Supplier')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">{{ isset($supplier) ? 'Edit: ' . $supplier->name : 'New Supplier' }}</div>
        <div class="page-subtitle">{{ isset($supplier) ? 'Update supplier details' : 'Add a new vendor or supplier' }}</div>
    </div>
    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

@if($errors->any())
<div class="alert alert-danger">
    <ul style="margin:0;padding-left:1.2rem;">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ isset($supplier) ? route('admin.suppliers.update', $supplier) : route('admin.suppliers.store') }}">
    @csrf
    @if(isset($supplier)) @method('PUT') @endif

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;align-items:start;">

        {{-- Basic Info --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title"><i class="fas fa-building" style="color:var(--forest);margin-right:.4rem;"></i> Basic Information</span>
            </div>
            <div class="card-body">
                <div class="form-grid form-grid--2">
                    <div class="form-group" style="grid-column:1/-1;">
                        <label class="form-label">Supplier Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $supplier->name ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Code <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control" value="{{ old('code', $supplier->code ?? '') }}" {{ isset($supplier) ? 'readonly' : 'required' }} placeholder="e.g. SUP-001">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Registration No.</label>
                        <input type="text" name="registration_number" class="form-control" value="{{ old('registration_number', $supplier->registration_number ?? '') }}" placeholder="Company reg. number">
                    </div>
                    <div class="form-group">
                        <label class="form-label">TPIN</label>
                        <input type="text" name="tpin" class="form-control" value="{{ old('tpin', $supplier->tpin ?? '') }}" placeholder="Tax Payer Identification No.">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Payment Terms (days)</label>
                        <input type="number" name="payment_terms" class="form-control" value="{{ old('payment_terms', $supplier->payment_terms ?? '') }}" min="0" placeholder="e.g. 30">
                    </div>
                </div>

                @if(isset($supplier))
                <div class="form-group">
                    <label class="form-label">Rating (0–5)</label>
                    <input type="number" name="rating" class="form-control" value="{{ old('rating', $supplier->rating ?? '') }}" min="0" max="5" step="0.1">
                </div>
                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;font-size:.875rem;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $supplier->is_active ?? true) ? 'checked' : '' }}>
                        Active
                    </label>
                </div>
                @endif

                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Any additional notes…">{{ old('notes', $supplier->notes ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:1.25rem;">
            {{-- Contact --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-title"><i class="fas fa-address-book" style="color:var(--forest);margin-right:.4rem;"></i> Contact Details</span>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Contact Person</label>
                        <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person', $supplier->contact_person ?? '') }}">
                    </div>
                    <div class="form-grid form-grid--2">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $supplier->email ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $supplier->phone ?? '') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2">{{ old('address', $supplier->address ?? '') }}</textarea>
                    </div>
                    <div class="form-grid form-grid--2">
                        <div class="form-group">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city', $supplier->city ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-control" value="{{ old('country', $supplier->country ?? '') }}" placeholder="e.g. Zambia">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Banking --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-title"><i class="fas fa-university" style="color:var(--forest);margin-right:.4rem;"></i> Banking Details</span>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Bank Name</label>
                        <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name', $supplier->bank_name ?? '') }}">
                    </div>
                    <div class="form-grid form-grid--2">
                        <div class="form-group">
                            <label class="form-label">Account Number</label>
                            <input type="text" name="bank_account" class="form-control" value="{{ old('bank_account', $supplier->bank_account ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Branch</label>
                            <input type="text" name="bank_branch" class="form-control" value="{{ old('bank_branch', $supplier->bank_branch ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div style="display:flex;gap:.75rem;margin-top:1.25rem;">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ isset($supplier) ? 'Update Supplier' : 'Create Supplier' }}
        </button>
        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>

@push('styles')
<style>
@media (max-width: 900px) {
    form > div[style*="grid-template-columns"] { grid-template-columns: 1fr !important; }
}
</style>
@endpush
@endsection
