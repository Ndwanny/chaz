@extends('admin.layouts.app')
@section('title','Messages')
@section('page-title','Contact Messages')

@section('content')
<div class="page-header">
    <div><div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / Messages</div><h2>Contact Messages</h2></div>
</div>
<div class="card">
    <div class="card-header"><h3>All Messages ({{ $messages->total() }})</h3></div>
    <div class="table-wrap">
        @if($messages->count())
        <table>
            <thead><tr><th>From</th><th>Subject</th><th>Phone</th><th>Received</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @foreach($messages as $msg)
            <tr style="{{ !$msg->read ? 'background:#FFFDF5;font-weight:600;' : '' }}">
                <td>
                    <div style="font-size:0.875rem;">{{ $msg->name }}</div>
                    <div style="font-size:0.75rem;color:var(--slate-mid);">{{ $msg->email }}</div>
                </td>
                <td style="font-size:0.875rem;max-width:240px;">
                    @if(!$msg->read)<span style="display:inline-block;width:7px;height:7px;background:var(--gold);border-radius:50%;margin-right:5px;vertical-align:middle;"></span>@endif
                    {{ $msg->subject }}
                </td>
                <td style="font-size:0.82rem;color:var(--slate-mid);">{{ $msg->phone ?? '—' }}</td>
                <td style="font-size:0.8rem;color:var(--slate-mid);white-space:nowrap;">{{ $msg->created_at->format('M d, Y H:i') }}</td>
                <td><span class="badge {{ $msg->read ? 'badge-grey' : 'badge-gold' }}">{{ $msg->read ? 'Read' : 'Unread' }}</span></td>
                <td>
                    <div style="display:flex;gap:0.4rem;">
                        <a href="{{ route('admin.messages.show', $msg) }}" class="btn btn-outline btn-sm"><i class="fa fa-eye"></i> View</a>
                        <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div style="padding:1rem 1.5rem;">{{ $messages->links() }}</div>
        @else
        <div class="empty-state"><i class="fa fa-envelope"></i><p>No messages yet.</p></div>
        @endif
    </div>
</div>
@endsection
