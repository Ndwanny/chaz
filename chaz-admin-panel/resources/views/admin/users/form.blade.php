@extends('admin.layouts.app')
@section('title', isset($user) ? 'Edit User' : 'New User')
@section('breadcrumb', 'System / Users / ' . (isset($user) ? 'Edit' : 'New'))

@section('content')
<div class="page-header">
    <div><div class="page-title">{{ isset($user) ? 'Edit User: '.$user->name : 'New Admin User' }}</div></div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}">
            @csrf
            @if(isset($user)) @method('PUT') @endif

            <div class="form-grid">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label>Email Address *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label>Password {{ isset($user) ? '(leave blank to keep)' : '*' }}</label>
                    <input type="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                <div class="form-group">
                    <label>System Role (legacy) *</label>
                    <select name="role" class="form-control" required>
                        <option value="editor" {{ old('role', $user->role ?? '') === 'editor' ? 'selected' : '' }}>Editor</option>
                        <option value="superadmin" {{ old('role', $user->role ?? '') === 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>RBAC Role</label>
                    <select name="role_id" class="form-control">
                        <option value="">— Select Role —</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>{{ $role->display_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Department</label>
                    <select name="department_id" class="form-control">
                        <option value="">— None —</option>
                        @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id', $user->department_id ?? '') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Staff ID</label>
                    <input type="text" name="staff_id" class="form-control" value="{{ old('staff_id', $user->staff_id ?? '') }}">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}">
                </div>
                <div class="form-group" style="display:flex;align-items:center;gap:8px;padding-top:20px;">
                    <input type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}>
                    <label for="is_active" style="font-weight:400;">Account is Active</label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ isset($user) ? 'Update User' : 'Create User' }}</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
