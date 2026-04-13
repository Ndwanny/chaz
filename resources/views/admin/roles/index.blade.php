@extends('admin.layouts.app')
@section('title', 'Roles & Permissions')
@section('page-title', 'Roles & Permissions')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Roles & Permissions</div>
        <div class="page-subtitle">Define what each user type can access</div>
    </div>
    @if(admin_can('manage_system'))
    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New Role</a>
    @endif
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Role Name</th>
                    <th>Slug</th>
                    <th>Level</th>
                    <th>Permissions</th>
                    <th>Users</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @forelse($roles as $role)
            <tr>
                <td>
                    <div style="font-weight:600;">{{ $role->name }}</div>
                    @if($role->description)
                    <div style="font-size:.75rem;color:var(--slate-mid);margin-top:2px;">{{ $role->description }}</div>
                    @endif
                </td>
                <td><code>{{ $role->slug }}</code></td>
                <td>
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:50%;background:rgba(27,67,50,.1);color:var(--forest);font-weight:700;font-size:.82rem;">
                        {{ $role->level }}
                    </span>
                </td>
                <td>
                    @php $perms = $role->permissions; @endphp
                    @if($perms->count())
                        <div style="display:flex;flex-wrap:wrap;gap:.3rem;max-width:320px;">
                            @foreach($perms->take(4) as $p)
                            <span class="badge badge-blue">{{ $p->name }}</span>
                            @endforeach
                            @if($perms->count() > 4)
                            <span class="badge badge-grey">+{{ $perms->count() - 4 }} more</span>
                            @endif
                        </div>
                    @else
                        <span style="color:var(--slate-mid);font-size:.8rem;">No permissions</span>
                    @endif
                </td>
                <td>
                    <span class="badge {{ $role->admins_count > 0 ? 'badge-green' : 'badge-grey' }}">
                        {{ $role->admins_count }} {{ Str::plural('user', $role->admins_count) }}
                    </span>
                </td>
                <td>
                    @if($role->is_active)
                    <span class="badge badge-success">Active</span>
                    @else
                    <span class="badge badge-secondary">Inactive</span>
                    @endif
                </td>
                <td>
                    @if(admin_can('manage_system'))
                    <div style="display:flex;gap:.4rem;">
                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-outline btn-xs"><i class="fas fa-pen"></i></a>
                        @if($role->admins_count === 0)
                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" onsubmit="return confirm('Delete role {{ addslashes($role->name) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
                        </form>
                        @endif
                    </div>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:2.5rem;color:var(--slate-mid);">
                    <i class="fas fa-user-shield" style="font-size:1.5rem;opacity:.25;display:block;margin-bottom:.5rem;"></i>
                    No roles defined yet.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
