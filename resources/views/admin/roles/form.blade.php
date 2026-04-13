@extends('admin.layouts.app')
@section('title', isset($role) ? 'Edit Role' : 'New Role')
@section('page-title', isset($role) ? 'Edit Role' : 'New Role')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">{{ isset($role) ? 'Edit: ' . $role->name : 'New Role' }}</div>
        <div class="page-subtitle">{{ isset($role) ? 'Update role details and permissions' : 'Create a new role and assign permissions' }}</div>
    </div>
    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

@if($errors->any())
<div class="alert alert-danger">
    <ul style="margin:0;padding-left:1.2rem;">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ isset($role) ? route('admin.roles.update', $role) : route('admin.roles.store') }}">
    @csrf
    @if(isset($role)) @method('PUT') @endif

    <div style="display:grid;grid-template-columns:1fr 1.8fr;gap:1.5rem;align-items:start;">

        {{-- Role Details --}}
        <div class="card">
            <div class="card-header"><span class="card-title">Role Details</span></div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Role Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $role->name ?? '') }}" required placeholder="e.g. HR Manager">
                </div>

                @if(!isset($role))
                <div class="form-group">
                    <label class="form-label">Slug <span class="text-danger">*</span></label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required placeholder="e.g. hr_manager">
                    <div class="form-hint">Lowercase, underscores only. Cannot be changed later.</div>
                </div>
                @else
                <div class="form-group">
                    <label class="form-label">Slug</label>
                    <input type="text" class="form-control" value="{{ $role->slug }}" disabled style="background:#F8FAFB;color:var(--slate-mid);">
                </div>
                @endif

                <div class="form-group">
                    <label class="form-label">Access Level <span class="text-danger">*</span></label>
                    <input type="number" name="level" class="form-control" min="1" max="10" value="{{ old('level', $role->level ?? 1) }}" required>
                    <div class="form-hint">1 = lowest, 10 = highest (Super Admin). Higher levels can see lower-level users.</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="What does this role do?">{{ old('description', $role->description ?? '') }}</textarea>
                </div>

                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;font-size:.875rem;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $role->is_active ?? true) ? 'checked' : '' }}>
                        Active (users can be assigned this role)
                    </label>
                </div>

                <div style="margin-top:1.25rem;">
                    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                        <i class="fas fa-save"></i> {{ isset($role) ? 'Update Role' : 'Create Role' }}
                    </button>
                </div>
            </div>
        </div>

        {{-- Permissions --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">Permissions</span>
                <div style="display:flex;gap:.5rem;">
                    <button type="button" class="btn btn-outline btn-xs" onclick="setAll(true)">Select All</button>
                    <button type="button" class="btn btn-outline btn-xs" onclick="setAll(false)">Clear All</button>
                </div>
            </div>
            <div class="card-body" style="padding:0;">
                @foreach($permissions as $group => $groupPerms)
                <div style="border-bottom:1px solid var(--border);">
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:.75rem 1.25rem;background:#F8FAFB;">
                        <span style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--slate-mid);">{{ ucfirst($group) }}</span>
                        <button type="button" class="btn btn-outline btn-xs" onclick="toggleGroup('{{ $group }}')">Toggle</button>
                    </div>
                    <div style="padding:.6rem 1.25rem 1rem;display:grid;grid-template-columns:1fr 1fr;gap:.4rem;" class="perm-group" data-group="{{ $group }}">
                        @foreach($groupPerms as $perm)
                        <label style="display:flex;align-items:flex-start;gap:.5rem;cursor:pointer;padding:.35rem .5rem;border-radius:6px;transition:background .15s;" onmouseover="this.style.background='#F0FDF4'" onmouseout="this.style.background=''">
                            <input type="checkbox" name="permissions[]" value="{{ $perm->id }}"
                                class="perm-cb perm-group-{{ $group }}"
                                style="margin-top:2px;accent-color:var(--forest);"
                                {{ in_array($perm->id, $rolePermissionIds ?? []) || old('permissions') && in_array($perm->id, old('permissions', [])) ? 'checked' : '' }}>
                            <span style="font-size:.83rem;line-height:1.4;">{{ $perm->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            <div class="card-body" style="border-top:1px solid var(--border);background:#F8FAFB;">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ isset($role) ? 'Update Role' : 'Create Role' }}</button>
            </div>
        </div>
    </div>
</form>

@push('styles')
<style>
@media (max-width: 900px) {
    form > div[style*="grid-template-columns"] { grid-template-columns: 1fr !important; }
    .perm-group[style*="grid-template-columns"] { grid-template-columns: 1fr !important; }
}
</style>
@endpush
@push('scripts')
<script>
function setAll(checked) {
    document.querySelectorAll('.perm-cb').forEach(cb => cb.checked = checked);
}
function toggleGroup(group) {
    const cbs = document.querySelectorAll('.perm-group-' + group);
    const anyUnchecked = [...cbs].some(cb => !cb.checked);
    cbs.forEach(cb => cb.checked = anyUnchecked);
}
// Auto-generate slug from name on create
@if(!isset($role))
const nameInput = document.querySelector('[name=name]');
const slugInput = document.querySelector('[name=slug]');
let slugTouched = false;
slugInput?.addEventListener('input', () => slugTouched = true);
nameInput?.addEventListener('input', () => {
    if (!slugTouched) {
        slugInput.value = nameInput.value.toLowerCase().replace(/[^a-z0-9]+/g,'_').replace(/^_|_$/g,'');
    }
});
@endif
</script>
@endpush
@endsection
