@extends('layouts.app')
@section('title', 'CHAZ — Churches Health Association of Zambia')

@section('content')

{{-- ============================================================ --}}
{{-- HOME HERO --}}
{{-- ============================================================ --}}
<section class="home-hero">
    <div class="home-hero__bg"></div>
    <div class="container">
        <div class="home-hero__content">
            <div class="home-hero__badge">
                <span>✛</span> Guided by Christian Values — Since 1970
            </div>
            <h1 class="home-hero__title">
                Serving Zambia<br>with <em>Holistic</em><br>Healthcare
            </h1>
            <p class="home-hero__desc">
                The Churches Health Association of Zambia is the largest non-government health provider in the country, serving 162 member institutions across all 10 provinces — reaching those who need it most.
            </p>
            <div class="home-hero__actions">
                <a href="{{ route('about') }}" class="btn btn--gold btn--lg">Discover CHAZ</a>
                <a href="{{ route('news') }}" class="btn btn--outline-white btn--lg">Latest News</a>
            </div>

            <div class="home-hero__stats">
                <div class="stat-card fade-in">
                    <div class="stat-card__num" data-target="162" data-suffix="">162</div>
                    <div class="stat-card__label">Member Health Institutions</div>
                </div>
                <div class="stat-card fade-in">
                    <div class="stat-card__num" data-target="35" data-suffix="%">35%</div>
                    <div class="stat-card__label">of National Healthcare</div>
                </div>
                <div class="stat-card fade-in">
                    <div class="stat-card__num" data-target="10" data-suffix="">10</div>
                    <div class="stat-card__label">Provinces Covered</div>
                </div>
                <div class="stat-card fade-in">
                    <div class="stat-card__num" data-target="50" data-suffix="%">50%</div>
                    <div class="stat-card__label">Rural Healthcare Share</div>
                </div>
            </div>
        </div>

        <div class="home-hero__visual">
            <div class="hero-visual-grid">
                <div class="hero-img-card hero-img-card--tall hero-card-bg-1">
                    <div class="hero-img-placeholder">
                        <i class="fa fa-hospital"></i>
                        <span>Mission Hospital</span>
                    </div>
                </div>
                <div class="hero-img-card hero-card-bg-2">
                    <div class="hero-img-placeholder">
                        <i class="fa fa-syringe"></i>
                        <span>Immunisation</span>
                    </div>
                </div>
                <div class="hero-img-card hero-card-bg-3">
                    <div class="hero-img-placeholder">
                        <i class="fa fa-baby"></i>
                        <span>Maternal Care</span>
                    </div>
                </div>
            </div>
            <div class="hero-img-card hero-card-bg-4" style="border-radius: var(--radius-md); padding: 1.5rem; display:flex; align-items:center; gap: 1rem;">
                <div style="width:44px;height:44px;background:rgba(27,67,50,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <i class="fa fa-quote-left" style="color:var(--color-forest); font-size:1rem;"></i>
                </div>
                <div>
                    <p style="font-size:0.82rem;color:var(--color-forest);font-style:italic;line-height:1.6;font-weight:600;">"May the God of hope fill you with all joy and peace..."</p>
                    <p style="font-size:0.7rem;color:var(--color-forest);opacity:0.7;margin-top:0.25rem;">Romans 15:13</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- PARTNERS STRIP --}}
{{-- ============================================================ --}}
<div class="partners-strip">
    <div class="container">
        <p class="partners-strip__label">Trusted Partners</p>
        <div class="partners-logos">
            @foreach(['Global Fund', 'PEPFAR', 'CDC', 'GAVI', 'WHO', 'UNICEF', 'Ministry of Health', 'Clinton Foundation', 'Irish Aid', 'European Union'] as $p)
            <span class="partner-logo">{{ $p }}</span>
            @endforeach
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- 2024 ACHIEVEMENTS --}}
{{-- ============================================================ --}}
<section class="section section--forest">
    <div class="container">
        <div class="section-header section-header--center">
            <span class="section-label">2024 Notable Achievements</span>
            <h2 class="section-title">Impact That Transforms Lives</h2>
            <p class="section-sub">Year after year, CHAZ members deliver measurable health outcomes that position Zambia closer to epidemic control and sustainable health for all.</p>
        </div>
        <div class="achievements-grid">
            @foreach($achievements as $a)
            <div class="achievement-card fade-in">
                <div class="achievement-card__icon">
                    <i class="fa {{ $a['icon'] }}"></i>
                </div>
                <div class="achievement-card__num" data-target="{{ rtrim($a['num'], '%') }}" data-suffix="{{ str_contains($a['num'], '.') ? '' : '' }}{{ $a['suffix'] }}">
                    {{ $a['num'] }}{{ $a['suffix'] }}
                </div>
                <div class="achievement-card__label">{{ $a['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- STRATEGIC DIRECTIONS --}}
{{-- ============================================================ --}}
<section class="section section--cream">
    <div class="container">
        <div class="section-header">
            <span class="section-label">Our Strategic Framework</span>
            <h2 class="section-title">Three Strategic Directions</h2>
            <p class="section-sub">CHAZ's work is guided by a clear strategic framework designed to achieve lasting health impact across Zambia.</p>
        </div>
        <div class="directions-grid">
            <div class="direction-card fade-in">
                <div class="direction-card__num">01</div>
                <div class="direction-card__icon"><i class="fa fa-star-of-life"></i></div>
                <h3 class="direction-card__title">Health Service Delivery Excellence</h3>
                <p class="direction-card__desc">Significantly improving the quality, efficiency and effectiveness of health services offered at all levels across our 162 member institutions and their catchment communities.</p>
            </div>
            <div class="direction-card fade-in">
                <div class="direction-card__num">02</div>
                <div class="direction-card__icon"><i class="fa fa-building-columns"></i></div>
                <h3 class="direction-card__title">Resilient Health Systems</h3>
                <p class="direction-card__desc">Strengthening CHAZ health support systems and capacities at all levels — from the Secretariat through four provincial offices to individual health facilities — for optimal efficiency.</p>
            </div>
            <div class="direction-card fade-in">
                <div class="direction-card__num">03</div>
                <div class="direction-card__icon"><i class="fa fa-hand-holding-dollar"></i></div>
                <h3 class="direction-card__title">Health Care Financing</h3>
                <p class="direction-card__desc">Achieving long-term sustainability by scaling up resilience, income generation, and diversification of the resource base to reduce dependence on any single donor.</p>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- NEWS --}}
{{-- ============================================================ --}}
<section class="section">
    <div class="container">
        <div class="section-header" style="display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:1rem;">
            <div>
                <span class="section-label">News & Updates</span>
                <h2 class="section-title">Latest from CHAZ</h2>
            </div>
            <a href="{{ route('news') }}" class="btn btn--outline">All News <i class="fa fa-arrow-right"></i></a>
        </div>

        <div class="news-grid">
            @foreach($news as $article)
            <article class="news-card fade-in">
                <div class="news-card__img">
                    <div class="news-card__img-placeholder"><i class="fa fa-newspaper"></i></div>
                    <span class="news-card__tag">{{ $article->tag }}</span>
                </div>
                <div class="news-card__body">
                    <div class="news-card__date"><i class="fa fa-calendar"></i> {{ $article->published_at->format('F j, Y') }}</div>
                    <h3 class="news-card__title">{{ $article->title }}</h3>
                    <p class="news-card__excerpt">{{ $article->excerpt }}</p>
                    <a href="{{ route('news.show', $article->slug) }}" class="news-card__link">
                        Read More <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================ --}}
{{-- CTA BANNER --}}
{{-- ============================================================ --}}
<section class="cta-banner">
    <div class="container">
        <h2 class="cta-banner__title">Join Us in Transforming<br>Health in Zambia</h2>
        <p class="cta-banner__sub">Whether you want to partner, donate, volunteer, or join our team — there is a place for you in the CHAZ mission.</p>
        <div class="cta-banner__actions">
            <a href="{{ route('contact') }}" class="btn btn--gold btn--lg">Get Involved</a>
            <a href="{{ route('about') }}" class="btn btn--outline-white btn--lg">Learn More</a>
        </div>
    </div>
</section>

@endsection
