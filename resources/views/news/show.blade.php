@extends('layouts.app')
@section('title', $news->title . ' — CHAZ')

@section('content')

<div class="page-hero">
    <div class="container">
        <div class="page-hero__eyebrow"><span>✛</span> {{ $news->tag }}</div>
        <h1 class="page-hero__title" style="max-width:800px;">{{ $news->title }}</h1>
        <div class="page-hero__breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="fa fa-chevron-right" style="font-size:0.65rem"></i>
            <a href="{{ route('news') }}">News</a>
            <i class="fa fa-chevron-right" style="font-size:0.65rem"></i>
            Article
        </div>
    </div>
</div>

<section class="section">
    <div class="container" style="max-width:860px;">
        <div style="display:flex; align-items:center; gap:1.5rem; flex-wrap:wrap; margin-bottom:2.5rem; padding-bottom:1.5rem; border-bottom:1px solid var(--color-border);">
            <span class="badge badge--green">{{ $news->tag }}</span>
            <span style="font-size:0.85rem;color:var(--color-slate-mid);display:flex;align-items:center;gap:0.4rem;"><i class="fa fa-calendar"></i> {{ $news->published_at->format('F j, Y') }}</span>
            <span style="font-size:0.85rem;color:var(--color-slate-mid);display:flex;align-items:center;gap:0.4rem;"><i class="fa fa-user-pen"></i> {{ $news->author }}</span>
        </div>

        <div style="width:100%;aspect-ratio:16/7;background:linear-gradient(135deg,var(--color-forest),var(--color-forest-mid));border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;margin-bottom:2.5rem;">
            <i class="fa fa-newspaper" style="font-size:3rem;color:rgba(255,255,255,0.15);"></i>
        </div>

        <div style="font-size:1.05rem;line-height:1.9;color:var(--color-slate);">
            {!! nl2br(e($news['content'])) !!}
        </div>

        <div style="margin-top:3rem;padding-top:2rem;border-top:1px solid var(--color-border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
            <a href="{{ route('news') }}" class="btn btn--outline"><i class="fa fa-arrow-left"></i> Back to News</a>
            <div style="display:flex;gap:0.75rem;align-items:center;">
                <span style="font-size:0.82rem;color:var(--color-slate-mid);">Share:</span>
                <a href="#" class="share-btn"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="share-btn"><i class="fab fa-x-twitter"></i></a>
                <a href="#" class="share-btn"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>.share-btn{width:34px;height:34px;border-radius:50%;border:1px solid var(--color-border);display:flex;align-items:center;justify-content:center;color:var(--color-slate-mid);font-size:0.75rem;transition:all .3s;}.share-btn:hover{background:var(--color-forest);color:white;border-color:var(--color-forest);}</style>
@endpush

@endsection
