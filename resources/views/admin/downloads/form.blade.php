@extends('admin.layouts.app')
@section('title', $download ? 'Edit Download' : 'Add Download')
@section('page-title', $download ? 'Edit Download' : 'Add Download')

@section('content')
<div class="page-header">
    <div><div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / <a href="{{ route('admin.downloads.index') }}">Downloads</a> / {{ $download ? 'Edit' : 'Add' }}</div><h2>{{ $download ? 'Edit Download' : 'Add Download' }}</h2></div>
    <a href="{{ route('admin.downloads.index') }}" class="btn btn-outline"><i class="fa fa-arrow-left"></i> Back</a>
</div>
<div class="card" style="max-width:700px;">
    <div class="card-header"><h3>Download Details</h3></div>
    <div class="card-body">
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf @if($download) @method('PUT') @endif
            <div class="form-grid form-grid--2">
                <div class="form-group span-2">
                    <label class="form-label">Title <span>*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $download?->title) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Category <span>*</span></label>
                    <select name="category" class="form-control" required>
                        <option value="publication"   {{ old('category', $download?->category) === 'publication'   ? 'selected' : '' }}>Publication</option>
                        <option value="annual_report" {{ old('category', $download?->category) === 'annual_report' ? 'selected' : '' }}>Annual Report</option>
                        <option value="newsletter"    {{ old('category', $download?->category) === 'newsletter'    ? 'selected' : '' }}>Newsletter</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Type / Sub-category</label>
                    <input type="text" name="type" class="form-control" value="{{ old('type', $download?->type) }}" placeholder="e.g. Policy Brief, Programme Report">
                </div>
                <div class="form-group">
                    <label class="form-label">Year</label>
                    <input type="text" name="year" class="form-control" value="{{ old('year', $download?->year) }}" placeholder="2024" maxlength="4">
                </div>
                <div class="form-group">
                    <label class="form-label">Issue (Newsletters)</label>
                    <input type="text" name="issue" class="form-control" value="{{ old('issue', $download?->issue) }}" placeholder="Vol. 18, Issue 1">
                </div>
                <div class="form-group">
                    <label class="form-label">Pages</label>
                    <input type="number" name="pages" class="form-control" value="{{ old('pages', $download?->pages) }}" min="1">
                </div>
                <div class="form-group">
                    <label class="form-label">Publish Date</label>
                    <input type="date" name="published_at" class="form-control" value="{{ old('published_at', $download?->published_at?->format('Y-m-d')) }}">
                </div>
                <div class="form-group span-2">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $download?->description) }}</textarea>
                </div>
                <div class="form-group span-2">
                    <label class="form-label">Upload File (PDF)</label>
                    <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx">
                    @if($download?->file_path)
                    <div class="form-hint">Current: {{ $download->file_path }} — upload new to replace.</div>
                    @endif
                </div>
            </div>
            <hr class="divider">
            <div style="display:flex;gap:0.75rem;">
                <button type="submit" class="btn btn-forest"><i class="fa fa-floppy-disk"></i> {{ $download ? 'Save Changes' : 'Add Download' }}</button>
                <a href="{{ route('admin.downloads.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
