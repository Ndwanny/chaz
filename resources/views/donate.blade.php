@extends('layouts.app')
@section('title', 'Donate — Support CHAZ')
@section('meta_description', 'Support the Churches Health Association of Zambia. Your donation funds HIV, TB, Malaria, maternal health and community health programmes across Zambia.')

@section('content')

{{-- ── Hero ──────────────────────────────────────────────────────────────────── --}}
<div class="donate-hero">
    <div class="donate-hero__bg"></div>
    <div class="container donate-hero__inner">
        <div class="donate-hero__eyebrow"><i class="fa fa-heart"></i> Make a Difference</div>
        <h1 class="donate-hero__title">Support Health for All Zambians</h1>
        <p class="donate-hero__sub">Your donation directly funds HIV, tuberculosis, malaria, and maternal health programmes serving hundreds of thousands of people in underserved communities across all 10 provinces.</p>
        <div class="donate-hero__breadcrumb"><a href="{{ route('home') }}">Home</a> / Donate</div>
    </div>
</div>

{{-- ── Impact strip ─────────────────────────────────────────────────────────── --}}
<div class="donate-impact-bar">
    <div class="container donate-impact-bar__inner">
        <div class="donate-impact-item">
            <div class="donate-impact-item__num">30+</div>
            <div class="donate-impact-item__label">Member Hospitals &amp; Clinics</div>
        </div>
        <div class="donate-impact-divider"></div>
        <div class="donate-impact-item">
            <div class="donate-impact-item__num">10</div>
            <div class="donate-impact-item__label">Provinces Covered</div>
        </div>
        <div class="donate-impact-divider"></div>
        <div class="donate-impact-item">
            <div class="donate-impact-item__num">60+</div>
            <div class="donate-impact-item__label">Years of Service</div>
        </div>
        <div class="donate-impact-divider"></div>
        <div class="donate-impact-item">
            <div class="donate-impact-item__num">1M+</div>
            <div class="donate-impact-item__label">Lives Impacted Annually</div>
        </div>
    </div>
</div>

