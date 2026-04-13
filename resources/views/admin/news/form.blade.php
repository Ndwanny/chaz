@extends('admin.layouts.app')
@section('title', $news ? 'Edit Article' : 'New Article')
@section('page-title', $news ? 'Edit Article' : 'New Article')

@section('content')
<div class="page-header">
    <div>
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a> /
            <a href="{{ route('admin.news.index') }}">News</a> /
            {{ $news ? 'Edit' : 'New Article' }}
        </div>
        <h2>{{ $news ? 'Edit: ' . Str::limit($news->title, 50) : 'Create New Article' }}</h2>
    </div>
    <a href="{{ route('admin.news.index') }}" class="btn btn-outline"><i class="fa fa-arrow-left"></i> Back</a>
</div>

<form action="{{ $action }}" method="POST">
    @csrf
    @if($news) @method('PUT') @endif

    <div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;align-items:flex-start;">

        {{-- Main --}}
        <div style="display:flex;flex-direction:column;gap:1.5rem;">
            <div class="card">
                <div class="card-header"><h3>Article Content</h3></div>
                <div class="card-body">
                    <div class="form-grid">
                        <div class="form-group span-2">
                            <label class="form-label">Title <span>*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $news?->title) }}" required placeholder="Article headline">
                            @error('title')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group span-2">
                            <label class="form-label">Excerpt <span>*</span></label>
                            <textarea name="excerpt" class="form-control" rows="3" required placeholder="Short summary shown on news listing pages...">{{ old('excerpt', $news?->excerpt) }}</textarea>
                            @error('excerpt')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group span-2">
                            <label class="form-label">Full Content <span>*</span></label>
                            <textarea name="content" class="form-control" rows="14" required placeholder="Full article body...">{{ old('content', $news?->content) }}</textarea>
                            @error('content')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div style="display:flex;flex-direction:column;gap:1.5rem;">
            <div class="card">
                <div class="card-header"><h3>Publishing</h3></div>
                <div class="card-body">
                    <div class="form-group" style="margin-bottom:1.25rem;">
                        <label class="form-label">Status <span>*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="draft"     {{ old('status', $news?->status) === 'draft'     ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $news?->status) === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom:1.5rem;">
                        <label class="form-label">Publish Date</label>
                        <input type="datetime-local" name="published_at" class="form-control"
                               value="{{ old('published_at', $news?->published_at?->format('Y-m-d\TH:i')) }}">
                        <div class="form-hint">Leave blank to auto-set on publish.</div>
                    </div>
                    <button type="submit" class="btn btn-forest" style="width:100%;justify-content:center;">
                        <i class="fa fa-{{ $news ? 'floppy-disk' : 'plus' }}"></i>
                        {{ $news ? 'Save Changes' : 'Create Article' }}
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h3>Metadata</h3></div>
                <div class="card-body">
                    <div class="form-group" style="margin-bottom:1.25rem;">
                        <label class="form-label">Category Tag <span>*</span></label>
                        <input type="text" name="tag" class="form-control" value="{{ old('tag', $news?->tag) }}" required list="tag-suggestions" placeholder="e.g. HIV & AIDS">
                        <datalist id="tag-suggestions">
                            @foreach(['HIV & AIDS','Tuberculosis','Malaria','Immunisation','Maternal Health','Community Health','Advocacy','Partnerships','Events','General'] as $t)
                            <option value="{{ $t }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Author <span>*</span></label>
                        <input type="text" name="author" class="form-control" value="{{ old('author', $news?->author ?? 'CHAZ Communications') }}" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
