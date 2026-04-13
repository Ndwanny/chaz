@extends('portal.layouts.app')
@section('page_title', 'My Profile')
@section('breadcrumb', 'My Profile')

@section('content')

@if(session('success'))
<div class="p-alert success" style="margin-bottom:1.25rem;">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="p-alert error" style="margin-bottom:1.25rem;">{{ session('error') }}</div>
@endif

<div class="p-profile-grid">

    {{-- Left: Personal info card --}}
    <div>
        <div class="p-card" style="text-align:center;padding-bottom:1.5rem;margin-bottom:1.25rem;">
            <div style="width:88px;height:88px;border-radius:50%;background:#1B4332;color:#C9A84C;display:flex;align-items:center;justify-content:center;font-size:1.8rem;font-weight:800;margin:0 auto 1rem;">
                @if($employee->photo)
                <img src="{{ Storage::url($employee->photo) }}" alt="" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">
                @else
                {{ $employee->initials }}
                @endif
            </div>
            <div style="font-weight:800;font-size:1.05rem;">{{ $employee->full_name }}</div>
            <div style="font-size:.82rem;color:var(--portal-muted);margin-top:.2rem;">{{ $employee->designation ?? 'Staff' }}</div>
            <div style="display:inline-block;background:#F0FDF4;color:var(--portal-green);font-size:.75rem;font-weight:700;padding:.25rem .75rem;border-radius:999px;margin-top:.5rem;">{{ $employee->staff_number }}</div>
        </div>

        <div class="p-card">
            <div class="p-card__header" style="margin-bottom:1rem;"><span class="p-card__title">Employment Details</span></div>
            @php
            $fields = [
                'Department'      => $employee->department->name ?? '—',
                'Job Title'       => $employee->designation ?? '—',
                'Employment Type' => ucfirst($employee->employment_type ?? '—'),
                'Date Joined'     => $employee->hired_at?->format('d M Y') ?? '—',
                'NRC Number'      => $employee->nrc_number ?? '—',
                'NAPSA Number'    => $employee->napsa_number ?? '—',
                'Medical Aid'     => $employee->medical_aid_provider ? $employee->medical_aid_provider . ' — ' . ($employee->medical_aid_number ?? '') : '—',
                'Bank Account'    => $employee->bank_account ? '****' . substr($employee->bank_account, -4) : '—',
                'Bank Name'       => $employee->bank_name ?? '—',
            ];
            @endphp
            @foreach($fields as $label => $value)
            <div style="display:flex;justify-content:space-between;padding:.55rem 0;border-bottom:1px solid #F1F5F9;font-size:.83rem;">
                <span style="color:var(--portal-muted);">{{ $label }}</span>
                <span style="font-weight:600;text-align:right;max-width:55%;">{{ $value }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Right: Forms --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">

        {{-- Update contact info --}}
        <div class="p-card">
            <div class="p-card__header" style="margin-bottom:1.25rem;">
                <span class="p-card__title"><i class="fas fa-address-book" style="color:var(--portal-green);margin-right:.4rem;"></i> Contact Information</span>
            </div>
            @if($errors->hasBag('contact'))
            <div class="p-alert error" style="margin-bottom:1rem;">
                <ul style="margin:0;padding-left:1.2rem;">
                    @foreach($errors->getBag('contact')->all() as $err)<li>{{ $err }}</li>@endforeach
                </ul>
            </div>
            @endif
            <form method="POST" action="{{ route('portal.profile.contact') }}">
                @csrf
                <div class="p-form-group">
                    <label class="p-label">Home Address</label>
                    <textarea name="address" class="p-input" rows="2" placeholder="Physical address">{{ old('address', $employee->address ?? '') }}</textarea>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                    <div class="p-form-group">
                        <label class="p-label">Province</label>
                        <input type="text" name="province" class="p-input" value="{{ old('province', $employee->province ?? '') }}" placeholder="e.g. Lusaka">
                    </div>
                    <div class="p-form-group">
                        <label class="p-label">District</label>
                        <input type="text" name="district" class="p-input" value="{{ old('district', $employee->district ?? '') }}" placeholder="e.g. Chilanga">
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                    <div class="p-form-group">
                        <label class="p-label">Emergency Contact Name</label>
                        <input type="text" name="emergency_contact_name" class="p-input" value="{{ old('emergency_contact_name', $employee->emergency_contact_name ?? '') }}">
                    </div>
                    <div class="p-form-group">
                        <label class="p-label">Emergency Contact Phone</label>
                        <input type="text" name="emergency_contact_phone" class="p-input" value="{{ old('emergency_contact_phone', $employee->emergency_contact_phone ?? '') }}">
                    </div>
                </div>
                <div class="p-form-group">
                    <label class="p-label">Emergency Contact Relationship</label>
                    <input type="text" name="emergency_contact_relationship" class="p-input" value="{{ old('emergency_contact_relationship', $employee->emergency_contact_relationship ?? '') }}" placeholder="e.g. Spouse, Parent">
                </div>
                <button type="submit" class="p-btn primary" style="margin-top:.5rem;"><i class="fas fa-save"></i> Update Contact Info</button>
            </form>
        </div>

        {{-- Change password --}}
        <div class="p-card">
            <div class="p-card__header" style="margin-bottom:1.25rem;">
                <span class="p-card__title"><i class="fas fa-lock" style="color:var(--portal-green);margin-right:.4rem;"></i> Change Password</span>
            </div>
            @if(!$employee->portal_password)
            <div class="p-alert" style="background:#FEF3C7;border:1px solid #FCD34D;color:#92400E;border-radius:8px;padding:.75rem 1rem;margin-bottom:1rem;font-size:.85rem;">
                <i class="fas fa-exclamation-triangle"></i>
                You are using the default password (your staff number). Please set a personal password.
            </div>
            @endif
            @if($errors->hasBag('password'))
            <div class="p-alert error" style="margin-bottom:1rem;">
                <ul style="margin:0;padding-left:1.2rem;">
                    @foreach($errors->getBag('password')->all() as $err)<li>{{ $err }}</li>@endforeach
                </ul>
            </div>
            @endif
            <form method="POST" action="{{ route('portal.profile.password') }}">
                @csrf
                @if($employee->portal_password)
                <div class="p-form-group">
                    <label class="p-label">Current Password <span style="color:#EF4444;">*</span></label>
                    <input type="password" name="current_password" class="p-input" required autocomplete="current-password">
                </div>
                @endif
                <div class="p-form-group">
                    <label class="p-label">New Password <span style="color:#EF4444;">*</span></label>
                    <input type="password" name="new_password" class="p-input" required autocomplete="new-password" minlength="8">
                    <div style="font-size:.72rem;color:var(--portal-muted);margin-top:.25rem;">Minimum 8 characters</div>
                </div>
                <div class="p-form-group">
                    <label class="p-label">Confirm New Password <span style="color:#EF4444;">*</span></label>
                    <input type="password" name="new_password_confirmation" class="p-input" required autocomplete="new-password">
                </div>
                <button type="submit" class="p-btn primary"><i class="fas fa-key"></i> Update Password</button>
            </form>
        </div>

        {{-- Last login info --}}
        @if($employee->portal_last_login)
        <div style="background:#F7FAFC;border-radius:10px;padding:.75rem 1.1rem;font-size:.78rem;color:var(--portal-muted);">
            <i class="fas fa-history" style="margin-right:.4rem;"></i>
            Last portal login: <strong>{{ $employee->portal_last_login->format('d M Y, H:i') }}</strong>
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.p-profile-grid { display:grid; grid-template-columns:1fr 1.6fr; gap:1.5rem; align-items:start; }
@media (max-width:900px) { .p-profile-grid { grid-template-columns:1fr; } }
</style>
@endpush
@endsection
