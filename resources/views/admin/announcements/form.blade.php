@extends('admin.layouts.app')
@section('title', isset($announcement) ? 'Edit Announcement' : 'New Announcement')
@section('page-title', 'Announcements')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">{{ isset($announcement) ? 'Edit Announcement' : 'New Announcement' }}</div>
        <div class="page-subtitle">{{ isset($announcement) ? 'Update this announcement' : 'Post a new announcement to staff' }}</div>
    </div>
    <a href="{{ route('admin.announcements.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

@if($errors->any())
<div class="alert alert-danger">
    <ul style="margin:0;padding-left:1.2rem;">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
</div>
@endif

<form method="POST"
      action="{{ isset($announcement) ? route('admin.announcements.update', $announcement) : route('admin.announcements.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if(isset($announcement)) @method('PUT') @endif

    <div style="display:grid;grid-template-columns:1fr 320px;gap:1.25rem;align-items:start;">

        {{-- Main content --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title"><i class="fas fa-bullhorn" style="color:var(--forest);margin-right:.4rem;"></i> Announcement Content</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $announcement->title ?? '') }}" required maxlength="200" placeholder="Announcement headline…">
                </div>

                <div class="form-group">
                    <label class="form-label">Content <span class="text-danger">*</span></label>
                    <textarea name="content" class="form-control" rows="10" required placeholder="Full announcement text…">{{ old('content', $announcement->content ?? '') }}</textarea>
                </div>

                @if(!isset($announcement))
                <div class="form-group">
                    <label class="form-label">Attachment <span style="font-size:.78rem;color:var(--slate-mid);">(PDF, DOCX, JPG, PNG — max 10 MB)</span></label>
                    <input type="file" name="attachment" class="form-control" accept=".pdf,.docx,.jpg,.jpeg,.png">
                </div>
                @elseif($announcement->attachment)
                <div class="form-group">
                    <label class="form-label">Current Attachment</label>
                    <div style="font-size:.85rem;padding:.5rem .75rem;background:var(--bg);border-radius:6px;">
                        <i class="fas fa-paperclip"></i> {{ basename($announcement->attachment) }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Settings sidebar --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem;">

            <div class="card">
                <div class="card-header">
                    <span class="card-title"><i class="fas fa-sliders" style="color:var(--forest);margin-right:.4rem;"></i> Settings</span>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category" class="form-control" required>
                            @foreach(['general' => 'General', 'hr' => 'HR', 'finance' => 'Finance', 'it' => 'IT', 'operations' => 'Operations', 'event' => 'Event', 'urgent' => 'Urgent'] as $val => $label)
                            <option value="{{ $val }}" {{ old('category', $announcement->category ?? 'general') === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Priority <span class="text-danger">*</span></label>
                        <select name="priority" class="form-control" required>
                            @foreach(['low' => 'Low', 'normal' => 'Normal', 'high' => 'High', 'urgent' => 'Urgent'] as $val => $label)
                            <option value="{{ $val }}" {{ old('priority', $announcement->priority ?? 'normal') === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Target Audience <span class="text-danger">*</span></label>
                        <select name="target_audience" class="form-control" id="target_audience" required>
                            @foreach(['all' => 'All Staff', 'staff' => 'Staff Only', 'management' => 'Management', 'department' => 'Specific Department'] as $val => $label)
                            <option value="{{ $val }}" {{ old('target_audience', $announcement->target_audience ?? 'all') === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" id="department_row" style="{{ old('target_audience', $announcement->target_audience ?? 'all') === 'department' ? '' : 'display:none;' }}">
                        <label class="form-label">Department</label>
                        <select name="target_id" class="form-control">
                            <option value="">— Select Department —</option>
                            @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('target_id', $announcement->target_id ?? '') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Expiry Date <span style="font-size:.78rem;color:var(--slate-mid);">(optional)</span></label>
                        <input type="datetime-local" name="expires_at" class="form-control"
                               value="{{ old('expires_at', $announcement?->expires_at?->format('Y-m-d\TH:i') ?? '') }}">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="form-group" style="margin-bottom:1rem;">
                        <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;font-weight:500;">
                            <input type="checkbox" name="is_published" value="1"
                                   {{ old('is_published', $announcement->is_published ?? false) ? 'checked' : '' }}>
                            Publish immediately
                        </label>
                        <div style="font-size:.76rem;color:var(--slate-mid);margin-top:.25rem;margin-left:1.25rem;">
                            Unchecked saves as draft
                        </div>
                    </div>

                    <div style="display:flex;gap:.75rem;">
                        <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center;">
                            <i class="fas fa-save"></i> {{ isset($announcement) ? 'Update' : 'Save' }}
                        </button>
                        <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

@push('styles')
<style>
@media (max-width: 900px) {
    form > div[style*="grid-template-columns"] { grid-template-columns: 1fr !important; }
}
</style>
@endpush

@push('scripts')
<script>
document.getElementById('target_audience').addEventListener('change', function () {
    document.getElementById('department_row').style.display = this.value === 'department' ? '' : 'none';
});
</script>
@endpush
@endsection
