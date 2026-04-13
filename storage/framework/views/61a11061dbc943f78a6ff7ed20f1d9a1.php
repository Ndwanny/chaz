<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Admin Panel'); ?> — CHAZ</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
    <style>
        :root {
            --forest:      #1B4332;
            --forest-mid:  #2D6A4F;
            --forest-lite: #40916C;
            --gold:        #C9A84C;
            --gold-lite:   #E9C46A;
            --cream:       #FAF7F0;
            --slate:       #2C3E50;
            --slate-mid:   #546E7A;
            --slate-lite:  #B0BEC5;
            --border:      #E2E8F0;
            --white:       #FFFFFF;
            --red:         #E53E3E;
            --green:       #38A169;
            --sidebar-w:   260px;
            --header-h:    60px;
            --radius:      8px;
            --shadow:      0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.05);
            --shadow-md:   0 4px 16px rgba(0,0,0,0.10);
            --font:        'DM Sans', system-ui, sans-serif;
            --font-display:'Playfair Display', serif;
            --transition:  0.2s ease;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: 15px; }
        body { font-family: var(--font); background: #F1F5F4; color: var(--slate); display: flex; min-height: 100vh; }
        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }
        img { max-width: 100%; }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--forest);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 200;
            overflow-y: auto;
            transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
            -webkit-overflow-scrolling: touch;
        }
        .sidebar__brand {
            padding: 1.1rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            min-height: var(--header-h);
        }
        .sidebar__logo-mark {
            width: 34px; height: 34px;
            background: var(--gold);
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.05rem; color: var(--forest); font-weight: 700; flex-shrink: 0;
        }
        .sidebar__brand-text { line-height: 1.2; }
        .sidebar__brand-title { font-family: var(--font-display); font-size: .95rem; color: white; font-weight: 700; }
        .sidebar__brand-sub { font-size: 0.65rem; color: rgba(255,255,255,0.4); }

        /* Close button — mobile only */
        .sidebar__close {
            display: none;
            position: absolute; top: .85rem; right: 1rem;
            background: rgba(255,255,255,.1); border: none; color: #fff;
            width: 30px; height: 30px; border-radius: 6px;
            font-size: .9rem; cursor: pointer; align-items: center; justify-content: center;
        }

        .sidebar__nav { padding: 0.75rem 0; flex: 1; }
        .nav-section { padding: 0.65rem 1.25rem 0.3rem; font-size: 0.63rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: rgba(255,255,255,0.3); }

        .nav-item a {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.7rem 1.25rem;
            font-size: 0.875rem; font-weight: 500;
            color: rgba(255,255,255,0.65);
            border-left: 3px solid transparent;
            transition: all var(--transition);
            min-height: 44px;
        }
        .nav-item a i { width: 18px; text-align: center; font-size: 0.88rem; flex-shrink: 0; }
        .nav-item a:hover { color: white; background: rgba(255,255,255,0.06); border-left-color: rgba(255,255,255,0.2); }
        .nav-item.active a { color: white; background: rgba(201,168,76,0.15); border-left-color: var(--gold); font-weight: 600; }
        .nav-item a .badge-count {
            margin-left: auto;
            background: var(--red);
            color: white;
            font-size: 0.63rem;
            font-weight: 700;
            padding: 0.15rem 0.45rem;
            border-radius: 50px;
            min-width: 20px;
            text-align: center;
        }

        .sidebar__footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar__user {
            display: flex; align-items: center; gap: 0.65rem;
            padding: 0.5rem 0 0.65rem;
        }
        .sidebar__avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: var(--gold);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.82rem; font-weight: 700; color: var(--forest);
            flex-shrink: 0;
        }
        .sidebar__user-name { font-size: 0.82rem; font-weight: 600; color: white; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 160px; }
        .sidebar__user-role { font-size: 0.68rem; color: rgba(255,255,255,0.4); text-transform: capitalize; }
        .sidebar__logout {
            display: flex; align-items: center; gap: 0.5rem;
            font-size: 0.8rem; color: rgba(255,255,255,0.45);
            padding: 0.5rem 0;
            cursor: pointer; transition: color var(--transition);
            background: none; border: none; width: 100%;
            min-height: 40px;
        }
        .sidebar__logout:hover { color: #FC8181; }

        /* ── OVERLAY ── */
        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 190;
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
        }
        .sidebar-overlay.open { display: block; }

        /* ── MAIN ── */
        .main-wrap { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; min-width: 0; }

        /* ── TOPBAR ── */
        .topbar {
            height: var(--header-h);
            background: white;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky; top: 0; z-index: 100;
            box-shadow: var(--shadow);
            gap: 1rem;
        }
        .topbar__left { display: flex; align-items: center; gap: 0.85rem; min-width: 0; }
        .topbar__title { font-family: var(--font-display); font-size: 1.1rem; font-weight: 700; color: var(--forest); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .topbar__right { display: flex; align-items: center; gap: 0.75rem; flex-shrink: 0; }

        /* Hamburger */
        .topbar__hamburger {
            display: none;
            flex-direction: column; justify-content: center; align-items: center; gap: 4px;
            width: 38px; height: 38px; border-radius: 8px;
            background: none; border: 1.5px solid var(--border);
            cursor: pointer; flex-shrink: 0;
            transition: all var(--transition);
        }
        .topbar__hamburger:hover { border-color: var(--forest); background: rgba(27,67,50,.04); }
        .topbar__hamburger span {
            display: block; width: 18px; height: 2px;
            background: var(--slate); border-radius: 2px; transition: .3s;
        }
        .topbar__hamburger.open span:nth-child(1) { transform: rotate(45deg) translate(4px,4px); }
        .topbar__hamburger.open span:nth-child(2) { opacity: 0; }
        .topbar__hamburger.open span:nth-child(3) { transform: rotate(-45deg) translate(4px,-4px); }

        .topbar__btn {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.42rem 0.85rem;
            border-radius: var(--radius);
            font-size: 0.8rem; font-weight: 600;
            transition: all var(--transition);
            border: 1.5px solid;
            cursor: pointer; min-height: 36px;
        }
        .topbar__btn--forest { background: var(--forest); border-color: var(--forest); color: white; }
        .topbar__btn--forest:hover { background: var(--forest-mid); }
        .topbar__btn--outline { background: transparent; border-color: var(--border); color: var(--slate-mid); }
        .topbar__btn--outline:hover { border-color: var(--forest); color: var(--forest); }

        /* ── CONTENT ── */
        .page-content { padding: 1.75rem; flex: 1; }

        /* ── CARDS ── */
        .card {
            background: white;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }
        .card-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between; gap: 0.75rem; flex-wrap: wrap;
        }
        .card-title { font-size: 0.92rem; font-weight: 700; color: var(--slate); }
        .card-body { padding: 1.25rem; }

        /* ── STAT CARDS ── */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.75rem; }
        .stat-card, .stat-box {
            background: white;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 1.25rem;
            display: flex; align-items: flex-start; gap: 1rem;
            box-shadow: var(--shadow);
            transition: transform var(--transition), box-shadow var(--transition);
        }
        .stat-card:hover, .stat-box:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
        .stat-icon, .stat-box__icon {
            width: 42px; height: 42px;
            border-radius: var(--radius);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.05rem; flex-shrink: 0;
        }
        .stat-box__icon--green  { background: rgba(27,67,50,0.1);  color: var(--forest); }
        .stat-box__icon--gold   { background: rgba(201,168,76,0.15); color: #8B6914; }
        .stat-box__icon--blue   { background: rgba(49,130,206,0.1);  color: #2B6CB0; }
        .stat-box__icon--red    { background: rgba(229,62,62,0.1);   color: var(--red); }
        .stat-box__icon--teal   { background: rgba(56,178,172,0.1);  color: #2C7A7B; }
        .stat-value, .stat-box__num { font-family: var(--font-display); font-size: 1.6rem; font-weight: 700; color: var(--slate); line-height: 1; margin-bottom: 0.2rem; }
        .stat-label, .stat-box__label { font-size: 0.78rem; color: var(--slate-mid); font-weight: 500; }
        .stat-box__sub { font-size: 0.7rem; color: var(--slate-lite); margin-top: 0.1rem; }

        /* ── TABLE ── */
        .table-responsive, .table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        thead th { padding: 0.65rem 0.9rem; text-align: left; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase; color: var(--slate-mid); background: #F8FAFB; border-bottom: 1px solid var(--border); white-space: nowrap; }
        tbody td { padding: 0.8rem 0.9rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: #FAFCFB; }
        .table-hover tbody tr:hover td { background: #F7FBF8; }
        .table-sm thead th { padding: 0.5rem 0.75rem; }
        .table-sm tbody td { padding: 0.6rem 0.75rem; }

        /* ── BADGES ── */
        .badge { display: inline-block; padding: 0.18rem 0.6rem; border-radius: 50px; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.04em; text-transform: uppercase; white-space: nowrap; }
        .badge-success, .badge-green { background: rgba(56,161,105,0.12); color: #276749; }
        .badge-danger,  .badge-red   { background: rgba(229,62,62,0.1);   color: #C53030; }
        .badge-warning, .badge-gold  { background: rgba(201,168,76,0.15); color: #8B6914; }
        .badge-primary, .badge-blue  { background: rgba(49,130,206,0.1);  color: #2B6CB0; }
        .badge-secondary,.badge-grey { background: rgba(160,174,192,0.15);color: var(--slate-mid); }
        .badge-info                  { background: rgba(56,178,172,0.1);  color: #2C7A7B; }

        /* ── FORMS ── */
        .form-grid { display: grid; gap: 1.1rem; }
        .form-grid--2 { grid-template-columns: 1fr 1fr; }
        .form-grid--3 { grid-template-columns: 1fr 1fr 1fr; }
        .form-group, .form-group { display: flex; flex-direction: column; gap: 0.35rem; margin-bottom: 1rem; }
        .form-group.span-2 { grid-column: span 2; }
        .form-group.span-3 { grid-column: span 3; }
        .form-label { font-size: 0.8rem; font-weight: 600; color: var(--slate); }
        .form-label span, .text-danger { color: var(--red); }
        .form-control {
            padding: 0.6rem 0.85rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            font-family: var(--font);
            font-size: 0.875rem;
            color: var(--slate);
            background: white;
            outline: none;
            transition: border-color var(--transition), box-shadow var(--transition);
            width: 100%;
            min-height: 42px;
        }
        .form-control:focus { border-color: var(--forest); box-shadow: 0 0 0 3px rgba(27,67,50,0.08); }
        select.form-control { cursor: pointer; }
        textarea.form-control { resize: vertical; min-height: 110px; }
        .form-control-sm { min-height: 36px; padding: 0.38rem 0.7rem; font-size: 0.82rem; }
        .form-hint, .text-muted { font-size: 0.74rem; color: var(--slate-mid); }
        .form-error { font-size: 0.74rem; color: var(--red); }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.55rem 1.1rem;
            border-radius: var(--radius);
            font-family: var(--font); font-size: 0.84rem; font-weight: 600;
            border: 1.5px solid transparent;
            cursor: pointer; transition: all var(--transition);
            white-space: nowrap; min-height: 40px; text-decoration: none;
        }
        .btn-primary, .btn-forest { background: var(--forest); color: white; border-color: var(--forest); }
        .btn-primary:hover, .btn-forest:hover { background: var(--forest-mid); }
        .btn-gold    { background: var(--gold); color: var(--forest); border-color: var(--gold); }
        .btn-gold:hover { background: var(--gold-lite); }
        .btn-secondary,.btn-outline { background: transparent; color: var(--slate); border-color: var(--border); }
        .btn-secondary:hover,.btn-outline:hover { border-color: var(--forest); color: var(--forest); }
        .btn-success { background: #38A169; color: white; border-color: #38A169; }
        .btn-success:hover { background: #276749; }
        .btn-warning { background: #D97706; color: white; border-color: #D97706; }
        .btn-warning:hover { background: #B45309; }
        .btn-danger  { background: var(--red); color: white; border-color: var(--red); }
        .btn-danger:hover { background: #C53030; }
        .btn-info    { background: #2B6CB0; color: white; border-color: #2B6CB0; }
        .btn-sm { padding: 0.35rem 0.8rem; font-size: 0.78rem; min-height: 34px; }
        .btn-xs { padding: 0.25rem 0.6rem; font-size: 0.73rem; min-height: 28px; }
        .btn-icon { padding: 0.4rem 0.55rem; }

        /* ── ALERTS ── */
        .alert { padding: 0.8rem 1rem; border-radius: var(--radius); font-size: 0.875rem; display: flex; align-items: flex-start; gap: 0.65rem; margin-bottom: 1.25rem; }
        .alert-success { background: rgba(56,161,105,0.1); border: 1px solid rgba(56,161,105,0.25); color: #276749; }
        .alert-danger, .alert-error { background: rgba(229,62,62,0.08); border: 1px solid rgba(229,62,62,0.2); color: #C53030; }
        .alert-info    { background: rgba(49,130,206,0.08); border: 1px solid rgba(49,130,206,0.2); color: #2B6CB0; }
        .alert-warning { background: rgba(217,119,6,.08); border: 1px solid rgba(217,119,6,.2); color: #92400E; }

        /* ── PAGINATION ── */
        .pagination { display: flex; gap: 0.35rem; align-items: center; justify-content: flex-end; padding-top: 1.1rem; flex-wrap: wrap; }
        .pagination a, .pagination span { display: inline-flex; align-items: center; justify-content: center; min-width: 32px; height: 32px; padding: 0 0.55rem; border-radius: 6px; font-size: 0.8rem; font-weight: 500; border: 1.5px solid var(--border); color: var(--slate-mid); transition: all var(--transition); }
        .pagination a:hover { border-color: var(--forest); color: var(--forest); }
        .pagination .active span { background: var(--forest); border-color: var(--forest); color: white; }

        /* ── MISC ── */
        .page-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.75rem; }
        .page-title { font-family: var(--font-display); font-size: 1.35rem; font-weight: 700; color: var(--forest); line-height: 1.2; }
        .page-subtitle { font-size: 0.8rem; color: var(--slate-mid); margin-top: 0.2rem; }
        .breadcrumb { display: flex; align-items: center; gap: 0.4rem; font-size: 0.78rem; color: var(--slate-mid); margin-bottom: 0.3rem; }
        .breadcrumb a { color: var(--forest); }
        .empty-state { text-align: center; padding: 3.5rem 2rem; color: var(--slate-mid); }
        .empty-state i { font-size: 2.5rem; opacity: 0.25; display: block; margin-bottom: 0.85rem; }
        .empty-state p { font-size: 0.875rem; }
        .divider { border: none; border-top: 1px solid var(--border); margin: 1.25rem 0; }
        .text-right { text-align: right; }
        code { background: #F1F5F9; padding: .1rem .4rem; border-radius: 4px; font-size: .82em; color: var(--forest); }

        /* ── RESPONSIVE ─────────────────────────────────────────────────────── */

        /* Tablet (≤1024px) */
        @media (max-width: 1024px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .form-grid--3 { grid-template-columns: 1fr 1fr; }
        }

        /* Mobile (≤768px) */
        @media (max-width: 768px) {
            /* Sidebar off-canvas */
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); box-shadow: 4px 0 24px rgba(0,0,0,.25); }
            .sidebar__close { display: flex; }

            /* Main fills screen */
            .main-wrap { margin-left: 0; }

            /* Show hamburger */
            .topbar__hamburger { display: flex; }

            /* Topbar compress */
            .topbar { padding: 0 1rem; }
            .topbar__title { font-size: 1rem; }
            .topbar__btn span, .topbar__btn--outline span { display: none; }

            /* Content padding */
            .page-content { padding: 1rem; }

            /* Page header stacks */
            .page-header { flex-direction: column; align-items: stretch; }
            .page-header > div:last-child { display: flex; flex-wrap: wrap; gap: .5rem; }

            /* Stats 2-col */
            .stats-grid { grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1.25rem; }

            /* Grids collapse */
            .form-grid--2, .form-grid--3 { grid-template-columns: 1fr; }
            .form-group.span-2, .form-group.span-3 { grid-column: span 1; }

            /* Card padding */
            .card-header { padding: 0.85rem 1rem; }
            .card-body { padding: 1rem; }

            /* Table always scrollable */
            .card > table, .card-body > table { display: block; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        }

        /* Ensure all card tables scroll on mobile */
        @media (max-width: 768px) {
            .card table { display: block; overflow-x: auto; -webkit-overflow-scrolling: touch; width: 100%; }
            /* Two-col inline grids collapse */
            .form-grid--2 > *, .form-grid--3 > * { grid-column: span 1 !important; }
        }

        /* Small mobile (≤480px) */
        @media (max-width: 480px) {
            html { font-size: 14px; }
            .stats-grid { grid-template-columns: 1fr; }
            .stat-card, .stat-box { padding: 1rem; }
            .topbar__right .topbar__btn--outline { display: none; }
            .btn { min-height: 44px; }
            .btn-sm { min-height: 38px; }
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>


<div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>


<?php $unread = \App\Models\ContactMessage::unread()->count(); ?>
<aside class="sidebar" id="sidebar">
    <button class="sidebar__close" onclick="closeSidebar()" aria-label="Close menu">
        <i class="fa fa-times"></i>
    </button>

    <div class="sidebar__brand">
        <div class="sidebar__logo-mark">✛</div>
        <div class="sidebar__brand-text">
            <div class="sidebar__brand-title">CHAZ Admin</div>
            <div class="sidebar__brand-sub">Management Panel</div>
        </div>
    </div>

    <nav class="sidebar__nav">
        <div class="nav-section">Main</div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.dashboard')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-gauge"></i> Dashboard</a>
        </div>

        <div class="nav-section">Content</div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.news*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.news.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-newspaper"></i> News Articles</a>
        </div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.jobs*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.jobs.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-briefcase"></i> Job Postings</a>
        </div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.tenders*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.tenders.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-file-contract"></i> Tenders</a>
        </div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.members*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.members.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-hospital"></i> Members</a>
        </div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.downloads*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.downloads.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-download"></i> Downloads</a>
        </div>

        <div class="nav-section">Inbox</div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.messages*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.messages.index')); ?>" onclick="closeSidebarOnMobile()">
                <i class="fa fa-envelope"></i> Messages
                <?php if($unread > 0): ?><span class="badge-count"><?php echo e($unread); ?></span><?php endif; ?>
            </a>
        </div>

        <?php if(admin_can('manage_system')): ?>
        <div class="nav-section">Organisation</div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.users*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.users.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-users-cog"></i> Users</a>
        </div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.roles*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.roles.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-user-shield"></i> Roles</a>
        </div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.departments*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.departments.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-sitemap"></i> Departments</a>
        </div>
        <?php endif; ?>

        <?php if(admin_can('view_employees') || admin_can('manage_employees')): ?>
        <div class="nav-section">Human Resources</div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.employees*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.employees.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-id-badge"></i> Employees</a>
        </div>
        <?php endif; ?>
        <?php if(admin_can('view_leave') || admin_can('manage_hr')): ?>
        <div class="nav-item <?php echo e(request()->routeIs('admin.leave*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.leave.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-calendar-minus"></i> Leave</a>
        </div>
        <?php endif; ?>
        <?php if(admin_can('manage_hr') || admin_can('super_admin')): ?>
        <div class="nav-item <?php echo e(request()->routeIs('admin.portal-accounts*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.portal-accounts.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-id-card"></i> Portal Accounts</a>
        </div>
        <?php endif; ?>

        <?php if(admin_can('view_payroll') || admin_can('manage_payroll')): ?>
        <div class="nav-section">Payroll</div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.payroll*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.payroll.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-money-bill-wave"></i> Payroll</a>
        </div>
        <?php endif; ?>

        <?php if(admin_can('view_procurement') || admin_can('manage_procurement')): ?>
        <div class="nav-section">Procurement</div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.requisitions*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.requisitions.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-file-lines"></i> Requisitions</a>
        </div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.purchase-orders*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.purchase-orders.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-file-invoice"></i> Purchase Orders</a>
        </div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.suppliers*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.suppliers.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-truck"></i> Suppliers</a>
        </div>
        <?php endif; ?>

        <?php if(admin_can('view_inventory') || admin_can('manage_inventory')): ?>
        <div class="nav-section">Inventory</div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.inventory*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.inventory.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-boxes-stacked"></i> Stock & Items</a>
        </div>
        <?php endif; ?>

        <?php if(admin_can('view_fleet') || admin_can('manage_fleet')): ?>
        <div class="nav-section">Fleet</div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.fleet.vehicles*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.fleet.vehicles.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-car"></i> Vehicles</a>
        </div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.fleet.trips*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.fleet.trips.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-route"></i> Trips</a>
        </div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.fleet.fuel*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.fleet.fuel.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-gas-pump"></i> Fuel Logs</a>
        </div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.fleet.maintenance*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.fleet.maintenance.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-wrench"></i> Maintenance</a>
        </div>
        <?php endif; ?>

        <?php if(admin_can('view_finance') || admin_can('manage_finance')): ?>
        <div class="nav-section">Finance</div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.finance.budgets*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.finance.budgets.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-chart-pie"></i> Budgets</a>
        </div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.finance.expenses*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.finance.expenses.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-receipt"></i> Expenses</a>
        </div>
        <?php endif; ?>

        <?php if(admin_can('manage_content') || admin_can('manage_comms')): ?>
        <div class="nav-item <?php echo e(request()->routeIs('admin.announcements*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.announcements.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-bullhorn"></i> Announcements</a>
        </div>
        <?php endif; ?>

        <?php if(admin_can('view_reports') || admin_can('manage_system')): ?>
        <div class="nav-section">Reports</div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.reports*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.reports.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-chart-bar"></i> Reports</a>
        </div>
        <?php endif; ?>

        <div class="nav-section">System</div>
        <div class="nav-item <?php echo e(request()->routeIs('admin.settings*') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.settings.index')); ?>" onclick="closeSidebarOnMobile()"><i class="fa fa-gear"></i> Settings</a>
        </div>
        <div class="nav-item">
            <a href="<?php echo e(route('home')); ?>" target="_blank"><i class="fa fa-arrow-up-right-from-square"></i> View Website</a>
        </div>
    </nav>

    <div class="sidebar__footer">
        <div class="sidebar__user">
            <div class="sidebar__avatar"><?php echo e(strtoupper(substr(session('admin_name','A'),0,1))); ?></div>
            <div style="min-width:0;">
                <div class="sidebar__user-name"><?php echo e(session('admin_name', 'Administrator')); ?></div>
                <div class="sidebar__user-role"><?php echo e(session('admin_role', 'admin')); ?></div>
            </div>
        </div>
        <form action="<?php echo e(route('admin.logout')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="sidebar__logout">
                <i class="fa fa-right-from-bracket"></i> Sign Out
            </button>
        </form>
    </div>
</aside>


<div class="main-wrap">
    <header class="topbar">
        <div class="topbar__left">
            <button class="topbar__hamburger" id="hamburger" onclick="toggleSidebar()" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
            <div class="topbar__title"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></div>
        </div>
        <div class="topbar__right">
            <?php echo $__env->yieldContent('topbar-actions'); ?>
            <a href="<?php echo e(route('home')); ?>" target="_blank" class="topbar__btn topbar__btn--outline">
                <i class="fa fa-eye"></i> <span>View Site</span>
            </a>
        </div>
    </header>

    <main class="page-content">
        <?php if(session('success')): ?>
        <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
        <div class="alert alert-error"><i class="fa fa-circle-xmark"></i> <?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>
</div>

<script>
function toggleSidebar() {
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.getElementById('sidebar-overlay');
    const burger   = document.getElementById('hamburger');
    const isOpen   = sidebar.classList.toggle('open');
    overlay.classList.toggle('open', isOpen);
    burger.classList.toggle('open', isOpen);
    document.body.style.overflow = isOpen ? 'hidden' : '';
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebar-overlay').classList.remove('open');
    document.getElementById('hamburger').classList.remove('open');
    document.body.style.overflow = '';
}
function closeSidebarOnMobile() {
    if (window.innerWidth <= 768) closeSidebar();
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSidebar(); });
// Restore scroll on resize
window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
        document.body.style.overflow = '';
        document.getElementById('sidebar-overlay').classList.remove('open');
    }
});
</script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>