@extends('admin.layouts.app')
@section('title', 'Announcements')
@section('breadcrumb', 'Communications / Announcements')

@section('content')
<div class="page-header">
    <div><div class="page-title">Announcements</div><div class="page-subtitle">{{ $announcements->total() }} total</div></div>
    @if(admin_can('manage_content') || admin_can('manage_comms'))
    <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New Announcement</a>
    @endif
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Title</th><th>Category</th><th>Priority</th><th>Audience</th><th>Published</th><th>Expires</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($announcements as $ann)
            <tr>
                <td>
                    <div style="font-weight:600;">{{ $ann->title }}</div>
                    <div style="font-size:.75rem;color:var(--text-muted);">By {{ $ann->createdBy->name ?? '—' }}</div>
                </td>
                <td><span class="badge badge-blue">{{ ucfirst($ann->category) }}</span></td>
                <td><span class="badge badge-{{ $ann->priority_color }}">{{ ucfirst($ann->priority) }}</span></td>
                <td>{{ ucfirst($ann->target_audience) }}</td>
                <td>{{ $ann->published_at?->format('d M Y') ?? '—' }}</td>
                <td>{{ $ann->expires_at?->format('d M Y') ?? 'Never' }}</td>
                <td>
                    @if(!$ann->is_published)
                        <span class="badge badge-grey">Draft</span>
                    @elseif($ann->isExpired())
                        <span class="badge badge-red">Expired</span>
                    @else
                        <span class="badge badge-green">Live</span>
                    @endif
                </td>
                <td>
                    @if(admin_can('manage_content') || admin_can('manage_comms'))
                    <a href="{{ route('admin.announcements.edit', $ann) }}" class="btn btn-xs btn-outline"><i class="fas fa-pen"></i></a>
                    <form method="POST" action="{{ route('admin.announcements.destroy', $ann) }}" style="display:inline;" onsubmit="return confirm('Delete this announcement?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:var(--text-muted);">No announcements yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;">{{ $announcements->links() }}</div>
</div>
@endsection
