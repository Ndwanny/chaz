@extends('layouts.app')
@section('title', 'Donation Cancelled — CHAZ')

@section('content')
<div style="background:var(--color-cream);min-height:70vh;display:flex;align-items:center;padding:4rem 0;">
    <div class="container" style="max-width:560px;text-align:center;">

        <div style="width:80px;height:80px;background:#f1f5f9;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
            <i class="fa fa-times" style="color:var(--color-slate-mid);font-size:2rem;"></i>
        </div>

        <h1 style="font-family:var(--font-display);font-size:2rem;color:var(--color-slate);margin-bottom:0.75rem;">
            Donation Cancelled
        </h1>

        <p style="font-size:1rem;color:var(--color-slate-mid);line-height:1.7;margin-bottom:2rem;">
            No payment has been taken. If you changed your mind or experienced a problem, please don't hesitate to try again — every contribution, large or small, makes a real difference to the communities we serve.
        </p>

        <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('donate') }}" class="btn" style="padding:.75rem 1.75rem;border-radius:var(--radius-md);background:var(--color-gold);color:var(--color-forest);font-weight:700;">
                <i class="fa fa-heart"></i> Try Again
            </a>
            <a href="{{ route('contact') }}" class="btn" style="padding:.75rem 1.75rem;border-radius:var(--radius-md);background:var(--color-forest);color:#fff;font-weight:600;">
                <i class="fa fa-envelope"></i> Contact Us
            </a>
        </div>

    </div>
</div>
@endsection
