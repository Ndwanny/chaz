@extends('layouts.app')
@section('title', 'Newsletters — CHAZ')
@section('content')
<div class="page-hero">
    <div class="container">
        <div class="page-hero__eyebrow">Downloads</div>
        <h1 class="page-hero__title">Newsletters</h1>
        <p class="page-hero__sub">Quarterly newsletters featuring stories from CHAZ member institutions, programme highlights, and health updates.</p>
        <div class="page-hero__breadcrumb"><a href="{{ route('home') }}">Home</a> / <a href="{{ route('downloads') }}">Downloads</a> / Newsletters</div>
    </div>
</div>
<section class="section">
    <div class="container">
        <div class="resource-list">
            @foreach($newsletters as $nl)
            <div class="resource-item fade-in">
                <div class="resource-item__icon"><i class="fa fa-newspaper"></i></div>
                <div class="resource-item__body">
                    <div class="resource-item__title">{{ $nl->title }}</div>
                    <div class="resource-item__meta">
                        <span><i class="fa fa-calendar"></i> {{ $nl->published_at ? $nl->published_at->format('M Y') : $nl->year }}</span>
                        <span><i class="fa fa-bookmark"></i> {{ $nl->issue }}</span>
                        @if($nl->file_size)<span><i class="fa fa-weight-hanging"></i> {{ $nl->file_size }}</span>@endif
                    </div>
                </div>
                <div class="resource-item__actions">
                    <a href="{{ $nl->file_path ? asset('storage/' . $nl->file_path) : '#' }}" class="btn btn--forest btn--sm"><i class="fa fa-download"></i> Download</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
