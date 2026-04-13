@extends('layouts.app')
@section('title', 'Thank You — CHAZ Donation')

@section('content')
<div style="background:var(--color-cream);min-height:70vh;display:flex;align-items:center;padding:4rem 0;">
    <div class="container" style="max-width:600px;text-align:center;">

        <div style="width:80px;height:80px;background:var(--color-forest);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;animation:pop .4s ease-out;">
            <i class="fa fa-heart" style="color:var(--color-gold);font-size:2rem;"></i>
        </div>

        <h1 style="font-family:var(--font-display);font-size:2.2rem;color:var(--color-forest);margin-bottom:0.75rem;">
            Thank You for Your Gift!
        </h1>

        @if($amount && $fund)
        <div style="background:#fff;border-radius:var(--radius-md);box-shadow:var(--shadow-sm);padding:1.5rem;margin:1.5rem 0;text-align:left;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div>
                    <div style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--color-slate-mid);margin-bottom:.3rem;">Amount</div>
                    <div style="font-size:1.4rem;font-weight:700;color:var(--color-forest);font-family:var(--font-display);">ZMW {{ number_format((float)$amount, 2) }}</div>
                </div>
                <div>
                    <div style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--color-slate-mid);margin-bottom:.3rem;">Designated Fund</div>
                    <div style="font-size:1rem;font-weight:600;color:var(--color-slate);">{{ $fund }}</div>
                </div>
            </div>
            @if($reference)
            <div style="margin-top:1rem;padding-top:1rem;border-top:1px solid var(--color-border);font-size:0.82rem;color:var(--color-slate-mid);">
                Reference: <strong style="color:var(--color-slate);">{{ $reference }}</strong>
            </div>
            @endif
        </div>
        @endif

        <p style="font-size:1rem;color:var(--color-slate-mid);line-height:1.7;margin-bottom:1.5rem;">
            Your generosity makes an immediate difference. A receipt and acknowledgement will be sent to your email address. Thank you for partnering with CHAZ to bring quality health care to communities across Zambia.
        </p>

        <blockquote style="font-family:var(--font-display);font-size:1.1rem;font-style:italic;color:var(--color-forest);margin:1.5rem 0;padding:1rem 1.5rem;border-left:4px solid var(--color-gold);text-align:left;background:#fff;border-radius:0 var(--radius-sm) var(--radius-sm) 0;">
            "May the God of hope fill you with all joy and peace." — Romans 15:13
        </blockquote>

        <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('home') }}" class="btn btn--forest" style="padding:.75rem 1.75rem;border-radius:var(--radius-md);background:var(--color-forest);color:#fff;font-weight:600;">
                <i class="fa fa-house"></i> Return Home
            </a>
            <a href="{{ route('donate') }}" class="btn" style="padding:.75rem 1.75rem;border-radius:var(--radius-md);background:var(--color-gold);color:var(--color-forest);font-weight:700;">
                <i class="fa fa-heart"></i> Donate Again
            </a>
        </div>

    </div>
</div>

@push('styles')
<style>
@keyframes pop {
    0%   { transform: scale(0.6); opacity: 0; }
    80%  { transform: scale(1.1); }
    100% { transform: scale(1);   opacity: 1; }
}
</style>
@endpush
@endsection
