@extends('admin.layouts.app')
@section('title','News Articles')
@section('page-title','News Articles')
@section('topbar-actions')
    <a href="{{ route('admin.news.create') }}" class="topbar__btn topbar__btn--forest"><i class="fa fa-plus"></i> New Article</a>
@endsection

@section('content')
<div class="page-header">
    <div>
        <div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / News</div>
        <h2>News Articles</h2>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>All Articles ({{ $news->total() }})</h3>
    </div>
    <div class="table-wrap">
        @if($news->count())
        <table>
            <thead>
                <tr><th>Title</th><th>Tag</th><th>Author</th><th>Status</th><th>Published</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @foreach($news as $article)
            <tr>
                <td style="max-width:300px;">
                    <div style="font-weight:600;font-size:0.875rem;color:var(--slate);">{{ $article->title }}</div>
                    <div style="font-size:0.75rem;color:var(--slate-mid);margin-top:0.2rem;">{{ Str::limit($article->excerpt, 80) }}</div>
                </td>
                <td><span class="badge badge-blue">{{ $article->tag }}</span></td>
                <td style="font-size:0.83rem;">{{ $article->author }}</td>
                <td><span class="badge {{ $article->status === 'published' ? 'badge-green' : 'badge-grey' }}">{{ $article->status }}</span></td>
                <td style="font-size:0.8rem;color:var(--slate-mid);">
                    {{ $article->published_at ? $article->published_at->format('M d, Y') : '—' }}
                </td>
                <td>
                    <div style="display:flex;gap:0.4rem;">
                        <a href="{{ route('admin.news.edit', $article) }}" class="btn btn-outline btn-sm"><i class="fa fa-pen"></i> Edit</a>
                        <form action="{{ route('admin.news.destroy', $article) }}" method="POST" onsubmit="return confirm('Delete this article?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div style="padding:1rem 1.5rem;">{{ $news->links() }}</div>
        @else
        <div class="empty-state"><i class="fa fa-newspaper"></i><p>No articles yet. <a href="{{ route('admin.news.create') }}" style="color:var(--forest);">Create your first article.</a></p></div>
        @endif
    </div>
</div>
@endsection
