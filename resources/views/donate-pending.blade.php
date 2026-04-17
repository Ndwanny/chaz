@extends('layouts.app')
@section('title', 'Awaiting Payment — CHAZ Donation')

@section('content')
<div style="background:var(--color-cream);min-height:70vh;display:flex;align-items:center;padding:4rem 0;">
    <div class="container" style="max-width:560px;text-align:center;">

        {{-- Animated icon --}}
        <div id="statusIcon" style="width:80px;height:80px;background:var(--color-forest);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
            <i class="fa fa-mobile-screen-button" style="color:var(--color-gold);font-size:2rem;"></i>
        </div>

        <h1 id="statusTitle" style="font-family:var(--font-display);font-size:2rem;color:var(--color-forest);margin-bottom:0.75rem;">
            Awaiting Your Authorisation
        </h1>

        <p id="statusMessage" style="font-size:1rem;color:var(--color-slate-mid);line-height:1.7;margin-bottom:1.5rem;">
            @php
                $networkLabels = ['mtn' => 'MTN Mobile Money', 'airtel' => 'Airtel Money', 'zamtel' => 'Zamtel Kwacha'];
                $networkLabel  = $networkLabels[$operator] ?? 'your mobile money';
            @endphp
            A payment request of <strong style="color:var(--color-forest);">ZMW {{ $amount }}</strong> has been sent to
            <strong style="color:var(--color-forest);">{{ $networkLabel }}</strong> on
            <strong style="color:var(--color-forest);">+{{ $phone }}</strong>.
            <br><br>
            Please check your phone and <strong>approve the USSD prompt</strong> to complete your donation.
        </p>

        {{-- Pulse loader --}}
        <div id="pulseLoader" style="display:flex;align-items:center;justify-content:center;gap:0.5rem;margin-bottom:1.5rem;">
            <div class="pulse-dot"></div>
            <div class="pulse-dot" style="animation-delay:.2s"></div>
            <div class="pulse-dot" style="animation-delay:.4s"></div>
            <span style="font-size:0.85rem;color:var(--color-slate-mid);margin-left:.5rem;" id="pollMsg">Checking payment status…</span>
        </div>

        {{-- Details card --}}
        <div style="background:#fff;border-radius:var(--radius-md);box-shadow:var(--shadow-sm);padding:1.25rem 1.5rem;margin-bottom:1.5rem;text-align:left;">
            <div style="display:flex;justify-content:space-between;padding:.4rem 0;border-bottom:1px solid var(--color-border);font-size:.85rem;">
                <span style="color:var(--color-slate-mid);">Reference</span>
                <strong style="font-family:monospace;font-size:.82rem;">{{ $reference }}</strong>
            </div>
            <div style="display:flex;justify-content:space-between;padding:.4rem 0;border-bottom:1px solid var(--color-border);font-size:.85rem;">
                <span style="color:var(--color-slate-mid);">Amount</span>
                <strong>ZMW {{ $amount }}</strong>
            </div>
            <div style="display:flex;justify-content:space-between;padding:.4rem 0;font-size:.85rem;">
                <span style="color:var(--color-slate-mid);">Fund</span>
                <strong>{{ $fund }}</strong>
            </div>
        </div>

        <p style="font-size:0.8rem;color:var(--color-slate-mid);">
            This page checks automatically every 5 seconds. Do not close this tab.
        </p>

        <a href="{{ route('donate') }}" style="display:inline-block;margin-top:1.25rem;font-size:.85rem;color:var(--color-slate-mid);text-decoration:underline;">
            Cancel &amp; start over
        </a>

    </div>
</div>

@push('styles')
<style>
.pulse-dot {
    width: 10px; height: 10px;
    background: var(--color-forest);
    border-radius: 50%;
    animation: pulseDot 1.2s infinite ease-in-out;
}
@keyframes pulseDot {
    0%, 80%, 100% { transform: scale(0.6); opacity: .4; }
    40% { transform: scale(1); opacity: 1; }
}
</style>
@endpush

@push('scripts')
<script>
const POLL_URL      = '{{ route('donate.poll', $reference) }}';
const SUCCESS_URL   = '{{ route('donate.success') }}';
const CANCEL_URL    = '{{ route('donate.cancel') }}';
let   attempts      = 0;
const MAX_ATTEMPTS  = 72; // 6 minutes at 5s intervals

function poll() {
    if (attempts >= MAX_ATTEMPTS) {
        document.getElementById('pulseLoader').style.display = 'none';
        document.getElementById('statusTitle').textContent   = 'Payment Timeout';
        document.getElementById('statusMessage').textContent = 'We could not confirm your payment within the expected time. If you approved the prompt, your donation may still be processing — please check your mobile money balance and contact us if needed.';
        document.getElementById('statusIcon').style.background = '#e2e8f0';
        return;
    }

    attempts++;
    document.getElementById('pollMsg').textContent = 'Checking payment status… (attempt ' + attempts + ')';

    fetch(POLL_URL, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'successful') {
                window.location.href = SUCCESS_URL;
            } else if (data.status === 'failed') {
                document.getElementById('pulseLoader').style.display = 'none';
                document.getElementById('statusTitle').textContent   = 'Payment Failed';
                document.getElementById('statusMessage').textContent = data.reasonForFailure || 'Your payment was not completed. Please try again.';
                document.getElementById('statusIcon').style.background = '#fee2e2';
                document.getElementById('statusIcon').querySelector('i').style.color = '#dc2626';
            } else {
                setTimeout(poll, 5000);
            }
        })
        .catch(() => setTimeout(poll, 5000));
}

// Start polling after 3 seconds (give the network time to process)
setTimeout(poll, 3000);
</script>
@endpush

@endsection
