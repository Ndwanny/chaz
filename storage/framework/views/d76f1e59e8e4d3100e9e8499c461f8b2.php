<?php $__env->startSection('title', 'Board of Trustees — CHAZ'); ?>

<?php $__env->startSection('content'); ?>

<div class="page-hero">
    <div class="container">
        <div class="page-hero__eyebrow"><span>✛</span> About Us</div>
        <h1 class="page-hero__title">Board of Trustees</h1>
        <p class="page-hero__sub">CHAZ is governed by a distinguished Board of Trustees drawn from across denominational bodies, bringing expertise in medicine, nursing, finance, law, and governance.</p>
        <div class="page-hero__breadcrumb">
            <a href="<?php echo e(route('home')); ?>">Home</a> <i class="fa fa-chevron-right" style="font-size:0.65rem"></i>
            <a href="<?php echo e(route('about')); ?>">About</a> <i class="fa fa-chevron-right" style="font-size:0.65rem"></i>
            Board of Trustees
        </div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="section-header section-header--center">
            <span class="section-label">Governance</span>
            <h2 class="section-title">Our Board</h2>
            <p class="section-sub">The General Council — comprising all 162 CHAZ member institutions — is the supreme governing body. The Board is elected by the Representative Churches Forum (RCF) from 17 church mother bodies.</p>
        </div>

        <div class="board-grid">
            <?php $__currentLoopData = $trustees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="board-card fade-in">
                <div class="board-card__avatar"><?php echo e($t['initials']); ?></div>
                <div class="board-card__name"><?php echo e($t['name']); ?></div>
                <div class="board-card__role"><?php echo e($t['role']); ?></div>
                <div class="board-card__org"><?php echo e($t['org']); ?></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div style="background:var(--color-cream); border-radius:var(--radius-md); padding:2.5rem; margin-top:3rem; text-align:center;" class="fade-in">
            <h3 style="font-family:var(--font-display);font-size:1.25rem;color:var(--color-forest);margin-bottom:0.75rem;">Advisory Board Committees</h3>
            <p style="color:var(--color-slate-mid);font-size:0.9rem;margin-bottom:1.25rem;">The Board is supported by four Advisory Committees with specialist expertise across:</p>
            <div style="display:flex; flex-wrap:wrap; gap:0.75rem; justify-content:center;">
                <?php $__currentLoopData = ['Medical & Clinical Affairs', 'Pharmacy & Supply Chain', 'Finance & Audit', 'Human Resources & Governance']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $com): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span class="badge badge--green" style="font-size:0.8rem;padding:0.4rem 1rem;"><?php echo e($com); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/about-board.blade.php ENDPATH**/ ?>