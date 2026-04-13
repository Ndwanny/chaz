<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CHAZ — Churches Health Association of Zambia')</title>
    <meta name="description" content="@yield('meta_description', 'The Churches Health Association of Zambia (CHAZ) is the largest non-government health provider in Zambia, serving communities guided by Christian values.')">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,700;1,500&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,300&family=DM+Serif+Display&display=swap" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Main Stylesheet --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')
</head>
<body>

    {{-- Top Banner --}}
    <div class="top-bar">
        <div class="container top-bar__inner">
            <div class="top-bar__left">
                <span><i class="fa fa-phone"></i> +260 211 236 281</span>
                <span><i class="fa fa-envelope"></i> info@chaz.org.zm</span>
            </div>
            <div class="top-bar__right">
                <a href="https://www.facebook.com" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.twitter.com" target="_blank" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a>
                <a href="https://www.youtube.com" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                <a href="https://eportal.chaz.domains/" target="_blank" class="top-bar__portal">e-Portal <i class="fa fa-arrow-up-right-from-square"></i></a>
            </div>
        </div>
    </div>

    {{-- Main Navigation --}}
    <header class="navbar" id="navbar">
        <div class="container navbar__inner">
            <a href="{{ route('home') }}" class="navbar__brand">
                <div class="navbar__logo-mark">
                    <span class="logo-cross">✛</span>
                </div>
                <div class="navbar__logo-text">
                    <span class="logo-chaz">CHAZ</span>
                    <span class="logo-sub">Churches Health <br> Association of Zambia</span>
                </div>
            </a>

            <button class="navbar__toggle" id="navToggle" aria-label="Toggle navigation">
                <span></span><span></span><span></span>
            </button>

            <nav class="navbar__menu" id="navMenu">
                <ul class="navbar__list">
                    <li class="navbar__item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="navbar__item navbar__item--dropdown {{ request()->routeIs('about*') ? 'active' : '' }}">
                        <a href="{{ route('about') }}">About Us <i class="fa fa-chevron-down"></i></a>
                        <ul class="navbar__dropdown">
                            <li><a href="{{ route('about') }}">About CHAZ</a></li>
                            <li><a href="{{ route('about') }}#mission">Mission &amp; Vision</a></li>
                            <li><a href="{{ route('about.board') }}">Board of Trustees</a></li>
                        </ul>
                    </li>
                    <li class="navbar__item {{ request()->routeIs('members') ? 'active' : '' }}">
                        <a href="{{ route('members') }}">Members</a>
                    </li>
                    <li class="navbar__item {{ request()->routeIs('news*') ? 'active' : '' }}">
                        <a href="{{ route('news') }}">News</a>
                    </li>
                    <li class="navbar__item {{ request()->routeIs('gallery') ? 'active' : '' }}">
                        <a href="{{ route('gallery') }}">Gallery</a>
                    </li>
                    <li class="navbar__item navbar__item--dropdown {{ request()->routeIs('downloads*') ? 'active' : '' }}">
                        <a href="{{ route('downloads') }}">Downloads <i class="fa fa-chevron-down"></i></a>
                        <ul class="navbar__dropdown">
                            <li><a href="{{ route('downloads.publications') }}">Publications</a></li>
                            <li><a href="{{ route('downloads.annual-reports') }}">Annual Reports</a></li>
                            <li><a href="{{ route('downloads.newsletters') }}">Newsletters</a></li>
                        </ul>
                    </li>
                    <li class="navbar__item navbar__item--dropdown {{ request()->routeIs('tenders*') ? 'active' : '' }}">
                        <a href="{{ route('tenders') }}">Tenders <i class="fa fa-chevron-down"></i></a>
                        <ul class="navbar__dropdown">
                            <li><a href="{{ route('tenders') }}">Tenders</a></li>
                            <li><a href="{{ route('tenders.sub-recipient-adverts') }}">Sub-Recipient Adverts</a></li>
                        </ul>
                    </li>
                    <li class="navbar__item {{ request()->routeIs('jobs*') ? 'active' : '' }}">
                        <a href="{{ route('jobs') }}">Jobs</a>
                    </li>
                    <!-- <li class="navbar__item {{ request()->routeIs('employee-portal') ? 'active' : '' }}">
                        <a href="{{ route('employee-portal') }}">Employee Portal</a>
                    </li> -->
                    <li class="navbar__item {{ request()->routeIs('contact') ? 'active' : '' }}">
                        <a href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
                <a href="{{ route('donate') }}" class="btn btn--gold navbar__cta"><i class="fa fa-heart" style="margin-right:0.35rem;"></i>Donate</a>
            </nav>
        </div>
    </header>

    {{-- Page Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer">
        <div class="footer__wave">
            <svg viewBox="0 0 1440 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,30 C360,60 1080,0 1440,30 L1440,60 L0,60 Z" fill="var(--color-forest)"/>
            </svg>
        </div>
        <div class="footer__body">
            <div class="container footer__grid">
                <div class="footer__col footer__col--brand">
                    <div class="footer__logo">
                        <span class="logo-cross" style="color:var(--color-gold)">✛</span>
                        <div>
                            <div class="footer__logo-title">CHAZ</div>
                            <div class="footer__logo-sub">Churches Health Association of Zambia</div>
                        </div>
                    </div>
                    <p>Serving all people, especially the poor and underserved, with holistic, quality and accessible health services guided by Christian values.</p>
                    <div class="footer__socials">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <div class="footer__col">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="{{ route('about') }}">About CHAZ</a></li>
                        <li><a href="{{ route('members') }}">Our Members</a></li>
                        <li><a href="{{ route('news') }}">News &amp; Updates</a></li>
                        <li><a href="{{ route('downloads.publications') }}">Publications</a></li>
                        <li><a href="{{ route('downloads.annual-reports') }}">Annual Reports</a></li>
                        <li><a href="{{ route('tenders') }}">Tenders</a></li>
                        <li><a href="{{ route('jobs') }}">Career Opportunities</a></li>
                        <li><a href="{{ route('donate') }}" style="color:var(--color-gold);font-weight:600;"><i class="fa fa-heart" style="margin-right:0.3rem;"></i>Donate</a></li>
                    </ul>
                </div>

                <div class="footer__col">
                    <h4>Programmes</h4>
                    <ul>
                        <li><a href="#">HIV &amp; AIDS</a></li>
                        <li><a href="#">Tuberculosis (TB)</a></li>
                        <li><a href="#">Malaria</a></li>
                        <li><a href="#">Immunisation</a></li>
                        <li><a href="#">Maternal &amp; Child Health</a></li>
                        <li><a href="#">PMTCT</a></li>
                        <li><a href="#">PrEP Services</a></li>
                    </ul>
                </div>

                <div class="footer__col">
                    <h4>Contact Us</h4>
                    <ul class="footer__contact">
                        <li><i class="fa fa-location-dot"></i> Plot 4669, Mosi-o-Tunya Road, Lusaka, Zambia</li>
                        <li><i class="fa fa-phone"></i> +260 211 236 281</li>
                        <li><i class="fa fa-envelope"></i> info@chaz.org.zm</li>
                        <li><i class="fa fa-globe"></i> www.chaz.org.zm</li>
                    </ul>
                    <div style="margin-top:1.5rem">
                        <h4>Partners</h4>
                        <p style="font-size:0.82rem;opacity:0.7;line-height:1.7">Global Fund &bull; PEPFAR &bull; CDC &bull; GAVI &bull; WHO &bull; UNICEF &bull; Ministry of Health</p>
                    </div>
                </div>
            </div>

            <div class="footer__bottom">
                <div class="container footer__bottom-inner">
                    <p>&copy; {{ date('Y') }} Churches Health Association of Zambia. All rights reserved.</p>
                    <p>Guided by Christian Values &mdash; <span style="color:var(--color-gold)">Romans 15:13</span></p>
                </div>
            </div>
        </div>
    </footer>

    {{-- JS --}}
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
