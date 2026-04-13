@extends('layouts.app')
@section('title', $job->title . ' — CHAZ Careers')
@section('content')
<div class="page-hero">
    <div class="container">
        <div class="page-hero__eyebrow">Careers</div>
        <h1 class="page-hero__title">{{ $job->title }}</h1>
        <div class="page-hero__breadcrumb">
            <a href="{{ route('home') }}">Home</a> / <a href="{{ route('jobs') }}">Jobs</a> / {{ $job->title }}
        </div>
    </div>
</div>
<section class="section">
    <div class="container" style="max-width:860px;">
        {{-- Tags --}}
        <div style="display:flex;gap:0.75rem;flex-wrap:wrap;margin-bottom:2rem;padding-bottom:1.5rem;border-bottom:1px solid var(--color-border);">
            <span class="job-tag">{{ $job->department }}</span>
            <span class="job-tag">{{ $job->type }}</span>
            <span class="job-tag"><i class="fa fa-location-dot"></i> {{ $job->location }}</span>
            <span class="job-tag job-tag--deadline"><i class="fa fa-clock"></i> Deadline: {{ $job->deadline->format('M j, Y') }}</span>
            <span class="job-tag"><i class="fa fa-calendar-plus"></i> Posted: {{ $job->posted_at->format('M j, Y') }}</span>
        </div>

        {{-- Description --}}
        <div style="margin-bottom:2rem;">
            <h3 style="font-family:var(--font-display);font-size:1.1rem;color:var(--color-forest);margin-bottom:0.75rem;">Position Overview</h3>
            <p style="color:var(--color-slate-mid);line-height:1.85;font-size:0.95rem;">{{ $job->description }}</p>
        </div>

        {{-- Duties --}}
        <div style="background:var(--color-cream);border-radius:var(--radius-md);padding:2rem;margin-bottom:1.5rem;">
            <h3 style="font-family:var(--font-display);font-size:1.1rem;color:var(--color-forest);margin-bottom:1rem;">Key Duties &amp; Responsibilities</h3>
            <ul style="display:flex;flex-direction:column;gap:0.7rem;">
                @foreach($job->duties as $duty)
                <li style="display:flex;gap:0.75rem;align-items:flex-start;font-size:0.9rem;color:var(--color-slate-mid);line-height:1.7;">
                    <i class="fa fa-circle-dot" style="color:var(--color-gold);margin-top:0.35rem;font-size:0.6rem;flex-shrink:0;"></i>
                    {{ $duty }}
                </li>
                @endforeach
            </ul>
        </div>

        {{-- Qualifications --}}
        <div style="background:var(--color-cream);border-radius:var(--radius-md);padding:2rem;margin-bottom:2rem;">
            <h3 style="font-family:var(--font-display);font-size:1.1rem;color:var(--color-forest);margin-bottom:1rem;">Required Qualifications</h3>
            <ul style="display:flex;flex-direction:column;gap:0.7rem;">
                @foreach($job->qualifications as $q)
                <li style="display:flex;gap:0.75rem;align-items:flex-start;font-size:0.9rem;color:var(--color-slate-mid);line-height:1.7;">
                    <i class="fa fa-check-circle" style="color:var(--color-forest-lite);margin-top:0.2rem;flex-shrink:0;"></i>
                    {{ $q }}
                </li>
                @endforeach
            </ul>
        </div>

        {{-- How to apply --}}
        <div style="background:var(--color-forest);border-radius:var(--radius-md);padding:2rem;color:white;margin-bottom:2rem;">
            <h3 style="font-family:var(--font-display);font-size:1.1rem;color:var(--color-gold);margin-bottom:0.75rem;">How to Apply</h3>
            <p style="font-size:0.9rem;opacity:0.85;line-height:1.85;">
                Send your CV and cover letter to <strong style="color:var(--color-gold-lite);">hr@chaz.org.zm</strong> with the subject line <em>"{{ $job->title }}"</em>. Applications must be received by <strong style="color:var(--color-gold-lite);">{{ $job->deadline->format('M j, Y') }}</strong>. Only shortlisted candidates will be contacted. CHAZ is an equal opportunity employer and does not discriminate on any basis.
            </p>
        </div>

        <div style="display:flex;gap:1rem;flex-wrap:wrap;">
            <a href="{{ route('jobs') }}" class="btn btn--outline"><i class="fa fa-arrow-left"></i> Back to Jobs</a>
            <a href="mailto:hr@chaz.org.zm?subject={{ urlencode($job->title) }}" class="btn btn--forest"><i class="fa fa-envelope"></i> Apply by Email</a>
        </div>
    </div>
</section>
@endsection
