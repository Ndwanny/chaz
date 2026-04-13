@extends('layouts.app')
@section('title', 'Career Opportunities — CHAZ')
@section('content')
<div class="page-hero">
    <div class="container">
        <div class="page-hero__eyebrow">Careers</div>
        <h1 class="page-hero__title">Career Opportunities</h1>
        <p class="page-hero__sub">Join a mission-driven team committed to transforming health outcomes across Zambia. View our current vacancies below.</p>
        <div class="page-hero__breadcrumb"><a href="{{ route('home') }}">Home</a> / Jobs</div>
    </div>
</div>
<section class="section">
    <div class="container">
        <div style="background:rgba(27,67,50,0.05);border-radius:var(--radius-md);padding:1.25rem 1.5rem;margin-bottom:2.5rem;display:flex;gap:1rem;align-items:flex-start;" class="fade-in">
            <i class="fa fa-circle-info" style="color:var(--color-forest);margin-top:0.2rem;flex-shrink:0;"></i>
            <p style="font-size:0.875rem;color:var(--color-slate-mid);line-height:1.7;">Applications should be sent to <strong>hr@chaz.org.zm</strong> with the position title as the subject line. Only shortlisted candidates will be contacted. CHAZ is an equal opportunity employer.</p>
        </div>
        <div style="display:flex;flex-direction:column;gap:1.5rem;">
            @foreach($jobs as $job)
            <div class="job-card fade-in">
                <div class="job-card__icon"><i class="fa fa-briefcase-medical"></i></div>
                <div class="job-card__body">
                    <div class="job-card__title">{{ $job->title }}</div>
                    <div class="job-card__tags">
                        <span class="job-tag">{{ $job->department }}</span>
                        <span class="job-tag">{{ $job->type }}</span>
                        <span class="job-tag"><i class="fa fa-location-dot"></i> {{ $job->location }}</span>
                        <span class="job-tag job-tag--deadline"><i class="fa fa-clock"></i> Deadline: {{ $job->deadline->format('M j, Y') }}</span>
                    </div>
                    <p class="job-card__desc">{{ $job->description }}</p>
                    <div class="job-card__footer">
                        <div class="job-card__meta">
                            <span><i class="fa fa-calendar-plus"></i> Posted: {{ $job->posted_at->format('M j, Y') }}</span>
                        </div>
                        <a href="{{ route('jobs.show', $job->id) }}" class="btn btn--forest btn--sm">View Details <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
