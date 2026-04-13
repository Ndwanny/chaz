@extends('admin.layouts.app')
@section('title', isset($employee) ? 'Edit Employee' : 'Add Employee')
@section('breadcrumb', 'HR / Employees / ' . (isset($employee) ? 'Edit' : 'New'))

@section('content')
<div class="page-header">
    <div><div class="page-title">{{ isset($employee) ? 'Edit: '.$employee->full_name : 'Add New Employee' }}</div></div>
    <a href="{{ route('admin.employees.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ isset($employee) ? route('admin.employees.update', $employee) : route('admin.employees.store') }}">
            @csrf
            @if(isset($employee)) @method('PUT') @endif

            <div style="font-weight:700;color:var(--primary);margin-bottom:12px;padding-bottom:6px;border-bottom:1px solid var(--border);">Personal Details</div>
            <div class="form-grid" style="margin-bottom:20px;">
                <div class="form-group">
                    <label>First Name *</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $employee->first_name ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label>Last Name *</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $employee->last_name ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label>Other Names</label>
                    <input type="text" name="other_names" class="form-control" value="{{ old('other_names', $employee->other_names ?? '') }}">
                </div>
                <div class="form-group">
                    <label>Gender *</label>
                    <select name="gender" class="form-control" required>
                        <option value="">— Select —</option>
                        <option value="male" {{ old('gender', $employee->gender ?? '') === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $employee->gender ?? '') === 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Date of Birth *</label>
                    <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', isset($employee->date_of_birth) ? $employee->date_of_birth->format('Y-m-d') : '') }}" required>
                </div>
                <div class="form-group">
                    <label>National ID</label>
                    <input type="text" name="national_id" class="form-control" value="{{ old('national_id', $employee->national_id ?? '') }}">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $employee->email ?? '') }}">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $employee->phone ?? '') }}">
                </div>
            </div>

            <div style="font-weight:700;color:var(--primary);margin-bottom:12px;padding-bottom:6px;border-bottom:1px solid var(--border);">Employment Details</div>
            <div class="form-grid" style="margin-bottom:20px;">
                <div class="form-group">
                    <label>Department *</label>
                    <select name="department_id" class="form-control" required>
                        <option value="">— Select Department —</option>
                        @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id', $employee->department_id ?? '') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Job Title *</label>
                    <input type="text" name="job_title" class="form-control" value="{{ old('job_title', $employee->job_title ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label>Employment Type *</label>
                    <select name="employment_type" class="form-control" required>
                        @foreach(['permanent','contract','casual','intern'] as $type)
                        <option value="{{ $type }}" {{ old('employment_type', $employee->employment_type ?? '') === $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Employment Status *</label>
                    <select name="employment_status" class="form-control" required>
                        @foreach(['active','on_leave','suspended','terminated','resigned'] as $st)
                        <option value="{{ $st }}" {{ old('employment_status', $employee->employment_status ?? 'active') === $st ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$st)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Hire Date *</label>
                    <input type="date" name="hire_date" class="form-control" value="{{ old('hire_date', isset($employee->hire_date) ? $employee->hire_date->format('Y-m-d') : '') }}" required>
                </div>
                <div class="form-group">
                    <label>Salary Grade</label>
                    <select name="salary_grade_id" class="form-control">
                        <option value="">— Select Grade —</option>
                        @foreach($salaryGrades as $grade)
                        <option value="{{ $grade->id }}" {{ old('salary_grade_id', $employee->salary_grade_id ?? '') == $grade->id ? 'selected' : '' }}>{{ $grade->code }} — {{ $grade->name }}</option>
                        @endforeach
                    </select>
                </div>
                @if(!isset($employee))
                <div class="form-group">
                    <label>Basic Salary (ZMW)</label>
                    <input type="number" name="basic_salary" class="form-control" value="{{ old('basic_salary') }}" step="0.01" min="0">
                    <div class="form-hint">Leave blank to assign later via payroll.</div>
                </div>
                @endif
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ isset($employee) ? 'Update' : 'Add Employee' }}</button>
                <a href="{{ route('admin.employees.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
