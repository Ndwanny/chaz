<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title', 'My Portal') — CHAZ Employee Portal</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --pg:        #1B4332;
            --pg2:       #2D6A4F;
            --pgold:     #C9A84C;
            --pbg:       #F4F6F8;
            --pw:        #ffffff;
            --pborder:   #E2E8F0;
            --ptext:     #1A202C;
            --pmuted:    #718096;
            --prad:      12px;
            --pshad:     0 1px 3px rgba(0,0,0,.08), 0 4px 16px rgba(0,0,0,.06);
            --psidew:    260px;
            --pheaderh:  58px;
            --ptrans:    .25s ease;
            /* Legacy aliases used in views */
            --portal-green:  #1B4332;
            --portal-green2: #2D6A4F;
            --portal-gold:   #C9A84C;
            --portal-bg:     #F4F6F8;
            --portal-white:  #ffffff;
            --portal-border: #E2E8F0;
            --portal-text:   #1A202C;
            --portal-muted:  #718096;
            --portal-radius: 12px;
            --portal-shadow: 0 1px 3px rgba(0,0,0,.08), 0 4px 16px rgba(0,0,0,.06);
        }
        html { font-size: 15px; }
        body { background: var(--pbg); font-family: 'Inter', system-ui, sans-serif; color: var(--ptext); min-height: 100vh; }

        /* ── OVERLAY ── */
        .p-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.5); z-index: 190;
            backdrop-filter: blur(2px); -webkit-backdrop-filter: blur(2px);
        }
        .p-overlay.open { display: block; }

        /* ── SIDEBAR ── */
        .p-sidebar {
            position: fixed; top: 0; left: 0;
            width: var(--psidew); height: 100vh;
            background: var(--pg);
            display: flex; flex-direction: column;
            z-index: 200; overflow-y: auto;
            transition: transform .3s cubic-bezier(.4,0,.2,1);
            -webkit-overflow-scrolling: touch;
        }
        .p-sidebar__head {
            padding: 1.1rem 1.25rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,.1);
            display: flex; align-items: center; justify-content: space-between;
            min-height: var(--pheaderh);
            flex-shrink: 0;
        }
        .p-sidebar__brand-wrap { line-height: 1.25; }
        .p-sidebar__logo { color: var(--pgold); font-weight: 800; font-size: 1.05rem; letter-spacing: .02em; }
        .p-sidebar__sub  { color: rgba(255,255,255,.45); font-size: .68rem; margin-top: 2px; }
        .p-sidebar__headclose {
            display: none; background: rgba(255,255,255,.12); border: none;
            color: #fff; width: 30px; height: 30px; border-radius: 6px;
            font-size: .9rem; cursor: pointer;
            align-items: center; justify-content: center; flex-shrink: 0;
        }

        .p-sidebar__employee {
            padding: .9rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,.1);
            display: flex; align-items: center; gap: .7rem;
            flex-shrink: 0;
        }
        .p-sidebar__avatar {
            width: 40px; height: 40px; border-radius: 50%;
            background: var(--pgold); color: var(--pg);
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: .9rem; flex-shrink: 0; overflow: hidden;
        }
        .p-sidebar__avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
        .p-sidebar__emp-name { color: #fff; font-weight: 600; font-size: .83rem; line-height: 1.3; }
        .p-sidebar__emp-dept { color: rgba(255,255,255,.5); font-size: .7rem; margin-top: 1px; }

        .p-nav { padding: .6rem 0; flex: 1; }
        .p-nav__section { padding: .6rem 1.25rem .15rem; color: rgba(255,255,255,.3); font-size: .62rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; margin-top: .35rem; }
        .p-nav__link {
            display: flex; align-items: center; gap: .65rem;
            padding: .65rem 1.25rem; color: rgba(255,255,255,.7);
            text-decoration: none; font-size: .84rem; transition: all var(--ptrans);
            border-left: 3px solid transparent; min-height: 44px;
        }
        .p-nav__link:hover  { background: rgba(255,255,255,.08); color: #fff; }
        .p-nav__link.active { background: rgba(201,168,76,.15); color: var(--pgold); border-left-color: var(--pgold); }
        .p-nav__link i      { width: 18px; text-align: center; font-size: .84rem; flex-shrink: 0; }
        .p-nav__badge { margin-left: auto; background: var(--pgold); color: var(--pg); border-radius: 20px; padding: .1rem .45rem; font-size: .63rem; font-weight: 700; }

        .p-sidebar__footer {
            padding: .9rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,.1);
            flex-shrink: 0;
        }
        .p-sidebar__logout {
            display: flex; align-items: center; gap: .6rem;
            color: rgba(255,255,255,.5); font-size: .82rem; text-decoration: none;
            cursor: pointer; background: none; border: none; width: 100%; padding: .5rem 0;
            transition: color var(--ptrans); min-height: 40px;
        }
        .p-sidebar__logout:hover { color: #fff; }

        /* ── MAIN ── */
        .p-main { margin-left: var(--psidew); min-height: 100vh; display: flex; flex-direction: column; min-width: 0; }

        /* ── TOPBAR ── */
        .p-topbar {
            background: var(--pw); border-bottom: 1px solid var(--pborder);
            padding: 0 1.5rem; display: flex; align-items: center;
            justify-content: space-between; position: sticky; top: 0; z-index: 100;
            height: var(--pheaderh); gap: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,.06);
        }
        .p-topbar__left { display: flex; align-items: center; gap: .85rem; min-width: 0; }
        .p-topbar__info { min-width: 0; }
        .p-topbar__title { font-weight: 700; font-size: .97rem; color: var(--ptext); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .p-topbar__breadcrumb { font-size: .72rem; color: var(--pmuted); margin-top: 1px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .p-topbar__right { display: flex; align-items: center; gap: .75rem; flex-shrink: 0; }
        .p-topbar__date { font-size: .75rem; color: var(--pmuted); white-space: nowrap; }

        /* Hamburger */
        .p-hamburger {
            display: none;
            flex-direction: column; justify-content: center; align-items: center; gap: 4px;
            width: 38px; height: 38px; border-radius: 8px;
            background: none; border: 1.5px solid var(--pborder);
            cursor: pointer; flex-shrink: 0; transition: all var(--ptrans);
        }
        .p-hamburger:hover { border-color: var(--pg); }
        .p-hamburger span { display: block; width: 18px; height: 2px; background: var(--ptext); border-radius: 2px; transition: .3s; }
        .p-hamburger.open span:nth-child(1) { transform: rotate(45deg) translate(4px,4px); }
        .p-hamburger.open span:nth-child(2) { opacity: 0; }
        .p-hamburger.open span:nth-child(3) { transform: rotate(-45deg) translate(4px,-4px); }

        /* ── CONTENT ── */
        .p-content { padding: 1.75rem; flex: 1; }

        /* ── CARDS ── */
        .p-card { background: var(--pw); border-radius: var(--prad); box-shadow: var(--pshad); padding: 1.5rem; }
        .p-card__header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.1rem; flex-wrap: wrap; gap: .5rem; }
        .p-card__title { font-weight: 700; font-size: .92rem; color: var(--ptext); }

        /* ── STATS ── */
        .p-stats { display: grid; grid-template-columns: repeat(4,1fr); gap: 1rem; margin-bottom: 1.5rem; }
        .p-stat { background: var(--pw); border-radius: var(--prad); padding: 1.1rem 1.25rem; box-shadow: var(--pshad); display: flex; align-items: center; gap: .9rem; }
        .p-stat__icon { width: 46px; height: 46px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.15rem; flex-shrink: 0; }
        .p-stat__icon.green  { background: #D1FAE5; color: #065F46; }
        .p-stat__icon.blue   { background: #DBEAFE; color: #1E40AF; }
        .p-stat__icon.orange { background: #FEF3C7; color: #92400E; }
        .p-stat__icon.teal   { background: #CCFBF1; color: #134E4A; }
        .p-stat__icon.red    { background: #FEE2E2; color: #991B1B; }
        .p-stat__icon.purple { background: #EDE9FE; color: #4C1D95; }
        .p-stat__value { font-size: 1.35rem; font-weight: 800; line-height: 1; }
        .p-stat__label { font-size: .73rem; color: var(--pmuted); margin-top: 3px; }

        /* ── GRIDS ── */
        .p-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
        .p-grid-3 { display: grid; grid-template-columns: repeat(3,1fr); gap: 1rem; }

        /* ── TABLES ── */
        .p-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .p-table { width: 100%; border-collapse: collapse; font-size: .85rem; }
        .p-table th { padding: .6rem .75rem; text-align: left; font-size: .7rem; font-weight: 700; color: var(--pmuted); text-transform: uppercase; letter-spacing: .06em; border-bottom: 2px solid var(--pborder); white-space: nowrap; }
        .p-table td { padding: .65rem .75rem; border-bottom: 1px solid var(--pborder); }
        .p-table tr:last-child td { border-bottom: none; }
        .p-table tr:hover td { background: #F7FAFC; }

        /* ── BADGES ── */
        .p-badge { display: inline-flex; align-items: center; padding: .2rem .6rem; border-radius: 20px; font-size: .7rem; font-weight: 600; white-space: nowrap; }
        .p-badge.green   { background: #D1FAE5; color: #065F46; }
        .p-badge.orange  { background: #FEF3C7; color: #92400E; }
        .p-badge.red     { background: #FEE2E2; color: #991B1B; }
        .p-badge.blue    { background: #DBEAFE; color: #1E40AF; }
        .p-badge.grey    { background: #F1F5F9; color: #64748B; }
        .p-badge.purple  { background: #EDE9FE; color: #4C1D95; }

        /* ── BUTTONS ── */
        .p-btn { display: inline-flex; align-items: center; gap: .4rem; padding: .52rem 1.05rem; border-radius: 8px; font-size: .82rem; font-weight: 600; cursor: pointer; border: none; text-decoration: none; transition: all var(--ptrans); min-height: 40px; }
        .p-btn.primary { background: var(--pg); color: #fff; }
        .p-btn.primary:hover { background: var(--pg2); }
        .p-btn.gold    { background: var(--pgold); color: #fff; }
        .p-btn.outline { background: var(--pw); color: var(--ptext); border: 1.5px solid var(--pborder); }
        .p-btn.outline:hover { border-color: var(--pg); color: var(--pg); }
        .p-btn.sm      { padding: .32rem .7rem; font-size: .76rem; min-height: 34px; }
        .p-btn.danger  { background: #EF4444; color: #fff; }
        .p-btn.danger:hover { background: #DC2626; }

        /* ── FORMS ── */
        .p-form-group { margin-bottom: 1rem; }
        .p-label { display: block; font-size: .8rem; font-weight: 600; color: var(--ptext); margin-bottom: .35rem; }
        .p-input { width: 100%; padding: .58rem .88rem; border: 1.5px solid var(--pborder); border-radius: 8px; font-size: .875rem; background: var(--pw); color: var(--ptext); outline: none; transition: border-color var(--ptrans); min-height: 42px; font-family: inherit; }
        .p-input:focus { border-color: var(--pg); box-shadow: 0 0 0 3px rgba(27,67,50,.07); }
        textarea.p-input { min-height: 90px; resize: vertical; }
        select.p-input { cursor: pointer; }

        /* ── ALERTS ── */
        .p-alert { padding: .8rem 1rem; border-radius: 8px; font-size: .85rem; margin-bottom: 1rem; display: flex; align-items: flex-start; gap: .6rem; }
        .p-alert.success { background: #D1FAE5; color: #065F46; border: 1px solid #6EE7B7; }
        .p-alert.error   { background: #FEE2E2; color: #991B1B; border: 1px solid #FCA5A5; }
        .p-alert.info    { background: #DBEAFE; color: #1E40AF; border: 1px solid #93C5FD; }
        .p-alert.warning { background: #FEF3C7; color: #92400E; border: 1px solid #FCD34D; }

        /* ── PROGRESS ── */
        .p-progress { height: 6px; background: #E2E8F0; border-radius: 4px; overflow: hidden; }
        .p-progress__bar { height: 100%; border-radius: 4px; transition: width .4s; }

        /* ── RESPONSIVE ─────────────────────────────────────────────────────── */

        /* Tablet (≤1024px) */
        @media (max-width: 1024px) {
            .p-stats { grid-template-columns: repeat(2,1fr); }
            .p-grid-2 { grid-template-columns: 1fr; }
            .p-grid-3 { grid-template-columns: 1fr 1fr; }
        }

        /* Mobile (≤768px) */
        @media (max-width: 768px) {
            .p-sidebar { transform: translateX(-100%); }
            .p-sidebar.open { transform: translateX(0); box-shadow: 4px 0 24px rgba(0,0,0,.25); }
            .p-sidebar__headclose { display: flex; }
            .p-overlay.open { display: block; }
            .p-main { margin-left: 0; }
            .p-hamburger { display: flex; }
            .p-topbar { padding: 0 1rem; }
            .p-topbar__date { display: none; }
            .p-content { padding: 1rem; }
            .p-stats { grid-template-columns: 1fr 1fr; gap: .75rem; margin-bottom: 1.1rem; }
            .p-grid-2, .p-grid-3 { grid-template-columns: 1fr; }
            .p-card { padding: 1.1rem; }

            /* Wrap all tables in a scroll container */
            .p-table { display: block; overflow-x: auto; -webkit-overflow-scrolling: touch; }

            /* Inline grids used throughout views — override on mobile */
            [style*="grid-template-columns:1fr 1fr"],
            [style*="grid-template-columns: 1fr 1fr"] {
                grid-template-columns: 1fr !important;
            }
            [style*="grid-template-columns:1fr 1.6fr"],
            [style*="grid-template-columns: 1fr 1.6fr"],
            [style*="grid-template-columns:1fr 2fr"],
            [style*="grid-template-columns: 1fr 2fr"] {
                grid-template-columns: 1fr !important;
            }
        }

        /* Small mobile (≤480px) */
        @media (max-width: 480px) {
            html { font-size: 14px; }
            .p-stats { grid-template-columns: 1fr; }
            .p-grid-3 { grid-template-columns: 1fr; }
            .p-stat { padding: .9rem 1rem; }
            .p-btn { min-height: 44px; }
            .p-btn.sm { min-height: 38px; }
            .p-topbar__breadcrumb { display: none; }
        }

        /* Print */
        @media print {
            .p-sidebar, .p-topbar, .p-hamburger { display: none !important; }
            .p-main { margin-left: 0 !important; }
            .p-content { padding: 0 !important; }
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="p-overlay" id="p-overlay" onclick="pCloseSidebar()"></div>

<!-- Sidebar -->
<aside class="p-sidebar" id="p-sidebar">
    <div class="p-sidebar__head">
        <div class="p-sidebar__brand-wrap">
            <div class="p-sidebar__logo">CHAZ</div>
            <div class="p-sidebar__sub">Employee Self-Service</div>
        </div>
        <button class="p-sidebar__headclose" onclick="pCloseSidebar()" aria-label="Close menu">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="p-sidebar__employee">
        <div class="p-sidebar__avatar">
            @if($portalEmployee->photo)
                <img src="{{ Storage::url($portalEmployee->photo) }}" alt="">
            @else
                {{ $portalEmployee->initials }}
            @endif
        </div>
        <div style="min-width:0;">
            <div class="p-sidebar__emp-name">{{ $portalEmployee->full_name }}</div>
            <div class="p-sidebar__emp-dept">{{ $portalEmployee->staff_number }}</div>
            <div class="p-sidebar__emp-dept">{{ $portalEmployee->department->name ?? '' }}</div>
        </div>
    </div>

    <nav class="p-nav">
        <div class="p-nav__section">Main</div>
        <a href="{{ route('portal.dashboard') }}" class="p-nav__link {{ request()->routeIs('portal.dashboard') ? 'active' : '' }}" onclick="pCloseSidebarOnMobile()">
            <i class="fas fa-th-large"></i> Dashboard
        </a>

        <div class="p-nav__section">My Work</div>
        <a href="{{ route('portal.payslips.index') }}" class="p-nav__link {{ request()->routeIs('portal.payslips.*') ? 'active' : '' }}" onclick="pCloseSidebarOnMobile()">
            <i class="fas fa-file-invoice-dollar"></i> Payslips
        </a>
        <a href="{{ route('portal.leave.index') }}" class="p-nav__link {{ request()->routeIs('portal.leave.*') ? 'active' : '' }}" onclick="pCloseSidebarOnMobile()">
            <i class="fas fa-calendar-minus"></i> Leave
            @php $pendingCount = \App\Models\LeaveRequest::where('employee_id', session('portal_employee_id'))->where('status','pending')->count(); @endphp
            @if($pendingCount > 0)
            <span class="p-nav__badge">{{ $pendingCount }}</span>
            @endif
        </a>

        <div class="p-nav__section">Company</div>
        <a href="{{ route('portal.announcements.index') }}" class="p-nav__link {{ request()->routeIs('portal.announcements.*') ? 'active' : '' }}" onclick="pCloseSidebarOnMobile()">
            <i class="fas fa-bullhorn"></i> Announcements
        </a>

        <div class="p-nav__section">Account</div>
        <a href="{{ route('portal.profile') }}" class="p-nav__link {{ request()->routeIs('portal.profile*') ? 'active' : '' }}" onclick="pCloseSidebarOnMobile()">
            <i class="fas fa-user-circle"></i> My Profile
        </a>
    </nav>

    <div class="p-sidebar__footer">
        <form method="POST" action="{{ route('portal.logout') }}">
            @csrf
            <button type="submit" class="p-sidebar__logout">
                <i class="fas fa-sign-out-alt"></i> Sign Out
            </button>
        </form>
    </div>
</aside>

<!-- Main -->
<div class="p-main">
    <header class="p-topbar">
        <div class="p-topbar__left">
            <button class="p-hamburger" id="p-hamburger" onclick="pToggleSidebar()" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
            <div class="p-topbar__info">
                <div class="p-topbar__title">@yield('page_title', 'Dashboard')</div>
                <div class="p-topbar__breadcrumb">@yield('breadcrumb', 'Employee Portal')</div>
            </div>
        </div>
        <div class="p-topbar__right">
            <div class="p-topbar__date">{{ now()->format('d M Y') }}</div>
            <a href="{{ route('portal.profile') }}" style="text-decoration:none;" title="My Profile">
                <div class="p-sidebar__avatar" style="width:34px;height:34px;font-size:.75rem;">
                    @if($portalEmployee->photo)
                        <img src="{{ Storage::url($portalEmployee->photo) }}" alt="">
                    @else
                        {{ $portalEmployee->initials }}
                    @endif
                </div>
            </a>
        </div>
    </header>

    <div class="p-content">
        @if(session('success'))
        <div class="p-alert success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="p-alert error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</div>

<script>
function pToggleSidebar() {
    const sb  = document.getElementById('p-sidebar');
    const ov  = document.getElementById('p-overlay');
    const hb  = document.getElementById('p-hamburger');
    const open = sb.classList.toggle('open');
    ov.classList.toggle('open', open);
    hb.classList.toggle('open', open);
    document.body.style.overflow = open ? 'hidden' : '';
}
function pCloseSidebar() {
    document.getElementById('p-sidebar').classList.remove('open');
    document.getElementById('p-overlay').classList.remove('open');
    document.getElementById('p-hamburger').classList.remove('open');
    document.body.style.overflow = '';
}
function pCloseSidebarOnMobile() {
    if (window.innerWidth <= 768) pCloseSidebar();
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') pCloseSidebar(); });
window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
        document.body.style.overflow = '';
        document.getElementById('p-overlay').classList.remove('open');
    }
});
</script>
@stack('scripts')
</body>
</html>
