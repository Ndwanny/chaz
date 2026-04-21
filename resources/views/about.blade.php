@extends('layouts.app')
@section('title', 'About CHAZ — Churches Health Association of Zambia')
@section('meta_description', 'Learn about CHAZ — founded in 1970, the largest non-government health provider in Zambia serving 162 member institutions across all 10 provinces.')

@section('content')

<div class="page-hero">
    <div class="container">
        <div class="page-hero__eyebrow"><span>✛</span> About Us</div>
        <h1 class="page-hero__title">About CHAZ</h1>
        <p class="page-hero__sub">Since 1970, the Churches Health Association of Zambia has been the backbone of faith-based healthcare, reaching communities others cannot.</p>
        <div class="page-hero__breadcrumb">
            <a href="{{ route('home') }}">Home</a> <i class="fa fa-chevron-right" style="font-size:0.65rem"></i> About CHAZ
        </div>
    </div>
</div>

{{-- INTRO --}}
<section class="section">
    <div class="container">
        <div class="about-intro">
            <div class="about-intro__image fade-in">
                <div class="about-intro__image-placeholder">
                    <i class="fa fa-hospital-user"></i>
                </div>
                <div class="about-intro__badge">
                    <div class="about-intro__badge-num">1970</div>
                    <div class="about-intro__badge-label">Founded</div>
                </div>
            </div>
            <div class="fade-in">
                <span class="section-label">Who We Are</span>
                <h2 class="section-title">Zambia's Largest Non-Government Health Provider</h2>
                <p style="color:var(--color-slate-mid); line-height:1.85; margin-bottom:1.25rem;">
                    The Churches Health Association of Zambia (CHAZ) was founded in 1970 by Catholic and Protestant Church health institutions. Today, it stands as the <strong>largest non-government health provider in Zambia</strong>, with 162 member health institutions representing 16 Catholic and Protestant denominations — the majority based in rural areas.
                </p>
                <p style="color:var(--color-slate-mid); line-height:1.85; margin-bottom:2rem;">
                    CHAZ member institutions account for over <strong>50% of formal healthcare in rural areas</strong> and approximately <strong>35% of healthcare nationally</strong>. The Secretariat coordinates programme support, pharmaceutical supply chain, advocacy, and capacity building across all 10 provinces.
                </p>
                <div class="values-grid">
                    <div class="value-item">
                        <div class="value-item__icon"><i class="fa fa-cross"></i></div>
                        <div class="value-item__text">
                            <h4>Christian Values</h4>
                            <p>All services guided by faith and compassion for the whole person.</p>
                        </div>
                    </div>
                    <div class="value-item">
                        <div class="value-item__icon"><i class="fa fa-people-group"></i></div>
                        <div class="value-item__text">
                            <h4>Serving the Underserved</h4>
                            <p>Priority given to poor, rural, and marginalised populations.</p>
                        </div>
                    </div>
                    <div class="value-item">
                        <div class="value-item__icon"><i class="fa fa-handshake"></i></div>
                        <div class="value-item__text">
                            <h4>Government Partnership</h4>
                            <p>Signed MoU with Ministry of Health for co-financing and collaboration.</p>
                        </div>
                    </div>
                    <div class="value-item">
                        <div class="value-item__icon"><i class="fa fa-chart-line"></i></div>
                        <div class="value-item__text">
                            <h4>Evidence-Based Practice</h4>
                            <p>Data-driven programming with rigorous M&E systems across 4 provinces.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- MISSION & VISION --}}
<section class="section section--cream" id="mission">
    <div class="container">
        <div class="section-header section-header--center">
            <span class="section-label">Our Purpose</span>
            <h2 class="section-title">Mission & Vision</h2>
        </div>
        <div class="about-mv-grid">
            <div class="about-mv-card about-mv-card--forest fade-in">
                <div class="about-mv-card__icon about-mv-card__icon--forest">
                    <i class="fa fa-eye" style="color:var(--color-gold);font-size:1.3rem;"></i>
                </div>
                <h3 class="about-mv-card__title">Our Vision</h3>
                <p class="about-mv-card__text">"A Zambian society where all people are healthy and live productive lives, to the glory of God."</p>
            </div>
            <div class="about-mv-card about-mv-card--gold fade-in">
                <div class="about-mv-card__icon about-mv-card__icon--gold">
                    <i class="fa fa-bullseye" style="color:var(--color-forest);font-size:1.3rem;"></i>
                </div>
                <h3 class="about-mv-card__title">Our Mission</h3>
                <p class="about-mv-card__text">"Committed to serving all people, especially the poor and underserved, with holistic, quality and accessible health services that reflect Christian values."</p>
            </div>
        </div>
    </div>
</section>

{{-- MEMBERSHIP --}}
<section class="section">
    <div class="container">
        <div class="section-header section-header--center">
            <span class="section-label">Our Network</span>
            <h2 class="section-title">Membership at a Glance</h2>
        </div>
        <div class="about-stats-grid">
            <div class="about-stat-card fade-in">
                <div class="about-stat-card__num">34</div>
                <div class="about-stat-card__label">Hospitals</div>
                <div class="about-stat-card__sub">Including 16 nurse &amp; lab technologist training schools</div>
            </div>
            <div class="about-stat-card fade-in">
                <div class="about-stat-card__num">77</div>
                <div class="about-stat-card__label">Health Centres</div>
                <div class="about-stat-card__sub">Primary care facilities across all 10 provinces</div>
            </div>
            <div class="about-stat-card fade-in">
                <div class="about-stat-card__num">31</div>
                <div class="about-stat-card__label">CBOs</div>
                <div class="about-stat-card__sub">Community-Based Organisations in underserved areas</div>
            </div>
        </div>
    </div>
