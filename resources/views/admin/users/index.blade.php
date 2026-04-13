@extends('admin.layouts.app')
@section('title', 'Users')
@section('breadcrumb', 'System / Users')

@section('content')
<div class="page-header">
    <div><div class="page-title">Admin Users</div><div class="page-subtitle">{{ $users->total() }} users registered</div></div>
    @if(admin_can('manage_system'))
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New User</a>
    @endif
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Name</th><th>Email</th><th>Role</th><th>Department</th><th>Staff ID</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @forelse($users as $user)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div class="user-avatar" style="width:30px;height:30px;font-size:.72rem;background:var(--primary);border-radius:50%;display:grid;place-items:center;color:#fff;font-weight:700;flex-shrink:0;">{{ $user->initials }}</div>
                        <span>{{ $user->name }}</span>
                    </div>
                </td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->roleModel->display_name ?? ucfirst($user->role) }}</td>
                <td>{{ $user->department->name ?? '—' }}</td>
                <td>{{ $user->staff_id ?? '—' }}</td>
                <td><span class="badge badge-{{ $user->is_active ? 'green' : 'red' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span></td>
                <td>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline"><i class="fas fa-pen"></i> Edit</a>
                    @if($user->id !== session('admin_id'))
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display:inline;" onsubmit="return confirm('Delete this user?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:var(--text-muted);">No users found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;">{{ $users->links() }}</div>
</div>
@endsection
