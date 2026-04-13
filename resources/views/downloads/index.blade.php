@extends('layouts.app')
@section('title', 'Downloads — CHAZ')
@section('content')
<div class="page-hero">
    <div class="container">
        <div class="page-hero__eyebrow">Resources</div>
        <h1 class="page-hero__title">Downloads</h1>
        <p class="page-hero__sub">Access CHAZ publications, annual reports, newsletters and other resources.</p>
        <div class="page-hero__breadcrumb"><a href="{{ route('home') }}">Home</a> / Downloads</div>
    </div>
</div>
<section class="section">
    <div class="container">
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2rem;max-width:900px;margin:0 auto;">
            @foreach([
                ['icon'=>'fa-book-open','title'=>'Publications','desc'=>'Programme reports, policy briefs, strategic plans and training manuals.','route'=>'downloads.publications','count'=>'8 Documents'],
                ['icon'=>'fa-chart-bar','title'=>'Annual Reports','desc'=>'Comprehensive yearly reviews of CHAZ programme outcomes and finances.','route'=>'downloads.annual-reports','count'=>'5 Reports'],
                ['icon'=>'fa-newspaper','title'=>'Newsletters','desc'=>'Quarterly updates from CHAZ and member health institutions.','route'=>'downloads.newsletters','count'=>'6 Issues'],
            ] as $cat)
            <a href="{{ route($cat['route']) }}" class="fade-in" style="background:white;border:1px solid var(--color-border);border-radius:var(--radius-md);padding:2.5rem 2rem;text-align:center;display:block;transition:all .3s;" onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='var(--shadow-lg)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
                <div style="width:64px;height:64px;background:var(--color-forest);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
                    <i class="fa {{ $cat['icon'] }}" style="color:var(--color-gold);font-size:1.4rem;"></i>
                </div>
                <h3 style="font-family:var(--font-display);font-size:1.2rem;color:var(--color-forest);margin-bottom:0.6rem;">{{ $cat['title'] }}</h3>
                <p style="font-size:0.875rem;color:var(--color-slate-mid);line-height:1.7;margin-bottom:1rem;">{{ $cat['desc'] }}</p>
                <span class="badge badge--green">{{ $cat['count'] }}</span>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
