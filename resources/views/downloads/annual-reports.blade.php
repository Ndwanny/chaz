@extends('layouts.app')
@section('title', 'Annual Reports — CHAZ')
@section('content')
<div class="page-hero">
    <div class="container">
        <div class="page-hero__eyebrow">Downloads</div>
        <h1 class="page-hero__title">Annual Reports</h1>
        <p class="page-hero__sub">Comprehensive yearly reviews of CHAZ programme outcomes, financial performance, and key milestones.</p>
        <div class="page-hero__breadcrumb"><a href="{{ route('home') }}">Home</a> / <a href="{{ route('downloads') }}">Downloads</a> / Annual Reports</div>
    </div>
</div>
<section class="section">
    <div class="container">
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2rem;">
            @foreach($reports as $r)
            <div class="fade-in" style="background:white;border:1px solid var(--color-border);border-radius:var(--radius-md);overflow:hidden;transition:all .3s;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='var(--shadow-md)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
                <div style="background:linear-gradient(135deg,var(--color-forest),var(--color-forest-mid));padding:2rem;text-align:center;position:relative;">
                    <div style="font-family:var(--font-display);font-size:2.5rem;font-weight:700;color:var(--color-gold);">{{ $r->year }}</div>
                    <div style="font-size:0.75rem;color:rgba(255,255,255,0.6);letter-spacing:0.1em;text-transform:uppercase;">Annual Report</div>
                </div>
                <div style="padding:1.5rem;">
                    <h3 style="font-family:var(--font-display);font-size:1rem;color:var(--color-forest);margin-bottom:0.6rem;">{{ $r->title }}</h3>
                    <p style="font-size:0.83rem;color:var(--color-slate-mid);line-height:1.7;margin-bottom:1.25rem;">{{ $r->description }}</p>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:0.78rem;color:var(--color-slate-lite);">{{ $r->pages }}pp &bull; {{ $r->file_size }}</span>
                        <a href="{{ $r->file_path ? asset('storage/' . $r->file_path) : '#' }}" class="btn btn--forest btn--sm"><i class="fa fa-download"></i> PDF</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