</section>

{{-- PROGRAMMES --}}
<section class="section section--cream">
    <div class="container">
        <div class="section-header">
            <span class="section-label">What We Do</span>
            <h2 class="section-title">Our Health Programmes</h2>
        </div>
        <div class="about-prog-grid">
            @foreach($programmes as $p)
            <div class="about-prog-card fade-in">
                <div class="about-prog-card__icon">
                    <i class="fa {{ $p['icon'] }}" style="color:var(--color-gold);font-size:1.2rem;"></i>
                </div>
                <h4 class="about-prog-card__title">{{ $p['title'] }}</h4>
                <p class="about-prog-card__text">{{ $p['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- GOVT PARTNERSHIP --}}
<section class="section">
    <div class="container" style="max-width:800px;">
        <div class="section-header section-header--center">
            <span class="section-label">Government Partnership</span>
            <h2 class="section-title">Working Together with the Ministry of Health</h2>
        </div>
        <div style="background:var(--color-cream); border-radius:var(--radius-lg); padding:3rem; border-left:5px solid var(--color-forest);" class="fade-in">
            <p style="color:var(--color-slate-mid); line-height:1.85; margin-bottom:1.25rem;">
                CHAZ operates under a signed <strong>Memorandum of Understanding (MoU)</strong> with the Government of the Republic of Zambia through the Ministry of Health. This framework commits the Government to:
            </p>
            <ul style="list-style:none; display:flex; flex-direction:column; gap:0.75rem;">
                @foreach(['Providing grants covering 75% of operational costs for Church Health Institutions', 'Payment of salaries for health workers at member institutions', 'Provision of essential medicines through the Medical Stores Limited', 'Inclusion of CHAZ members in national health planning processes'] as $item)
                <li style="display:flex; gap:0.75rem; align-items:flex-start;">
                    <span style="color:var(--color-gold); margin-top:0.2rem;"><i class="fa fa-check-circle"></i></span>
                    <span style="color:var(--color-slate-mid); font-size:0.9rem;">{{ $item }}</span>
                </li>
                @endforeach
            </ul>
        </div>
        <div style="text-align:center; margin-top:2.5rem;">
            <a href="{{ route('about.board') }}" class="btn btn--forest">View Board of Trustees <i class="fa fa-arrow-right"></i></a>
        </div>
    </div>
</section>

@push('styles')
<style>
/* ── Mission & Vision grid ──────────────────────────────────────────────── */
.about-mv-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    max-width: 900px;
    margin: 0 auto;
}
.about-mv-card {
    background: white;
    border-radius: var(--radius-md);
    padding: 2.5rem;
    box-shadow: var(--shadow-sm);
}
.about-mv-card--forest { border-top: 4px solid var(--color-forest); }
.about-mv-card--gold   { border-top: 4px solid var(--color-gold); }
.about-mv-card__icon {
    width: 52px; height: 52px;
    border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 1.5rem;
}
.about-mv-card__icon--forest { background: var(--color-forest); }
.about-mv-card__icon--gold   { background: var(--color-gold); }
.about-mv-card__title {
    font-family: var(--font-display);
    font-size: 1.3rem;
    color: var(--color-forest);
    margin-bottom: 1rem;
}
.about-mv-card__text {
    color: var(--color-slate-mid);
    line-height: 1.85;
    font-style: italic;
    font-size: 1.05rem;
}

/* ── Membership stats grid ──────────────────────────────────────────────── */
.about-stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
    max-width: 900px;
    margin: 0 auto 3rem;
}
.about-stat-card {
    text-align: center;
    padding: 2rem;
    background: var(--color-cream);
    border-radius: var(--radius-md);
}
.about-stat-card__num {
    font-family: var(--font-display);
    font-size: 3rem;
    font-weight: 700;
    color: var(--color-forest);
}
.about-stat-card__label {
    font-weight: 600;
    color: var(--color-slate);
    margin-bottom: 0.4rem;
}
.about-stat-card__sub {
    font-size: 0.82rem;
    color: var(--color-slate-mid);
}

/* ── Programmes grid ────────────────────────────────────────────────────── */
.about-prog-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
}
.about-prog-card {
    background: white;
    border-radius: var(--radius-md);
    padding: 2rem;
    border: 1px solid var(--color-border);
    transition: all var(--transition);
}
.about-prog-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
}
.about-prog-card__icon {
    width: 48px; height: 48px;
    background: var(--color-forest);
    border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 1.25rem;
}
.about-prog-card__title {
    font-family: var(--font-display);
    font-size: 1rem;
    font-weight: 700;
    color: var(--color-forest);
    margin-bottom: 0.6rem;
}
.about-prog-card__text {
    font-size: 0.875rem;
    color: var(--color-slate-mid);
    line-height: 1.75;
}

/* ── Responsive breakpoints ─────────────────────────────────────────────── */
@media (max-width: 700px) {
    .about-mv-grid {
        grid-template-columns: 1fr;
    }
    .about-mv-card {
        padding: 1.75rem;
    }
    .about-mv-card__text {
        font-size: 0.95rem;
    }
}

@media (max-width: 640px) {
    .about-stats-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    .about-stat-card {
        padding: 1.5rem;
    }
    .about-stat-card__num {
        font-size: 2.25rem;
    }
}

@media (max-width: 900px) {
    .about-prog-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
@media (max-width: 560px) {
    .about-prog-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@endsection
