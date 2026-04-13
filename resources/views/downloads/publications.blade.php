@extends('layouts.app')
@section('title', 'Publications — CHAZ')
@section('content')
<div class="page-hero">
    <div class="container">
        <div class="page-hero__eyebrow">Downloads</div>
        <h1 class="page-hero__title">Publications</h1>
        <p class="page-hero__sub">Programme reports, policy briefs, strategic plans, evaluation reports and training manuals.</p>
        <div class="page-hero__breadcrumb"><a href="{{ route('home') }}">Home</a> / <a href="{{ route('downloads') }}">Downloads</a> / Publications</div>
    </div>
</div>
<section class="section">
    <div class="container">
        <div class="resource-list">
            @foreach($publications as $pub)
            <div class="resource-item fade-in">
                <div class="resource-item__icon"><i class="fa fa-file-pdf"></i></div>
                <div class="resource-item__body">
                    <div class="resource-item__title">{{ $pub->title }}</div>
                    <div class="resource-item__meta">
                        <span><i class="fa fa-calendar"></i> {{ $pub->year }}</span>
                        <span><i class="fa fa-tag"></i> {{ $pub->type }}</span>
                        @if($pub->pages)<span><i class="fa fa-file"></i> {{ $pub->pages }} pages</span>@endif
                        @if($pub->file_size)<span><i class="fa fa-weight-hanging"></i> {{ $pub->file_size }}</span>@endif
                    </div>
                </div>
                <div class="resource-item__actions">
                    <a href="{{ $pub->file_path ? asset('storage/' . $pub->file_path) : '#' }}" class="btn btn--forest btn--sm"><i class="fa fa-download"></i> Download</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
