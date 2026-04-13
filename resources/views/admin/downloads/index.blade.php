@extends('admin.layouts.app')
@section('title','Downloads')
@section('page-title','Downloads')
@section('topbar-actions')
    <a href="{{ route('admin.downloads.create') }}" class="topbar__btn topbar__btn--forest"><i class="fa fa-plus"></i> Add Download</a>
@endsection

@section('content')
<div class="page-header">
    <div><div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / Downloads</div><h2>Downloads</h2></div>
</div>
<div class="card">
    <div class="card-header"><h3>All Downloads ({{ $downloads->total() }})</h3></div>
    <div class="table-wrap">
        @if($downloads->count())
        <table>
            <thead><tr><th>Title</th><th>Category</th><th>Year</th><th>Size</th><th>Actions</th></tr></thead>
            <tbody>
            @foreach($downloads as $dl)
            <tr>
                <td style="font-weight:600;font-size:0.875rem;">{{ $dl->title }}</td>
                <td><span class="badge badge-blue">{{ str_replace('_',' ', ucfirst($dl->category)) }}</span></td>
                <td style="font-size:0.83rem;">{{ $dl->year ?? '—' }}</td>
                <td style="font-size:0.83rem;">{{ $dl->file_size ?? '—' }}</td>
                <td>
                    <div style="display:flex;gap:0.4rem;">
                        <a href="{{ route('admin.downloads.edit', $dl) }}" class="btn btn-outline btn-sm"><i class="fa fa-pen"></i></a>
                        <form action="{{ route('admin.downloads.destroy', $dl) }}" method="POST" onsubmit="return confirm('Delete this download?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div style="padding:1rem 1.5rem;">{{ $downloads->links() }}</div>
        @else
        <div class="empty-state"><i class="fa fa-download"></i><p>No downloads yet.</p></div>
        @endif
    </div>
</div>
@endsection
