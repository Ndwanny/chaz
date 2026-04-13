@extends('layouts.app')
@section('title', 'News & Updates — CHAZ')

@section('content')

<div class="page-hero">
    <div class="container">
        <div class="page-hero__eyebrow"><span>✛</span> News</div>
        <h1 class="page-hero__title">News &amp; Updates</h1>
        <p class="page-hero__sub">Stay up to date with the latest from CHAZ — programme outcomes, advocacy wins, partnerships, and health stories from across Zambia.</p>
        <div class="page-hero__breadcrumb">
            <a href="{{ route('home') }}">Home</a> <i class="fa fa-chevron-right" style="font-size:0.65rem"></i> News
        </div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="news-grid">
            @foreach($news as $article)
            <article class="news-card fade-in">
                <div class="news-card__img">
                    <div class="news-card__img-placeholder"><i class="fa fa-newspaper"></i></div>
                    <span class="news-card__tag">{{ $article['tag'] }}</span>
                </div>
                <div class="news-card__body">
                    <div class="news-card__date"><i class="fa fa-calendar"></i> {{ $article->published_at->format('F j, Y') }}</div>
                    <h3 class="news-card__title">{{ $article->title }}</h3>
                    <p class="news-card__excerpt">{{ $article->excerpt }}</p>
                    <a href="{{ route('news.show', $article->slug) }}" class="news-card__link">
                        Read Full Story <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

@endsection