{{-- ── Main content ─────────────────────────────────────────────────────────── --}}
<section class="section donate-section">
    <div class="container donate-layout">

        {{-- ── Left: Form ────────────────────────────────────────────────────── --}}
        <div class="donate-form-wrap">

            <div class="donate-card">
                <div class="donate-card__header">
                    <h2><i class="fa fa-hand-holding-heart"></i> Make Your Donation</h2>
                    <p>All payments are processed securely by <strong>Lenco by Broadpay</strong> — Zambia's leading payment gateway, supporting mobile money and card payments.</p>
                </div>

                @if($errors->has('payment'))
                <div class="donate-alert donate-alert--error">
                    <i class="fa fa-circle-exclamation"></i> {{ $errors->first('payment') }}
                </div>
                @endif

                <form action="{{ route('donate.initiate') }}" method="POST" id="donateForm" novalidate>
                    @csrf

                    {{-- Payment methods banner — shown at the top so donors see options immediately --}}
                    <div class="donate-payment-methods">
                        <div class="donate-payment-methods__label"><i class="fa fa-lock"></i> Secure payment — choose how you'd like to pay</div>
                        <div class="donate-payment-methods__logos">
                            <div class="pmethod pmethod--mtn">
                                <i class="fa fa-mobile-screen"></i> MTN Money
                            </div>
                            <div class="pmethod pmethod--airtel">
                                <i class="fa fa-mobile-screen"></i> Airtel Money
                            </div>
                            <div class="pmethod pmethod--zamtel">
                                <i class="fa fa-mobile-screen"></i> Zamtel
                            </div>
                            <div class="pmethod pmethod--card">
                                <i class="fa fa-credit-card"></i> Visa / MC
                            </div>
                        </div>
                    </div>

                    {{-- Amount presets --}}
                    <div class="donate-field-group">
                        <label class="donate-label">Donation Amount (ZMW) <span class="req">*</span></label>
                        <div class="donate-amount-grid">
                            @foreach ([50, 100, 250, 500, 1000, 2500] as $preset)
                            <button type="button" class="donate-amount-btn {{ old('amount') == $preset ? 'active' : '' }}" data-amount="{{ $preset }}">
                                ZMW {{ number_format($preset) }}
                            </button>
                            @endforeach
                            <button type="button" class="donate-amount-btn donate-amount-btn--custom {{ !in_array(old('amount'), [50,100,250,500,1000,2500]) && old('amount') ? 'active' : '' }}" data-custom>
                                Custom
                            </button>
                        </div>
                        <div class="donate-custom-wrap" id="customAmountWrap" style="{{ (!in_array(old('amount'), [50,100,250,500,1000,2500]) && old('amount')) ? '' : 'display:none;' }}">
                            <span class="donate-currency-prefix">ZMW</span>
                            <input type="number" name="amount" id="amountInput" class="donate-input donate-input--amount @error('amount') is-invalid @enderror"
                                placeholder="Enter amount (min. ZMW 10)"
                                value="{{ old('amount') }}"
                                min="10" step="0.01">
                        </div>
                        <input type="hidden" name="amount" id="amountHidden" value="{{ old('amount') }}">
                        @error('amount')<div class="donate-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Fund selection --}}
                    <div class="donate-field-group">
                        <label class="donate-label" for="fund">Designate Your Gift <span class="req">*</span></label>
                        <select name="fund" id="fund" class="donate-select @error('fund') is-invalid @enderror">
                            <option value="">— Select a programme —</option>
                            <option value="General Fund" {{ old('fund') == 'General Fund' ? 'selected' : '' }}>General Fund (where most needed)</option>
                            <option value="HIV & AIDS Programme" {{ old('fund') == 'HIV & AIDS Programme' ? 'selected' : '' }}>HIV &amp; AIDS Programme</option>
                            <option value="Tuberculosis Programme" {{ old('fund') == 'Tuberculosis Programme' ? 'selected' : '' }}>Tuberculosis (TB) Programme</option>
                            <option value="Malaria Programme" {{ old('fund') == 'Malaria Programme' ? 'selected' : '' }}>Malaria Programme</option>
                            <option value="Maternal & Child Health" {{ old('fund') == 'Maternal & Child Health' ? 'selected' : '' }}>Maternal &amp; Child Health</option>
                            <option value="Nutrition Programme" {{ old('fund') == 'Nutrition Programme' ? 'selected' : '' }}>Nutrition Programme</option>
                            <option value="Community Health Workers" {{ old('fund') == 'Community Health Workers' ? 'selected' : '' }}>Community Health Workers</option>
                            <option value="Infrastructure & Equipment" {{ old('fund') == 'Infrastructure & Equipment' ? 'selected' : '' }}>Infrastructure &amp; Medical Equipment</option>
                        </select>
                        @error('fund')<div class="donate-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Donor details --}}
                    <div class="donate-field-row">
                        <div class="donate-field-group">
                            <label class="donate-label" for="first_name">First Name <span class="req">*</span></label>
                            <input type="text" name="first_name" id="first_name" class="donate-input @error('first_name') is-invalid @enderror"
                                value="{{ old('first_name') }}" placeholder="Jane" required>
                            @error('first_name')<div class="donate-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="donate-field-group">
                            <label class="donate-label" for="last_name">Last Name <span class="req">*</span></label>
                            <input type="text" name="last_name" id="last_name" class="donate-input @error('last_name') is-invalid @enderror"
                                value="{{ old('last_name') }}" placeholder="Mwale" required>
                            @error('last_name')<div class="donate-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="donate-field-row">
                        <div class="donate-field-group">
                            <label class="donate-label" for="email">Email Address <span class="req">*</span></label>
                            <input type="email" name="email" id="email" class="donate-input @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="jane@example.com" required>
                            @error('email')<div class="donate-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="donate-field-group">
                            <label class="donate-label" for="phone">Mobile Number <span class="donate-optional">(optional)</span></label>
                            <input type="tel" name="phone" id="phone" class="donate-input @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}" placeholder="+260 97X XXXXXX">
                            @error('phone')<div class="donate-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="donate-field-group">
                        <label class="donate-label" for="message">Personal Message <span class="donate-optional">(optional)</span></label>
                        <textarea name="message" id="message" rows="3" class="donate-input @error('message') is-invalid @enderror"
                            placeholder="Leave a message of support or dedication...">{{ old('message') }}</textarea>
                        @error('message')<div class="donate-error">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="donate-submit-btn" id="submitBtn">
                        <i class="fa fa-heart"></i>
                        <span id="submitBtnText">Donate Now</span>
                        <i class="fa fa-arrow-right"></i>
                    </button>

                    <p class="donate-disclaimer">
                        <i class="fa fa-shield-halved"></i>
                        Your payment is encrypted and processed securely by <strong>Lenco by Broadpay</strong>.
                        CHAZ does not store your card or mobile money details.
                    </p>
                </form>
            </div>
        </div>

        {{-- ── Right: Sidebar ─────────────────────────────────────────────────── --}}
        <div class="donate-sidebar">

            {{-- Why donate --}}
            <div class="donate-side-card">
                <h3><i class="fa fa-stethoscope"></i> Why Your Gift Matters</h3>
                <ul class="donate-impact-list">
                    <li>
                        <div class="donate-impact-list__icon" style="background:#1B4332;"><i class="fa fa-pills"></i></div>
                        <div>
                            <strong>ZMW 50</strong> provides a month of ART medication for one HIV patient
                        </div>
                    </li>
                    <li>
                        <div class="donate-impact-list__icon" style="background:#C9A84C;"><i class="fa fa-mosquito-net"></i></div>
                        <div>
                            <strong>ZMW 100</strong> buys long-lasting insecticidal bed nets for a family
                        </div>
                    </li>
                    <li>
                        <div class="donate-impact-list__icon" style="background:#2D6A4F;"><i class="fa fa-baby"></i></div>
                        <div>
                            <strong>ZMW 250</strong> supports safe delivery care for a mother in a rural clinic
                        </div>
                    </li>
                    <li>
                        <div class="donate-impact-list__icon" style="background:#1B4332;"><i class="fa fa-syringe"></i></div>
                        <div>
                            <strong>ZMW 500</strong> vaccinates 20 children against measles, polio, and TB
                        </div>
                    </li>
                    <li>
                        <div class="donate-impact-list__icon" style="background:#C9A84C;"><i class="fa fa-vial"></i></div>
                        <div>
                            <strong>ZMW 1,000</strong> funds TB diagnosis &amp; treatment for one patient
                        </div>
                    </li>
                </ul>
            </div>

            {{-- Security badge --}}
            <div class="donate-side-card donate-side-card--secure">
                <div class="donate-secure-badge">
                    <i class="fa fa-lock"></i>
                    <div>
                        <strong>Secure &amp; Trusted</strong>
                        <span>Powered by Lenco by Broadpay</span>
                    </div>
                </div>
                <p>All transactions are processed through Broadpay's PCI-DSS compliant payment infrastructure. Your financial data is never shared with CHAZ.</p>
            </div>

            {{-- Bank transfer option --}}
            <div class="donate-side-card">
                <h3><i class="fa fa-building-columns"></i> Bank Transfer</h3>
                <p style="font-size:0.88rem;color:var(--color-slate-mid);margin-bottom:1rem;">Prefer to donate directly? Transfer to our account:</p>
                <div class="donate-bank-detail"><span>Bank</span><strong>Zanaco Bank Zambia</strong></div>
                <div class="donate-bank-detail"><span>Account Name</span><strong>Churches Health Association of Zambia</strong></div>
                <div class="donate-bank-detail"><span>Account No.</span><strong>1234567890</strong></div>
                <div class="donate-bank-detail"><span>Branch</span><strong>Cairo Road, Lusaka</strong></div>
                <div class="donate-bank-detail"><span>SWIFT</span><strong>ZANAZMLX</strong></div>
                <p style="font-size:0.78rem;color:var(--color-slate-mid);margin-top:0.75rem;">Please email <a href="mailto:finance@chaz.org.zm" style="color:var(--color-forest);">finance@chaz.org.zm</a> with your transfer reference so we can acknowledge your gift.</p>
            </div>

            {{-- Contact --}}
            <div class="donate-side-card" style="text-align:center;">
                <p style="font-size:0.88rem;color:var(--color-slate-mid);">Questions about donating?</p>
                <a href="mailto:info@chaz.org.zm" class="donate-contact-link"><i class="fa fa-envelope"></i> info@chaz.org.zm</a>
                <a href="tel:+260211236281" class="donate-contact-link" style="margin-top:0.4rem;"><i class="fa fa-phone"></i> +260 211 236 281</a>
            </div>

        </div>
    </div>
</section>

@push('styles')
<style>
/* ── Donate Hero ────────────────────────────────────────────────────────────── */
.donate-hero {
    position: relative;
    background: var(--color-forest);
    padding: 5rem 0 3.5rem;
    overflow: hidden;
}
.donate-hero__bg {
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 70% 50%, rgba(201,168,76,0.15) 0%, transparent 60%),
                url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 10 L35 25 L50 25 L38 35 L43 50 L30 40 L17 50 L22 35 L10 25 L25 25Z' fill='none' stroke='rgba(201,168,76,0.06)' stroke-width='1'/%3E%3C/svg%3E") repeat;
    pointer-events: none;
}
.donate-hero__inner { position: relative; }
.donate-hero__eyebrow {
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--color-gold);
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.donate-hero__title {
    font-family: var(--font-display);
    font-size: clamp(2rem, 4vw, 3rem);
    color: #fff;
    line-height: 1.2;
    margin-bottom: 1rem;
}
.donate-hero__sub {
    font-size: 1.05rem;
    color: rgba(255,255,255,0.8);
    max-width: 620px;
    line-height: 1.7;
    margin-bottom: 1.25rem;
}
.donate-hero__breadcrumb { font-size: 0.8rem; color: rgba(255,255,255,0.5); }
.donate-hero__breadcrumb a { color: rgba(255,255,255,0.6); }
.donate-hero__breadcrumb a:hover { color: var(--color-gold); }

