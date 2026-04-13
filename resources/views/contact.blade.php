@extends('layouts.app')
@section('title', 'Contact Us — CHAZ')
@section('content')
<div class="page-hero">
    <div class="container">
        <div class="page-hero__eyebrow">Get in Touch</div>
        <h1 class="page-hero__title">Contact CHAZ</h1>
        <p class="page-hero__sub">Reach our Secretariat in Lusaka or any of our four provincial offices. We'd love to hear from you.</p>
        <div class="page-hero__breadcrumb"><a href="{{ route('home') }}">Home</a> / Contact</div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="contact-grid">
            {{-- Contact info --}}
            <div class="contact-info">
                <div class="contact-card fade-in">
                    <div class="contact-card__icon"><i class="fa fa-location-dot"></i></div>
                    <div>
                        <div class="contact-card__title">Head Office</div>
                        <div class="contact-card__value">Plot 4669, Mosi-o-Tunya Road<br>Lusaka, Zambia</div>
                    </div>
                </div>
                <div class="contact-card fade-in">
                    <div class="contact-card__icon"><i class="fa fa-phone"></i></div>
                    <div>
                        <div class="contact-card__title">Phone</div>
                        <div class="contact-card__value">+260 211 236 281<br>+260 211 236 282</div>
                    </div>
                </div>
                <div class="contact-card fade-in">
                    <div class="contact-card__icon"><i class="fa fa-envelope"></i></div>
                    <div>
                        <div class="contact-card__title">Email</div>
                        <div class="contact-card__value">info@chaz.org.zm<br>communications@chaz.org.zm</div>
                    </div>
                </div>
                <div class="contact-card fade-in">
                    <div class="contact-card__icon"><i class="fa fa-building"></i></div>
                    <div>
                        <div class="contact-card__title">Provincial Offices</div>
                        <div class="contact-card__value">
                            Chipata (Eastern) &bull; Choma (Southern/Western)<br>
                            Ndola (Copperbelt/N-Western) &bull; Kasama (Northern/Luapula)
                        </div>
                    </div>
                </div>
                <div class="contact-card fade-in">
                    <div class="contact-card__icon"><i class="fa fa-clock"></i></div>
                    <div>
                        <div class="contact-card__title">Office Hours</div>
                        <div class="contact-card__value">Monday – Friday: 08:00 – 17:00<br>Saturday & Sunday: Closed</div>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <div class="fade-in">
                @if(session('success'))
                <div style="background:rgba(27,67,50,0.08);border:1px solid rgba(27,67,50,0.2);border-radius:var(--radius-md);padding:1.25rem 1.5rem;margin-bottom:1.75rem;display:flex;gap:0.75rem;align-items:flex-start;">
                    <i class="fa fa-circle-check" style="color:var(--color-forest);margin-top:0.2rem;"></i>
                    <p style="font-size:0.9rem;color:var(--color-forest);">{{ session('success') }}</p>
                </div>
                @endif

                <div style="background:white;border:1px solid var(--color-border);border-radius:var(--radius-lg);padding:2.5rem;box-shadow:var(--shadow-sm);">
                    <h3 style="font-family:var(--font-display);font-size:1.3rem;color:var(--color-forest);margin-bottom:0.5rem;">Send Us a Message</h3>
                    <p style="font-size:0.85rem;color:var(--color-slate-mid);margin-bottom:2rem;">We respond within 2 working days.</p>

                    <form action="{{ route('contact.send') }}" method="POST" id="contactForm">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="name">Full Name <span style="color:var(--color-red)">*</span></label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Your full name" required value="{{ old('name') }}">
                                @error('name')<span style="font-size:0.78rem;color:var(--color-red);">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="email">Email Address <span style="color:var(--color-red)">*</span></label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="your@email.com" required value="{{ old('email') }}">
                                @error('email')<span style="font-size:0.78rem;color:var(--color-red);">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" class="form-control" placeholder="+260 9XX XXX XXX" value="{{ old('phone') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="subject">Subject <span style="color:var(--color-red)">*</span></label>
                                <input type="text" id="subject" name="subject" class="form-control" placeholder="How can we help?" required value="{{ old('subject') }}">
                                @error('subject')<span style="font-size:0.78rem;color:var(--color-red);">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="message">Message <span style="color:var(--color-red)">*</span></label>
                            <textarea id="message" name="message" class="form-control" placeholder="Write your message here..." required>{{ old('message') }}</textarea>
                            @error('message')<span style="font-size:0.78rem;color:var(--color-red);">{{ $message }}</span>@enderror
                        </div>
                        <button type="submit" class="btn btn--forest btn--lg" style="width:100%;justify-content:center;">
                            <i class="fa fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
