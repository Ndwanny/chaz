@extends('admin.layouts.app')
@section('title','Members')
@section('page-title','Member Institutions')
@section('topbar-actions')
    <a href="{{ route('admin.members.create') }}" class="topbar__btn topbar__btn--forest"><i class="fa fa-plus"></i> Add Member</a>
@endsection

@section('content')
<div class="page-header">
    <div><div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / Members</div><h2>Member Institutions</h2></div>
</div>
<div class="card">
    <div class="card-header"><h3>All Members ({{ $members->total() }})</h3></div>
    <div class="table-wrap">
        @if($members->count())
        <table>
            <thead><tr><th>Name</th><th>Type</th><th>Province</th><th>Denomination</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @foreach($members as $member)
            <tr>
                <td style="font-weight:600;font-size:0.875rem;">{{ $member->name }}</td>
                <td><span class="badge {{ $member->type === 'hospital' ? 'badge-green' : ($member->type === 'centre' ? 'badge-gold' : 'badge-blue') }}">{{ ucfirst($member->type) }}</span></td>
                <td style="font-size:0.83rem;">{{ $member->province }}</td>
                <td style="font-size:0.83rem;max-width:200px;">{{ $member->denomination }}</td>
                <td><span class="badge {{ $member->active ? 'badge-green' : 'badge-grey' }}">{{ $member->active ? 'Active' : 'Inactive' }}</span></td>
                <td>
                    <div style="display:flex;gap:0.4rem;">
                        <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-outline btn-sm"><i class="fa fa-pen"></i></a>
                        <form action="{{ route('admin.members.destroy', $member) }}" method="POST" onsubmit="return confirm('Remove this member?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div style="padding:1rem 1.5rem;">{{ $members->links() }}</div>
        @else
        <div class="empty-state"><i class="fa fa-hospital"></i><p>No members yet.</p></div>
        @endif
    </div>
</div>
@endsection
