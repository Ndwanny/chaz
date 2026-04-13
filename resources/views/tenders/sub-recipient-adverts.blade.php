@extends('layouts.app')
@section('title', 'Sub-Recipient Adverts — CHAZ')
@section('content')
<div class="page-hero">
    <div class="container">
        <div class="page-hero__eyebrow">Procurement</div>
        <h1 class="page-hero__title">Sub-Recipient Adverts</h1>
        <p class="page-hero__sub">CHAZ, as a Global Fund Principal Recipient, recruits qualified Faith-Based Organisations and Civil Society Organisations to implement grant activities as Sub-Recipients.</p>
        <div class="page-hero__breadcrumb">
            <a href="{{ route('home') }}">Home</a> / <a href="{{ route('tenders') }}">Tenders</a> / Sub-Recipient Adverts
        </div>
    </div>
</div>

<section class="section">
    <div class="container">
        {{-- Explainer box --}}
        <div style="background:var(--color-cream);border-radius:var(--radius-md);padding:2rem 2.5rem;margin-bottom:3rem;border-left:5px solid var(--color-forest);" class="fade-in">
            <h3 style="font-family:var(--font-display);font-size:1.15rem;color:var(--color-forest);margin-bottom:0.75rem;">About the Sub-Recipient Model</h3>
            <p style="font-size:0.9rem;color:var(--color-slate-mid);line-height:1.85;">
                CHAZ serves as the <strong>Principal Recipient (PR)</strong> for several Global Fund grants covering HIV/AIDS, TB, and Malaria. As PR, CHAZ sub-grants a portion of programme activities to <strong>Sub-Recipients (SRs)</strong> — typically Faith-Based Organisations (FBOs) and Civil Society Organisations (CSOs) with presence and capacity in targeted communities. SRs are selected through a transparent, competitive application process.
            </p>
        </div>

        {{-- Adverts --}}
        @foreach($adverts as $advert)
        <div class="fade-in" style="background:white;border:1px solid var(--color-border);border-radius:var(--radius-md);margin-bottom:2.5rem;overflow:hidden;box-shadow:var(--shadow-sm);">
            {{-- Header --}}
            <div style="background:linear-gradient(135deg,var(--color-forest),var(--color-forest-mid));padding:1.75rem 2rem;display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem;">
                <div>
                    <div style="font-size:0.72rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:var(--color-gold);margin-bottom:0.5rem;">{{ $advert->reference }}</div>
                    <h3 style="font-family:var(--font-display);font-size:1.15rem;font-weight:700;color:white;line-height:1.4;max-width:680px;">{{ $advert->title }}</h3>
                </div>
                <span class="{{ $advert->status === 'open' ? 'badge badge--green' : 'badge badge--red' }}" style="flex-shrink:0;">{{ ucfirst($advert->status) }}</span>
            </div>

            {{-- Body --}}
            <div style="padding:2rem;">
                {{-- Meta chips --}}
                <div style="display:flex;gap:0.75rem;flex-wrap:wrap;margin-bottom:1.5rem;">
                    <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.82rem;color:var(--color-slate-mid);">
                        <i class="fa fa-globe" style="color:var(--color-forest);"></i>
                        <strong>Funder:</strong>&nbsp;{{ $advert->funder }}
                    </div>
                    <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.82rem;color:var(--color-slate-mid);">
                        <i class="fa fa-file-contract" style="color:var(--color-forest);"></i>
                        <strong>Grant:</strong>&nbsp;{{ $advert->grant }}
                    </div>
                    <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.82rem;color:var(--color-slate-mid);">
                        <i class="fa fa-users" style="color:var(--color-forest);"></i>
                        <strong>Type:</strong>&nbsp;{{ $advert->type }}
                    </div>
                    <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.82rem;color:var(--color-slate-mid);">
                        <i class="fa fa-calendar-plus" style="color:var(--color-forest);"></i>
                        <strong>Issued:</strong>&nbsp;{{ $advert->issued }}
                    </div>
                </div>

                <div style="margin-bottom:2rem;line-height:1.7;color:var(--color-slate-mid);font-size:0.9rem;">
                    {{ $advert->description }}
                </div>

                <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(300px, 1fr));gap:2rem;">
                    {{-- Eligibility --}}
                    <div>
                        <h4 style="font-family:var(--font-display);font-size:1rem;color:var(--color-forest);margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem;">
                            <i class="fa fa-list-check" style="color:var(--color-gold);"></i> Eligibility Criteria
                        </h4>
                        <ul style="display:flex;flex-direction:column;gap:0.6rem;">
                            @foreach($advert->eligibility_criteria as $criteria)
                            <li style="font-size:0.85rem;color:var(--color-slate-mid);line-height:1.6;display:flex;gap:0.6rem;align-items:flex-start;">
                                <i class="fa fa-circle" style="font-size:0.35rem;color:var(--color-forest-lite);margin-top:0.5rem;flex-shrink:0;"></i>
                                {{ $criteria }}
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Successful Applicants --}}
                    @if($advert->successful_applicants)
                    <div>
                        <h4 style="font-family:var(--font-display);font-size:1rem;color:var(--color-forest);margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem;">
                            <i class="fa fa-award" style="color:var(--color-gold);"></i> Successful Applicants
                        </h4>
                        <ul style="display:flex;flex-direction:column;gap:0.6rem;">
                            @foreach($advert->successful_applicants as $org)
                            <li style="font-size:0.85rem;color:var(--color-slate-mid);line-height:1.6;display:flex;gap:0.6rem;align-items:flex-start;">
                                <i class="fa fa-check-circle" style="font-size:0.8rem;color:var(--color-forest-lite);margin-top:0.25rem;flex-shrink:0;"></i>
                                {{ $org }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>

                @if($advert->status === 'open' && $advert->document)
                <div style="margin-top:2.5rem;padding-top:1.5rem;border-top:1px solid var(--color-border);display:flex;justify-content:flex-end;">
                    <a href="{{ asset('storage/' . $advert->document) }}" class="btn btn--forest"><i class="fa fa-download"></i> Download Full Advert Docs</a>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection
