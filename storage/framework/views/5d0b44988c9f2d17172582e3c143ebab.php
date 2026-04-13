<?php $__env->startSection('title', 'Employee Portal — CHAZ'); ?>
<?php $__env->startSection('meta_description', 'The CHAZ Employee Self-Service Portal — your one-stop hub for payslips, leave management, HR policies, training resources, and more.'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* ── Prevent horizontal overflow on this page ───────────── */
    html { overflow-x: hidden; }

    /* ── Portal-specific overrides ───────────────────────── */
    .portal-hero { background: linear-gradient(135deg, #1B4332 0%, #0F2A1E 60%, #1B4332 100%); }

    /* ── Hero 2-col grid ─────────────────────────────────── */
    /* Override the home-hero container grid so portal-hero-grid spans full width */
    .portal-hero .container {
        display: block !important;
    }
    .portal-hero-grid {
        display: grid;
        grid-template-columns: 1fr 1.4fr;
        gap: 4rem;
        align-items: center;
    }

    /* Login card — fills its grid column, grows with the column */
    .portal-login-card {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.14);
        backdrop-filter: blur(12px);
        border-radius: var(--radius-lg);
        padding: 3rem 3.5rem;
        width: 100%;
        box-sizing: border-box;
    }
    .portal-login-card h3 {
        font-family: var(--font-display);
        font-size: 1.3rem;
        color: white;
        margin-bottom: 0.5rem;
    }
    .portal-login-card p { font-size: 0.875rem; color: #ffffff; opacity: 1; margin-bottom: 1.75rem; }
    .portal-input {
        width: 100%;
        padding: 0.75rem 1rem;
        background: rgba(255,255,255,0.08);
        border: 1.5px solid rgba(255,255,255,0.2);
        border-radius: var(--radius-sm);
        color: white;
        font-family: var(--font-body);
        font-size: 0.9rem;
        outline: none;
        transition: border-color var(--transition);
        margin-bottom: 1rem;
        box-sizing: border-box;
    }
    .portal-input::placeholder { color: rgba(255,255,255,0.4); }
    .portal-input:focus { border-color: var(--color-gold); }

    /* ── About portal 2-col layout ───────────────────────── */
    .about-portal-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
    }
    .about-attrs-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    /* ── Feature cards ───────────────────────────────────── */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
    }
    .feature-card {
        background: var(--color-white);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: 1.75rem 1.5rem;
        transition: all var(--transition);
        position: relative;
        overflow: hidden;
    }
    .feature-card::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 3px;
        transform: scaleX(0);
        transition: transform var(--transition);
    }
    .feature-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-lg); }
    .feature-card:hover::after { transform: scaleX(1); }
    .feature-card--green::after  { background: var(--color-forest); }
    .feature-card--gold::after   { background: var(--color-gold); }
    .feature-card--blue::after   { background: #2B6CB0; }
    .feature-card--teal::after   { background: #2C7A7B; }
    .feature-card--red::after    { background: #C53030; }

    .feature-card__icon {
        width: 50px; height: 50px;
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.25rem;
        margin-bottom: 1.25rem;
    }
    .icon--green { background: rgba(27,67,50,0.1);  color: var(--color-forest); }
    .icon--gold  { background: rgba(201,168,76,0.15); color: #8B6914; }
    .icon--blue  { background: rgba(43,108,176,0.1); color: #2B6CB0; }
    .icon--teal  { background: rgba(44,122,123,0.1); color: #2C7A7B; }
    .icon--red   { background: rgba(197,48,48,0.1);  color: #C53030; }

    .feature-card__title {
        font-family: var(--font-display);
        font-size: 1rem;
        font-weight: 700;
        color: var(--color-forest);
        margin-bottom: 0.6rem;
    }
    .feature-card__desc { font-size: 0.85rem; color: var(--color-slate-mid); line-height: 1.75; }

    /* ── Quick links grid ────────────────────────────────── */
    .quick-links-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
    }
    .quick-link-btn {
        background: white;
        border: 1.5px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: 1.5rem 1rem;
        text-align: center;
        cursor: pointer;
        transition: all var(--transition);
        display: flex; flex-direction: column;
        align-items: center; gap: 0.75rem;
        text-decoration: none;
    }
    .quick-link-btn:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
    .quick-link-btn--green:hover  { border-color: var(--color-forest); }
    .quick-link-btn--gold:hover   { border-color: var(--color-gold); }
    .quick-link-btn--blue:hover   { border-color: #2B6CB0; }
    .quick-link-btn--teal:hover   { border-color: #2C7A7B; }
    .quick-link-btn--red:hover    { border-color: #C53030; }
    .quick-link-btn__icon {
        width: 48px; height: 48px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.15rem;
    }
    .quick-link-btn__label { font-size: 0.82rem; font-weight: 600; color: var(--color-slate); }

    /* ── Benefits layout ─────────────────────────────────── */
    .benefits-layout {
        display: grid;
        grid-template-columns: 1fr 1.6fr;
        gap: 4rem;
        align-items: center;
    }
    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
    .benefit-item {
        display: flex;
        gap: 1.25rem;
        align-items: flex-start;
        padding: 1.75rem;
        background: white;
        border-radius: var(--radius-md);
        border: 1px solid var(--color-border);
        transition: all var(--transition);
    }
    .benefit-item:hover { box-shadow: var(--shadow-md); transform: translateY(-3px); }
    .benefit-item__icon {
        width: 52px; height: 52px;
        background: var(--color-forest);
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        color: var(--color-gold);
        font-size: 1.3rem;
        flex-shrink: 0;
    }
    .benefit-item__title {
        font-family: var(--font-display);
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--color-forest);
        margin-bottom: 0.5rem;
    }
    .benefit-item__desc { font-size: 0.875rem; color: var(--color-slate-mid); line-height: 1.75; }

    /* ── Metrics grid ────────────────────────────────────── */
    .metrics-insights-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        max-width: 960px;
        margin: 0 auto;
    }

    /* ── Security layout ─────────────────────────────────── */
    .security-layout {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 4rem;
        align-items: center;
    }
    .security-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
    }
    .security-item {
        display: flex;
        gap: 0.9rem;
        align-items: flex-start;
    }
    .security-item__icon {
        width: 40px; height: 40px;
        background: rgba(201,168,76,0.15);
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        color: var(--color-gold-lite);
        font-size: 1rem;
        flex-shrink: 0;
    }
    .security-item__title { font-size: 0.88rem; font-weight: 600; color: white; margin-bottom: 0.25rem; }
    .security-item__desc  { font-size: 0.8rem;  color: rgba(255,255,255,0.6); line-height: 1.6; }

    /* ── Steps grid ──────────────────────────────────────── */
    .steps-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
        max-width: 1000px;
        margin: 0 auto 3rem;
        position: relative;
    }
    .steps-connector {
        position: absolute;
        top: 28px; left: 12.5%; right: 12.5%;
        height: 2px;
        background: linear-gradient(90deg, var(--color-forest), var(--color-gold));
        z-index: 0;
        border-radius: 2px;
    }

    /* ── Responsive ──────────────────────────────────────── */
    @media (max-width: 1024px) {
        .portal-hero .container { display: block !important; }
        .portal-hero-grid      { grid-template-columns: 1fr 1.4fr; gap: 2.5rem; }
        .features-grid         { grid-template-columns: repeat(2, 1fr); }
        .security-layout       { grid-template-columns: 1fr; gap: 2rem; }
        .security-grid         { grid-template-columns: repeat(2, 1fr); }
        .benefits-layout       { grid-template-columns: 1fr; gap: 2rem; }
        .about-portal-grid     { grid-template-columns: 1fr; gap: 2.5rem; }
        .metrics-insights-grid { grid-template-columns: repeat(2, 1fr); }
        .steps-grid            { grid-template-columns: repeat(2, 1fr); }
        .steps-connector       { display: none; }
    }
    @media (max-width: 768px) {
        .portal-hero-grid      { grid-template-columns: 1fr; gap: 2rem; }
        .portal-login-card     { display: none; }
        .features-grid         { grid-template-columns: repeat(2, 1fr); }
        .quick-links-grid      { grid-template-columns: repeat(2, 1fr); }
        .benefits-grid         { grid-template-columns: 1fr; }
        .metrics-insights-grid { grid-template-columns: repeat(2, 1fr); }
        .security-grid         { grid-template-columns: 1fr; }
        .about-attrs-grid      { grid-template-columns: repeat(2, 1fr); }
        .steps-grid            { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 480px) {
        .features-grid         { grid-template-columns: 1fr; }
        .quick-links-grid      { grid-template-columns: repeat(2, 1fr); }
        .metrics-insights-grid { grid-template-columns: 1fr; }
        .about-attrs-grid      { grid-template-columns: repeat(2, 1fr); }
        .steps-grid            { grid-template-columns: 1fr; }
        .benefits-grid         { grid-template-columns: 1fr; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>




<section class="home-hero portal-hero">
    <div class="home-hero__bg"></div>
    <div class="container">
        <div class="portal-hero-grid">

            
            <div class="home-hero__content">
                <div class="home-hero__badge">
                    <i class="fa fa-circle-nodes"></i> Employee Self-Service Portal
                </div>
                <h1 class="home-hero__title">
                    Your CHAZ<br>Workspace,<br><em>Anywhere</em>
                </h1>
                <p class="home-hero__desc">
                    The CHAZ Employee Portal is your personal digital hub — giving every staff member across all 10 provinces instant access to payslips, leave management, HR policies, training resources, and much more.
                </p>
                <div class="home-hero__actions">
                    <a href="#portal-login" class="btn btn--gold btn--lg">
                        <i class="fa fa-right-to-bracket"></i> Sign In to Portal
                    </a>
                    <a href="#features" class="btn btn--outline-white btn--lg">
                        Explore Features
                    </a>
                </div>

                <div class="home-hero__stats" style="margin-top:2.5rem;">
                    <?php $__currentLoopData = $metrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="stat-card fade-in">
                        <div class="stat-card__num"><?php echo e($m['value']); ?></div>
                        <div class="stat-card__label"><?php echo e($m['label']); ?></div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div id="portal-login" class="portal-login-card fade-in">
                <h3>Employee Sign In</h3>
                <p>Enter your CHAZ staff credentials to access your portal.</p>

                <?php if(session('error')): ?>
                <div style="background:rgba(220,38,38,0.15);border:1px solid rgba(220,38,38,0.4);border-radius:8px;padding:10px 14px;margin-bottom:1rem;color:#fca5a5;font-size:.85rem;"><?php echo e(session('error')); ?></div>
                <?php endif; ?>
                <?php if(session('success')): ?>
                <div style="background:rgba(34,197,94,0.15);border:1px solid rgba(34,197,94,0.4);border-radius:8px;padding:10px 14px;margin-bottom:1rem;color:#86efac;font-size:.85rem;"><?php echo e(session('success')); ?></div>
                <?php endif; ?>
                <form action="<?php echo e(route('portal.login')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div style="position:relative; margin-bottom:0;">
                        <i class="fa fa-id-badge" style="position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:rgba(255,255,255,0.4);font-size:0.85rem;"></i>
                        <input type="text" name="staff_number" class="portal-input" style="padding-left:2.5rem;" placeholder="Staff Number (e.g. CHAZ-0001)" value="<?php echo e(old('staff_number')); ?>" required>
                    </div>
                    <div style="position:relative; margin-bottom:0;">
                        <i class="fa fa-lock" style="position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:rgba(255,255,255,0.4);font-size:0.85rem;"></i>
                        <input type="password" name="password" class="portal-input" style="padding-left:2.5rem;" placeholder="Password" required>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
                        <label style="display:flex;align-items:center;gap:0.5rem;font-size:0.8rem;color:rgba(255,255,255,0.6);cursor:pointer;">
                            <input type="checkbox" style="width:14px;height:14px;"> Remember me
                        </label>
                        <a href="#" style="font-size:0.8rem;color:var(--color-gold-lite);">Forgot password?</a>
                    </div>
                    <button type="submit" class="btn btn--gold" style="width:100%;justify-content:center;padding:0.85rem;">
                        <i class="fa fa-right-to-bracket"></i> Sign In
                    </button>
                </form>

                <hr style="border:none;border-top:1px solid rgba(255,255,255,0.1);margin:1.5rem 0;">

                <div style="text-align:center;">
                    <p style="font-size:0.78rem;color:rgba(255,255,255,0.45);margin-bottom:0.5rem;">Need access? Contact HR:</p>
                    <a href="mailto:hr@chaz.org.zm" style="font-size:0.85rem;font-weight:600;color:var(--color-gold-lite);">hr@chaz.org.zm</a>
                </div>
            </div>

        </div>
    </div>
</section>




<section class="section section--cream" style="padding:3rem 0;">
    <div class="container">
        <div class="section-header section-header--center" style="margin-bottom:2rem;">
            <span class="section-label">Quick Access</span>
            <h2 class="section-title">What do you need today?</h2>
        </div>
        <div class="quick-links-grid">
            <?php $__currentLoopData = $quickLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="#" class="quick-link-btn quick-link-btn--<?php echo e($link['color']); ?> fade-in">
                <div class="quick-link-btn__icon icon--<?php echo e($link['color']); ?>">
                    <i class="fa <?php echo e($link['icon']); ?>"></i>
                </div>
                <span class="quick-link-btn__label"><?php echo e($link['label']); ?></span>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>




<section class="section" id="about-portal">
    <div class="container">
        <div class="about-portal-grid">
        <div class="fade-in">
            <span class="section-label">About the Portal</span>
            <h2 class="section-title">What is the CHAZ Employee Portal?</h2>
            <p style="color:var(--color-slate-mid);line-height:1.85;margin-bottom:1.25rem;">
                The CHAZ Employee Portal is a <strong>digital self-service platform</strong> that gives every member of staff — from the Secretariat in Lusaka to remote rural health centres — a single, secure place to manage their employment information and access HR services.
            </p>
            <p style="color:var(--color-slate-mid);line-height:1.85;margin-bottom:1.5rem;">
                Rather than waiting days for HR to respond to routine requests, the portal empowers staff to <strong>act independently</strong> — viewing payslips, requesting leave, updating personal details, and accessing official documents at any time from any device.
            </p>
            <p style="color:var(--color-slate-mid);line-height:1.85;">
                For an organisation with <strong>162 member institutions across 10 provinces</strong>, the portal bridges the physical distance between staff and HR, enabling asynchronous collaboration that fits every working schedule and location.
            </p>
        </div>
        <div class="fade-in about-attrs-grid">
            <?php $__currentLoopData = [
                ['icon'=>'fa-server',       'label'=>'Cloud-Based',         'sub'=>'Access from any device'],
                ['icon'=>'fa-lock',          'label'=>'Secure',              'sub'=>'Encrypted & role-controlled'],
                ['icon'=>'fa-clock-rotate-left','label'=>'Always On',        'sub'=>'24/7 availability'],
                ['icon'=>'fa-users',         'label'=>'Organisation-wide',   'sub'=>'All provinces connected'],
                ['icon'=>'fa-sliders',       'label'=>'Self-Service',        'sub'=>'Manage tasks independently'],
                ['icon'=>'fa-mobile-screen', 'label'=>'Mobile Friendly',     'sub'=>'Works on smartphones'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="background:var(--color-cream);border-radius:var(--radius-md);padding:1.5rem;text-align:center;transition:all var(--transition);" onmouseover="this.style.boxShadow='var(--shadow-md)';this.style.transform='translateY(-3px)'" onmouseout="this.style.boxShadow='';this.style.transform=''">
                <div style="width:44px;height:44px;background:var(--color-forest);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;margin:0 auto 0.9rem;color:var(--color-gold);font-size:1.1rem;">
                    <i class="fa <?php echo e($item['icon']); ?>"></i>
                </div>
                <div style="font-weight:700;font-size:0.9rem;color:var(--color-forest);margin-bottom:0.2rem;"><?php echo e($item['label']); ?></div>
                <div style="font-size:0.77rem;color:var(--color-slate-mid);"><?php echo e($item['sub']); ?></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        </div>
    </div>
</section>




<section class="section section--cream" id="features">
    <div class="container">
        <div class="section-header section-header--center">
            <span class="section-label">Portal Features</span>
            <h2 class="section-title">Everything in One Place</h2>
            <p class="section-sub">The CHAZ Employee Portal brings together all the tools and resources your working life requires — no more juggling emails, paper forms, or phone calls to HR.</p>
        </div>

        <div class="features-grid">
            <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="feature-card feature-card--<?php echo e($f['color']); ?> fade-in">
                <div class="feature-card__icon icon--<?php echo e($f['color']); ?>">
                    <i class="fa <?php echo e($f['icon']); ?>"></i>
                </div>
                <h3 class="feature-card__title"><?php echo e($f['title']); ?></h3>
                <p class="feature-card__desc"><?php echo e($f['desc']); ?></p>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>




<section class="section" id="benefits">
    <div class="container">
        <div class="benefits-layout">
            <div class="fade-in">
                <span class="section-label">Why It Matters</span>
                <h2 class="section-title">Benefits for CHAZ Staff</h2>
                <p style="color:var(--color-slate-mid);line-height:1.85;margin-bottom:2rem;">
                    A well-designed employee portal has a measurable impact on how effectively our teams can focus on what matters most — delivering quality healthcare to Zambia's communities.
                </p>
                <div style="background:var(--color-cream);border-radius:var(--radius-md);padding:1.75rem;border-left:4px solid var(--color-gold);">
                    <p style="font-style:italic;color:var(--color-slate-mid);font-size:0.95rem;line-height:1.85;">
                        "When staff spend less time on administrative tasks, they spend more time on patients, programmes, and communities."
                    </p>
                    <p style="font-size:0.8rem;font-weight:600;color:var(--color-forest);margin-top:0.75rem;">— CHAZ HR Department</p>
                </div>
            </div>
            <div class="benefits-grid fade-in">
                <?php $__currentLoopData = $benefits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="benefit-item">
                    <div class="benefit-item__icon"><i class="fa <?php echo e($b['icon']); ?>"></i></div>
                    <div>
                        <h4 class="benefit-item__title"><?php echo e($b['title']); ?></h4>
                        <p class="benefit-item__desc"><?php echo e($b['desc']); ?></p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</section>




<section class="section" style="padding:4rem 0;background:var(--color-cream);">
    <div class="container">
        <div class="section-header section-header--center" style="margin-bottom:2.5rem;">
            <span class="section-label">Portal Insights</span>
            <h2 class="section-title">What the Portal Measures</h2>
            <p class="section-sub">The portal provides HR administrators with real-time analytics to support data-driven decisions about workforce management and engagement.</p>
        </div>
        <div class="metrics-insights-grid">
            <?php $__currentLoopData = [
                ['icon'=>'fa-users-viewfinder',  'title'=>'Employee Demographics',      'desc'=>'Track workforce composition by province, department, gender, and contract type.'],
                ['icon'=>'fa-arrow-trend-up',     'title'=>'Portal Adoption Rate',       'desc'=>'Monitor active users, login frequency, and feature engagement across the organisation.'],
                ['icon'=>'fa-book-open-reader',   'title'=>'Training Participation',     'desc'=>'Track enrolment, completion rates, and CPD hours for all training programmes.'],
                ['icon'=>'fa-file-magnifying-glass','title'=>'Document Access Frequency','desc'=>'Identify the most-accessed HR documents to optimise content and reduce help requests.'],
                ['icon'=>'fa-ticket',             'title'=>'Help Desk Requests',         'desc'=>'Analyse volumes of HR queries to identify systemic issues and improve processes.'],
                ['icon'=>'fa-star-half-stroke',   'title'=>'Satisfaction Ratings',       'desc'=>'Collect staff feedback on portal usability and HR service quality over time.'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metric): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="background:white;border:1px solid var(--color-border);border-radius:var(--radius-md);padding:1.75rem;transition:all var(--transition);" class="fade-in" onmouseover="this.style.boxShadow='var(--shadow-md)';this.style.transform='translateY(-4px)'" onmouseout="this.style.boxShadow='';this.style.transform=''">
                <div style="width:44px;height:44px;background:rgba(27,67,50,0.08);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;color:var(--color-forest);font-size:1.1rem;margin-bottom:1rem;">
                    <i class="fa <?php echo e($metric['icon']); ?>"></i>
                </div>
                <h4 style="font-family:var(--font-display);font-size:1rem;font-weight:700;color:var(--color-forest);margin-bottom:0.5rem;"><?php echo e($metric['title']); ?></h4>
                <p style="font-size:0.83rem;color:var(--color-slate-mid);line-height:1.7;"><?php echo e($metric['desc']); ?></p>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>




<section class="section section--forest" id="security">
    <div class="container">
        <div class="security-layout">
            <div class="fade-in">
                <span class="section-label" style="color:var(--color-gold);">Security & Privacy</span>
                <h2 class="section-title">Your Data is Protected</h2>
                <p class="section-sub">The CHAZ Employee Portal is built with enterprise-grade security to protect sensitive staff information, payroll data, and medical records in compliance with Zambia's data protection framework.</p>
                <a href="<?php echo e(route('contact')); ?>" class="btn btn--gold" style="margin-top:2rem;">
                    <i class="fa fa-envelope"></i> Report a Security Issue
                </a>
            </div>
            <div class="security-grid fade-in">
                <?php $__currentLoopData = [
                    ['icon'=>'fa-lock',            'title'=>'End-to-End Encryption',      'desc'=>'All data transmitted between your device and our servers is encrypted using TLS 1.3.'],
                    ['icon'=>'fa-key',             'title'=>'Secure Authentication',      'desc'=>'Two-factor authentication (2FA) and strong password policies protect every account.'],
                    ['icon'=>'fa-user-shield',     'title'=>'Role-Based Access',          'desc'=>'Staff only see information relevant to their role. Sensitive data is administrator-only.'],
                    ['icon'=>'fa-hard-drive',      'title'=>'Secure Data Storage',        'desc'=>'All employee records are stored on encrypted servers with regular automated backups.'],
                    ['icon'=>'fa-rotate',          'title'=>'Regular Security Audits',    'desc'=>'Scheduled penetration testing and security reviews ensure the portal stays hardened.'],
                    ['icon'=>'fa-eye-slash',       'title'=>'Privacy by Design',          'desc'=>'The portal is built to minimise data collection and comply with applicable privacy laws.'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="security-item">
                    <div class="security-item__icon"><i class="fa <?php echo e($sec['icon']); ?>"></i></div>
                    <div>
                        <div class="security-item__title"><?php echo e($sec['title']); ?></div>
                        <div class="security-item__desc"><?php echo e($sec['desc']); ?></div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</section>




<section class="section" id="get-started">
    <div class="container">
        <div class="section-header section-header--center">
            <span class="section-label">Onboarding</span>
            <h2 class="section-title">Getting Started is Simple</h2>
            <p class="section-sub">New to the portal? Follow these steps to get up and running in minutes.</p>
        </div>

        <div class="steps-grid">
            
            <div class="steps-connector"></div>

            <?php $__currentLoopData = [
                ['num'=>'1','icon'=>'fa-envelope','title'=>'Request Access','desc'=>'Email hr@chaz.org.zm with your staff ID and department to request portal credentials.'],
                ['num'=>'2','icon'=>'fa-key',     'title'=>'Set Your Password','desc'=>'You will receive an activation email. Click the link and create a strong password.'],
                ['num'=>'3','icon'=>'fa-sliders', 'title'=>'Set Up Profile','desc'=>'Complete your employee profile, add a photo, and verify your personal details are correct.'],
                ['num'=>'4','icon'=>'fa-rocket',  'title'=>'Explore & Use','desc'=>'You are ready. Explore your dashboard, submit a leave request, or download your latest payslip.'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="fade-in" style="text-align:center;position:relative;z-index:1;">
                <div style="width:56px;height:56px;background:var(--color-forest);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;border:4px solid var(--color-cream);box-shadow:0 0 0 3px var(--color-forest);">
                    <i class="fa <?php echo e($step['icon']); ?>" style="color:var(--color-gold);font-size:1.1rem;"></i>
                </div>
                <div style="font-size:0.7rem;font-weight:700;letter-spacing:0.1em;color:var(--color-gold);text-transform:uppercase;margin-bottom:0.4rem;">Step <?php echo e($step['num']); ?></div>
                <h4 style="font-family:var(--font-display);font-size:1rem;font-weight:700;color:var(--color-forest);margin-bottom:0.5rem;"><?php echo e($step['title']); ?></h4>
                <p style="font-size:0.82rem;color:var(--color-slate-mid);line-height:1.7;"><?php echo e($step['desc']); ?></p>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div style="max-width:760px;margin:0 auto;" class="fade-in">
            <h3 style="font-family:var(--font-display);font-size:1.25rem;font-weight:700;color:var(--color-forest);text-align:center;margin-bottom:1.75rem;">Frequently Asked Questions</h3>
            <?php $__currentLoopData = [
                ['q'=>'Who can access the employee portal?','a'=>'All active CHAZ staff — including Secretariat employees, provincial office staff, and employees at member health institutions — are eligible for portal access. Contact your HR representative or email hr@chaz.org.zm to request credentials.'],
                ['q'=>'What if I forget my password?','a'=>'Click the "Forgot password?" link on the login screen. A password reset link will be sent to your registered staff email address within a few minutes.'],
                ['q'=>'Can I access the portal on my mobile phone?','a'=>'Yes. The portal is fully responsive and works on all modern smartphones and tablets. A dedicated mobile app is under development.'],
                ['q'=>'Is my personal information secure on the portal?','a'=>'Yes. All data is encrypted in transit and at rest. Access is controlled by role-based permissions, meaning staff only see information relevant to their position.'],
                ['q'=>'Who do I contact if I experience a technical issue?','a'=>'Raise a support ticket via the Help Desk section within the portal, or send an email to ict@chaz.org.zm. Include your staff ID and a description of the issue.'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="border:1px solid var(--color-border);border-radius:var(--radius-md);margin-bottom:0.75rem;overflow:hidden;">
                <button onclick="toggleFaq(this)" style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:1.1rem 1.5rem;background:white;border:none;cursor:pointer;font-family:var(--font-body);font-size:0.9rem;font-weight:600;color:var(--color-forest);text-align:left;gap:1rem;">
                    <?php echo e($faq['q']); ?>

                    <i class="fa fa-chevron-down" style="flex-shrink:0;font-size:0.75rem;color:var(--color-slate-mid);transition:transform 0.3s;"></i>
                </button>
                <div style="display:none;padding:0 1.5rem 1.25rem;font-size:0.875rem;color:var(--color-slate-mid);line-height:1.8;background:white;">
                    <?php echo e($faq['a']); ?>

                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>




<section class="cta-banner">
    <div class="container">
        <h2 class="cta-banner__title">Ready to Access Your Portal?</h2>
        <p class="cta-banner__sub">Sign in now or contact HR to get your credentials. Your entire CHAZ working life in one secure place.</p>
        <div class="cta-banner__actions">
            <a href="#portal-login" class="btn btn--gold btn--lg">
                <i class="fa fa-right-to-bracket"></i> Sign In Now
            </a>
            <a href="<?php echo e(route('contact')); ?>" class="btn btn--outline-white btn--lg">
                <i class="fa fa-envelope"></i> Contact HR
            </a>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function toggleFaq(btn) {
    const answer = btn.nextElementSibling;
    const icon   = btn.querySelector('i');
    const isOpen = answer.style.display === 'block';

    // Close all
    document.querySelectorAll('.faq-answer').forEach(a => a.style.display = 'none');
    document.querySelectorAll('.faq-icon').forEach(i => i.style.transform = '');

    if (!isOpen) {
        answer.style.display = 'block';
        icon.style.transform = 'rotate(180deg)';
    }

    // Add classes for targeted reset
    answer.classList.add('faq-answer');
    icon.classList.add('faq-icon');
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/employee-portal.blade.php ENDPATH**/ ?>