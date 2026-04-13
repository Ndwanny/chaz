@extends('admin.layouts.app')
@section('title','Tenders')
@section('page-title','Tenders')
@section('topbar-actions')
    <a href="{{ route('admin.tenders.create') }}" class="topbar__btn topbar__btn--forest"><i class="fa fa-plus"></i> Add Tender</a>
@endsection

@section('content')
<div class="page-header">
    <div><div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / Tenders</div><h2>Tenders</h2></div>
</div>
<div class="card">
    <div class="card-header"><h3>All Tenders ({{ $tenders->total() }})</h3></div>
    <div class="table-wrap">
        @if($tenders->count())
        <table>
            <thead><tr><th>Reference</th><th>Title</th><th>Category</th><th>Deadline</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @foreach($tenders as $tender)
            <tr>
                <td style="font-size:0.78rem;font-weight:700;color:var(--slate-mid);">{{ $tender->reference }}</td>
                <td style="font-weight:600;font-size:0.875rem;max-width:260px;">{{ $tender->title }}</td>
                <td><span class="badge badge-gold">{{ $tender->category }}</span></td>
                <td style="font-size:0.8rem;color:{{ $tender->deadline->isPast() && $tender->status === 'open' ? 'var(--red)' : 'var(--slate-mid)' }};">{{ $tender->deadline->format('M d, Y') }}</td>
                <td><span class="badge {{ $tender->status === 'open' ? 'badge-green' : ($tender->status === 'awarded' ? 'badge-blue' : 'badge-red') }}">{{ $tender->status }}</span></td>
                <td>
                    <div style="display:flex;gap:0.4rem;">
                        <a href="{{ route('admin.tenders.edit', $tender) }}" class="btn btn-outline btn-sm"><i class="fa fa-pen"></i> Edit</a>
                        <form action="{{ route('admin.tenders.destroy', $tender) }}" method="POST" onsubmit="return confirm('Delete this tender?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div style="padding:1rem 1.5rem;">{{ $tenders->links() }}</div>
        @else
        <div class="empty-state"><i class="fa fa-file-contract"></i><p>No tenders yet.</p></div>
        @endif
    </div>
</div>
@endsection