/* ── Impact Bar ─────────────────────────────────────────────────────────────── */
.donate-impact-bar {
    background: var(--color-gold);
    padding: 1.25rem 0;
}
.donate-impact-bar__inner {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0;
    flex-wrap: wrap;
}
.donate-impact-item {
    text-align: center;
    padding: 0.5rem 2.5rem;
}
.donate-impact-item__num {
    font-family: var(--font-display);
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--color-forest);
    line-height: 1;
}
.donate-impact-item__label {
    font-size: 0.78rem;
    color: var(--color-forest);
    font-weight: 600;
    margin-top: 0.2rem;
    opacity: 0.8;
}
.donate-impact-divider {
    width: 1px;
    height: 40px;
    background: rgba(27,67,50,0.25);
}
@media (max-width:640px) { .donate-impact-divider { display: none; } }

/* ── Section Layout ─────────────────────────────────────────────────────────── */
.donate-section { padding: 3.5rem 0 5rem; background: var(--color-cream); }
.donate-layout {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 2.5rem;
    align-items: start;
}
@media (max-width: 900px) { .donate-layout { grid-template-columns: 1fr; } }

/* ── Card ───────────────────────────────────────────────────────────────────── */
.donate-card {
    background: #fff;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    overflow: hidden;
}
.donate-card__header {
    background: var(--color-forest);
    padding: 1.75rem 2rem;
    color: #fff;
}
.donate-card__header h2 {
    font-family: var(--font-display);
    font-size: 1.4rem;
    color: #fff;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.donate-card__header h2 i { color: var(--color-gold); }
.donate-card__header p { font-size: 0.88rem; opacity: 0.85; line-height: 1.6; }

form#donateForm { padding: 1.75rem 2rem; }

/* ── Form elements ──────────────────────────────────────────────────────────── */
.donate-field-group { margin-bottom: 1.25rem; }
.donate-field-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1.25rem;
}
@media (max-width:500px) { .donate-field-row { grid-template-columns: 1fr; } }

