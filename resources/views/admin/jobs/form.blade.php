@extends('admin.layouts.app')
@section('title', $job ? 'Edit Job' : 'New Job Posting')
@section('page-title', $job ? 'Edit Job' : 'New Job Posting')

@section('content')
<div class="page-header">
    <div>
        <div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / <a href="{{ route('admin.jobs.index') }}">Jobs</a> / {{ $job ? 'Edit' : 'New' }}</div>
        <h2>{{ $job ? 'Edit: ' . $job->title : 'Create Job Posting' }}</h2>
    </div>
    <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline"><i class="fa fa-arrow-left"></i> Back</a>
</div>

<form action="{{ $action }}" method="POST">
    @csrf @if($job) @method('PUT') @endif
    <div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;align-items:flex-start;">
        <div style="display:flex;flex-direction:column;gap:1.5rem;">
            <div class="card">
                <div class="card-header"><h3>Job Details</h3></div>
                <div class="card-body">
                    <div class="form-grid form-grid--2">
                        <div class="form-group span-2">
                            <label class="form-label">Job Title <span>*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $job?->title) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Department <span>*</span></label>
                            <input type="text" name="department" class="form-control" value="{{ old('department', $job?->department) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Location <span>*</span></label>
                            <input type="text" name="location" class="form-control" value="{{ old('location', $job?->location) }}" required placeholder="e.g. Lusaka Secretariat">
                        </div>
                        <div class="form-group span-2">
                            <label class="form-label">Description <span>*</span></label>
                            <textarea name="description" class="form-control" rows="4" required>{{ old('description', $job?->description) }}</textarea>
                        </div>
                        <div class="form-group span-2">
                            <label class="form-label">Duties &amp; Responsibilities <span>*</span></label>
                            <textarea name="duties" class="form-control" rows="6" required placeholder="One duty per line">{{ old('duties', $job ? implode("\n", $job->duties) : '') }}</textarea>
                            <div class="form-hint">Enter each duty on a new line.</div>
                        </div>
                        <div class="form-group span-2">
                            <label class="form-label">Qualifications <span>*</span></label>
                            <textarea name="qualifications" class="form-control" rows="5" required placeholder="One qualification per line">{{ old('qualifications', $job ? implode("\n", $job->qualifications) : '') }}</textarea>
                            <div class="form-hint">Enter each qualification on a new line.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:1.5rem;">
            <div class="card">
                <div class="card-header"><h3>Settings</h3></div>
                <div class="card-body">
                    <div class="form-group" style="margin-bottom:1rem;">
                        <label class="form-label">Employment Type <span>*</span></label>
                        <select name="type" class="form-control">
                            @foreach(['Full-time','Part-time','Contract','Consultancy','Internship'] as $t)
                            <option value="{{ $t }}" {{ old('type', $job?->type) === $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom:1rem;">
                        <label class="form-label">Posting Date <span>*</span></label>
                        <input type="date" name="posted_at" class="form-control" value="{{ old('posted_at', $job?->posted_at?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required>
                    </div>
                    <div class="form-group" style="margin-bottom:1rem;">
                        <label class="form-label">Closing Deadline <span>*</span></label>
                        <input type="date" name="deadline" class="form-control" value="{{ old('deadline', $job?->deadline?->format('Y-m-d')) }}" required>
                    </div>
                    <div class="form-group" style="margin-bottom:1.5rem;">
                        <label class="form-label">Status <span>*</span></label>
                        <select name="status" class="form-control">
                            <option value="open"   {{ old('status', $job?->status) === 'open'   ? 'selected' : '' }}>Open</option>
                            <option value="closed" {{ old('status', $job?->status) === 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-forest" style="width:100%;justify-content:center;">
                        <i class="fa fa-floppy-disk"></i> {{ $job ? 'Save Changes' : 'Create Posting' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
