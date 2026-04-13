@extends('admin.layouts.app')
@section('title','Job Postings')
@section('page-title','Job Postings')
@section('topbar-actions')
    <a href="{{ route('admin.jobs.create') }}" class="topbar__btn topbar__btn--forest"><i class="fa fa-plus"></i> Post a Job</a>
@endsection

@section('content')
<div class="page-header">
    <div>
        <div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / Jobs</div>
        <h2>Job Postings</h2>
    </div>
</div>
<div class="card">
    <div class="card-header"><h3>All Postings ({{ $jobs->total() }})</h3></div>
    <div class="table-wrap">
        @if($jobs->count())
        <table>
            <thead><tr><th>Title</th><th>Department</th><th>Location</th><th>Type</th><th>Deadline</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @foreach($jobs as $job)
            <tr>
                <td style="font-weight:600;font-size:0.875rem;">{{ $job->title }}</td>
                <td style="font-size:0.83rem;">{{ $job->department }}</td>
                <td style="font-size:0.83rem;">{{ $job->location }}</td>
                <td><span class="badge badge-blue">{{ $job->type }}</span></td>
                <td style="font-size:0.8rem;color:{{ $job->deadline->isPast() ? 'var(--red)' : 'var(--slate-mid)' }};">
                    {{ $job->deadline->format('M d, Y') }}
                </td>
                <td><span class="badge {{ $job->status === 'open' ? 'badge-green' : 'badge-red' }}">{{ $job->status }}</span></td>
                <td>
                    <div style="display:flex;gap:0.4rem;">
                        <a href="{{ route('admin.jobs.edit', $job) }}" class="btn btn-outline btn-sm"><i class="fa fa-pen"></i> Edit</a>
                        <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" onsubmit="return confirm('Delete this job posting?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div style="padding:1rem 1.5rem;">{{ $jobs->links() }}</div>
        @else
        <div class="empty-state"><i class="fa fa-briefcase"></i><p>No job postings yet.</p></div>
        @endif
    </div>
</div>
@endsection
