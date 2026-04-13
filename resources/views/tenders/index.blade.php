@extends('layouts.app')
@section('title', 'Tenders — CHAZ')
@section('content')
<div class="page-hero">
    <div class="container">
        <div class="page-hero__eyebrow">Procurement</div>
        <h1 class="page-hero__title">Tenders</h1>
        <p class="page-hero__sub">CHAZ invites eligible suppliers and service providers to submit bids for goods and services in support of our health programmes.</p>
        <div class="page-hero__breadcrumb"><a href="{{ route('home') }}">Home</a> / Tenders</div>
    </div>
</div>
<section class="section">
    <div class="container">
        <div style="display:flex;gap:1rem;margin-bottom:2.5rem;flex-wrap:wrap;">
            <a href="{{ route('tenders') }}" class="btn btn--forest btn--sm">Active Tenders</a>
            <a href="{{ route('tenders.sub-recipient-adverts') }}" class="btn btn--outline btn--sm">Sub-Recipient Adverts</a>
        </div>

        <div style="background:rgba(201,168,76,0.08);border:1px solid rgba(201,168,76,0.25);border-radius:var(--radius-md);padding:1.25rem 1.5rem;margin-bottom:2.5rem;display:flex;gap:1rem;align-items:flex-start;">
            <i class="fa fa-circle-info" style="color:var(--color-gold);margin-top:0.2rem;flex-shrink:0;"></i>
            <p style="font-size:0.875rem;color:var(--color-slate-mid);line-height:1.7;">All procurement at CHAZ follows the Public Procurement Act of Zambia and donor procurement guidelines. Tender documents must be submitted in sealed envelopes to the CHAZ Secretariat, Plot 4669, Mosi-o-Tunya Road, Lusaka before the stated deadline.</p>
        </div>

        <div class="resource-list">
            @foreach($tenders as $t)
            <div class="resource-item fade-in" style="flex-direction:column;align-items:flex-start;gap:1rem;">
                <div style="display:flex;gap:1.25rem;align-items:flex-start;width:100%;">
                    <div class="resource-item__icon">
                        <i class="fa {{ $t->category === 'Construction' ? 'fa-hammer' : ($t->category === 'Pharmaceuticals' ? 'fa-pills' : ($t->category === 'Information Technology' ? 'fa-laptop' : 'fa-box')) }}"></i>
                    </div>
                    <div class="resource-item__body">
                        <div style="display:flex;gap:0.75rem;align-items:center;margin-bottom:0.4rem;flex-wrap:wrap;">
                            <span style="font-size:0.72rem;font-weight:700;color:var(--color-slate-mid);font-family:monospace;">{{ $t->reference }}</span>
                            <span class="badge {{ $t->status === 'open' ? 'badge--green' : ($t->status === 'awarded' ? 'badge--blue' : 'badge--red') }}">
                                {{ ucfirst($t->status) }}
                            </span>
                            <span class="badge badge--gold">{{ $t->category }}</span>
                        </div>
                        <div class="resource-item__title" style="margin-bottom:0.5rem;">{{ $t->title }}</div>
                        <p style="font-size:0.85rem;color:var(--color-slate-mid);line-height:1.7;margin-bottom:0.75rem;">{{ $t->description }}</p>
                        <div class="resource-item__meta">
                            <span><i class="fa fa-calendar-plus"></i> Issued: {{ $t->issued_at->format('M j, Y') }}</span>
                            <span><i class="fa fa-calendar-xmark"></i> Deadline: {{ $t->deadline->format('M j, Y') }}</span>
                        </div>
                    </div>
                    @if($t->status === 'open' && $t->document)
                    <div style="flex-shrink:0;">
                        <a href="{{ asset('storage/' . $t->document) }}" class="btn btn--forest btn--sm"><i class="fa fa-download"></i> Tender Docs</a>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
