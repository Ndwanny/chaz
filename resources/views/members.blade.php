@extends('layouts.app')
@section('title', 'Member Institutions — CHAZ')
@section('content')
<div class="page-hero">
    <div class="container">
        <div class="page-hero__eyebrow"><span>+</span> Members</div>
        <h1 class="page-hero__title">Member Institutions</h1>
        <p class="page-hero__sub">162 church health institutions across 16 denominations and all 10 provinces — forming the backbone of Zambia's faith-based health system.</p>
        <div class="page-hero__breadcrumb"><a href="{{ route('home') }}">Home</a> / Members</div>
    </div>
</div>
<section class="section">
    <div class="container">
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1.25rem;margin-bottom:3rem;">
            @foreach([['num'=>'162','label'=>'Total Members'],['num'=>'34','label'=>'Hospitals'],['num'=>'77','label'=>'Health Centres'],['num'=>'31','label'=>'CBOs']] as $s)
            <div style="background:var(--color-cream);border-radius:var(--radius-md);padding:1.5rem;text-align:center;border:1px solid var(--color-border);">
                <div style="font-family:var(--font-display);font-size:2.5rem;font-weight:700;color:var(--color-forest);line-height:1;">{{ $s['num'] }}</div>
                <div style="font-size:0.82rem;color:var(--color-slate-mid);margin-top:0.4rem;">{{ $s['label'] }}</div>
            </div>
            @endforeach
        </div>
        <div class="members-filter">
            <button class="filter-btn active" data-filter="all">All Types</button>
            <button class="filter-btn" data-filter="hospital">Hospitals</button>
            <button class="filter-btn" data-filter="centre">Health Centres</button>
            <button class="filter-btn" data-filter="cbo">CBOs</button>
        </div>
        <div class="members-grid" id="membersGrid">
            @foreach($members as $m)
            <div class="member-card" data-type="{{ $m->type }}">
                <span class="member-card__type member-card__type--{{ $m->type }}">
                    {{ $m->type === 'hospital' ? 'Hospital' : ($m->type === 'centre' ? 'Health Centre' : 'CBO') }}
                </span>
                <div class="member-card__name">{{ $m->name }}</div>
                <div class="member-card__province"><i class="fa fa-location-dot" style="color:var(--color-gold);"></i> {{ $m->province }} Province</div>
                <div class="member-card__denom">{{ $m->denomination }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@push('scripts')
<script>
document.querySelectorAll('.filter-btn[data-filter]').forEach(btn => {
    btn.addEventListener('click', function() {
        const filter = this.dataset.filter;
        document.querySelectorAll('.members-filter .filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        document.querySelectorAll('#membersGrid .member-card').forEach(card => {
            card.style.display = (filter === 'all' || card.dataset.type === filter) ? '' : 'none';
        });
    });
});
</script>
@endpush
@endsection
