@extends('admin.layouts.app')
@section('title', 'New Payroll Period')
@section('page-title', 'Payroll')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">New Payroll Period</div>
        <div class="page-subtitle">Create a payroll period to run payroll for a specific month</div>
    </div>
    <a href="{{ route('admin.payroll.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

@if($errors->any())
<div class="alert alert-danger">
    <i class="fas fa-exclamation-circle"></i>
    <ul style="margin:0;padding-left:1rem;">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
</div>
@endif

<div class="card" style="max-width:480px;">
    <div class="card-header">
        <span class="card-title"><i class="fas fa-calendar-plus" style="color:var(--forest);margin-right:.4rem;"></i> Period Details</span>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.payroll.periods.store') }}">
            @csrf

            <div class="form-grid form-grid--2">
                <div class="form-group">
                    <label class="form-label">Month <span class="text-danger">*</span></label>
                    <select name="month" class="form-control" required>
                        <option value="">— Month —</option>
                        @foreach(range(1,12) as $m)
                        <option value="{{ $m }}" {{ old('month', now()->month) == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create(null, $m)->format('F') }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Year <span class="text-danger">*</span></label>
                    <select name="year" class="form-control" required>
                        @foreach(range(now()->year - 1, now()->year + 1) as $y)
                        <option value="{{ $y }}" {{ old('year', now()->year) == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="card" style="background:#F0FDF4;border:1px solid #A7F3D0;padding:1rem;margin-bottom:1.25rem;">
                <div style="font-size:.82rem;color:#065F46;line-height:1.7;">
                    <i class="fas fa-info-circle" style="margin-right:.4rem;"></i>
                    <strong>Note:</strong> Creating a period only opens it for payroll processing.
                    Use <em>Run Payroll</em> on the next screen to generate employee payslips.
                    The period dates are automatically set to the 1st–last day of the selected month.
                </div>
            </div>

            <div style="display:flex;gap:.75rem;">
                <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center;">
                    <i class="fas fa-plus"></i> Create Period
                </button>
                <a href="{{ route('admin.payroll.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