.donate-label {
    display: block;
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--color-slate);
    margin-bottom: 0.4rem;
}
.donate-label .req { color: #C0392B; }
.donate-optional { font-weight: 400; color: var(--color-slate-mid); font-size: 0.78rem; }

.donate-input {
    width: 100%;
    padding: 0.65rem 0.9rem;
    border: 1.5px solid var(--color-border);
    border-radius: var(--radius-sm);
    font-family: var(--font-body);
    font-size: 0.92rem;
    color: var(--color-slate);
    background: #fff;
    transition: border-color 0.2s;
}
.donate-input:focus { outline: none; border-color: var(--color-forest); }
.donate-input.is-invalid { border-color: #C0392B; }
.donate-error { font-size: 0.78rem; color: #C0392B; margin-top: 0.3rem; }

.donate-select {
    width: 100%;
    padding: 0.65rem 0.9rem;
    border: 1.5px solid var(--color-border);
    border-radius: var(--radius-sm);
    font-family: var(--font-body);
    font-size: 0.92rem;
    color: var(--color-slate);
    background: #fff;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23546E7A' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.9rem center;
    padding-right: 2.5rem;
}
.donate-select:focus { outline: none; border-color: var(--color-forest); }

textarea.donate-input { resize: vertical; min-height: 80px; }

/* ── Amount presets ─────────────────────────────────────────────────────────── */
.donate-amount-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0.6rem;
    margin-bottom: 0.75rem;
}
@media (max-width:480px) { .donate-amount-grid { grid-template-columns: repeat(3, 1fr); } }

.donate-amount-btn {
    padding: 0.65rem 0.5rem;
    border: 2px solid var(--color-border);
    border-radius: var(--radius-sm);
    background: #fff;
    font-family: var(--font-body);
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--color-slate);
    cursor: pointer;
    transition: all 0.2s;
    text-align: center;
}
.donate-amount-btn:hover,
.donate-amount-btn.active {
    background: var(--color-forest);
    border-color: var(--color-forest);
    color: #fff;
}
.donate-amount-btn--custom { font-weight: 500; color: var(--color-slate-mid); }
.donate-amount-btn--custom.active { background: var(--color-gold); border-color: var(--color-gold); color: var(--color-forest); }

.donate-custom-wrap {
    display: flex;
    align-items: center;
    border: 1.5px solid var(--color-forest);
    border-radius: var(--radius-sm);
    overflow: hidden;
}
.donate-currency-prefix {
    padding: 0.65rem 0.75rem;
    background: var(--color-forest);
    color: #fff;
    font-weight: 600;
    font-size: 0.88rem;
    white-space: nowrap;
}
.donate-input--amount {
    border: none;
    border-radius: 0;
    flex: 1;
    font-size: 1.05rem;
    font-weight: 600;
}
.donate-input--amount:focus { outline: none; border: none; }

/* ── Payment methods ────────────────────────────────────────────────────────── */
.donate-payment-methods {
    background: #f8fdf9;
    border: 1px solid #d4edda;
    border-radius: var(--radius-sm);
    padding: 0.9rem 1rem;
    margin-bottom: 1.5rem;
}
.donate-payment-methods__label {
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--color-forest);
    margin-bottom: 0.7rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.donate-payment-methods__logos {
    display: flex;
    gap: 0.6rem;
    flex-wrap: wrap;
}
.pmethod {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 0.3rem 0.65rem;
    border-radius: 4px;
    letter-spacing: 0.01em;
}
.pmethod--mtn    { background: #FFCC00; color: #1a1a1a; }
.pmethod--airtel { background: #E10000; color: #fff; }
.pmethod--zamtel { background: #1B4332; color: #fff; }
.pmethod--card   { background: #1A1F71; color: #fff; }

/* ── Submit ─────────────────────────────────────────────────────────────────── */
.donate-submit-btn {
    width: 100%;
    padding: 1rem 1.5rem;
    background: var(--color-gold);
    border: none;
    border-radius: var(--radius-md);
    font-family: var(--font-body);
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--color-forest);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    transition: background 0.2s, transform 0.1s;
    letter-spacing: 0.01em;
}
.donate-submit-btn:hover { background: #b8973e; transform: translateY(-1px); }
.donate-submit-btn:active { transform: translateY(0); }
.donate-submit-btn:disabled { opacity: 0.7; cursor: not-allowed; }

.donate-disclaimer {
    font-size: 0.76rem;
    color: var(--color-slate-mid);
    text-align: center;
    margin-top: 0.9rem;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    gap: 0.4rem;
    line-height: 1.5;
}
.donate-disclaimer i { color: var(--color-forest); margin-top: 2px; flex-shrink: 0; }

/* ── Alert ──────────────────────────────────────────────────────────────────── */
.donate-alert {
    padding: 0.85rem 1rem;
    border-radius: var(--radius-sm);
    font-size: 0.88rem;
    margin: 1rem 2rem;
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
}
.donate-alert--error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }

/* ── Sidebar cards ──────────────────────────────────────────────────────────── */
.donate-side-card {
    background: #fff;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-sm);
    padding: 1.5rem;
    margin-bottom: 1.25rem;
}
.donate-side-card h3 {
    font-family: var(--font-display);
    font-size: 1.05rem;
    color: var(--color-forest);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Impact list */
.donate-impact-list { list-style: none; display: flex; flex-direction: column; gap: 0.9rem; }
.donate-impact-list li {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    font-size: 0.88rem;
    line-height: 1.5;
    color: var(--color-slate);
}
.donate-impact-list__icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 0.75rem;
    flex-shrink: 0;
}

/* Secure card */
.donate-side-card--secure { border-left: 4px solid var(--color-forest); }
.donate-secure-badge {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
}
.donate-secure-badge i {
    font-size: 1.5rem;
    color: var(--color-forest);
}
.donate-secure-badge strong { display: block; font-size: 0.92rem; color: var(--color-slate); }
.donate-secure-badge span  { font-size: 0.78rem; color: var(--color-slate-mid); }
.donate-side-card--secure p { font-size: 0.82rem; color: var(--color-slate-mid); line-height: 1.6; }

/* Bank details */
.donate-bank-detail {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    gap: 0.5rem;
    padding: 0.45rem 0;
    border-bottom: 1px solid var(--color-border);
    font-size: 0.82rem;
}
.donate-bank-detail:last-of-type { border-bottom: none; }
.donate-bank-detail span { color: var(--color-slate-mid); flex-shrink: 0; }
.donate-bank-detail strong { color: var(--color-slate); text-align: right; }

/* Contact links */
.donate-contact-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    font-size: 0.88rem;
    font-weight: 600;
    color: var(--color-forest);
    padding: 0.5rem;
    border-radius: var(--radius-sm);
    transition: background 0.2s;
}
.donate-contact-link:hover { background: var(--color-cream); }
</style>
@endpush

@push('scripts')
<script>
(function () {
    const amountHidden   = document.getElementById('amountHidden');
    const customWrap     = document.getElementById('customAmountWrap');
    const customInput    = document.getElementById('amountInput');
    const submitBtn      = document.getElementById('submitBtn');
    const submitBtnText  = document.getElementById('submitBtnText');
    const presetBtns     = document.querySelectorAll('.donate-amount-btn:not([data-custom])');
    const customBtn      = document.querySelector('.donate-amount-btn[data-custom]');

    // Preset amount selection
    presetBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            presetBtns.forEach(b => b.classList.remove('active'));
            customBtn.classList.remove('active');
            this.classList.add('active');
            amountHidden.value = this.dataset.amount;
            customWrap.style.display = 'none';
            customInput.removeAttribute('name');
            amountHidden.setAttribute('name', 'amount');
        });
    });

    // Custom amount
    customBtn.addEventListener('click', function () {
        presetBtns.forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        customWrap.style.display = 'flex';
        customInput.setAttribute('name', 'amount');
        amountHidden.removeAttribute('name');
        customInput.focus();
    });

    // Update button text with amount
    function updateButtonText() {
        const amount = amountHidden.name === 'amount'
            ? parseFloat(amountHidden.value)
            : parseFloat(customInput.value);
        if (amount >= 10) {
            submitBtnText.textContent = 'Donate ZMW ' + amount.toLocaleString('en-ZM', {minimumFractionDigits: 0, maximumFractionDigits: 2}) + ' Now';
        } else {
            submitBtnText.textContent = 'Donate Now';
        }
    }

    presetBtns.forEach(b => b.addEventListener('click', updateButtonText));
    customInput.addEventListener('input', updateButtonText);

    // Disable submit on form send to prevent double-click
    document.getElementById('donateForm').addEventListener('submit', function () {
        submitBtn.disabled = true;
        submitBtnText.textContent = 'Redirecting to payment…';
    });

    // Initialise button text if old value present
    updateButtonText();
})();
</script>
@endpush

@endsection
