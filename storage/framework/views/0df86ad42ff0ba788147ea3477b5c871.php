<?php $__env->startSection('title', 'Tenders — CHAZ'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-hero">
    <div class="container">
        <div class="page-hero__eyebrow">Procurement</div>
        <h1 class="page-hero__title">Tenders</h1>
        <p class="page-hero__sub">CHAZ invites eligible suppliers and service providers to submit bids for goods and services in support of our health programmes.</p>
        <div class="page-hero__breadcrumb"><a href="<?php echo e(route('home')); ?>">Home</a> / Tenders</div>
    </div>
</div>
<section class="section">
    <div class="container">
        <div style="display:flex;gap:1rem;margin-bottom:2.5rem;flex-wrap:wrap;">
            <a href="<?php echo e(route('tenders')); ?>" class="btn btn--forest btn--sm">Active Tenders</a>
            <a href="<?php echo e(route('tenders.sub-recipient-adverts')); ?>" class="btn btn--outline btn--sm">Sub-Recipient Adverts</a>
        </div>

        <div style="background:rgba(201,168,76,0.08);border:1px solid rgba(201,168,76,0.25);border-radius:var(--radius-md);padding:1.25rem 1.5rem;margin-bottom:2.5rem;display:flex;gap:1rem;align-items:flex-start;">
            <i class="fa fa-circle-info" style="color:var(--color-gold);margin-top:0.2rem;flex-shrink:0;"></i>
            <p style="font-size:0.875rem;color:var(--color-slate-mid);line-height:1.7;">All procurement at CHAZ follows the Public Procurement Act of Zambia and donor procurement guidelines. Tender documents must be submitted in sealed envelopes to the CHAZ Secretariat, Plot 4669, Mosi-o-Tunya Road, Lusaka before the stated deadline.</p>
        </div>

        <div class="resource-list">
            <?php $__currentLoopData = $tenders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="resource-item fade-in" style="flex-direction:column;align-items:flex-start;gap:1rem;">
                <div style="display:flex;gap:1.25rem;align-items:flex-start;width:100%;">
                    <div class="resource-item__icon">
                        <i class="fa <?php echo e($t->category === 'Construction' ? 'fa-hammer' : ($t->category === 'Pharmaceuticals' ? 'fa-pills' : ($t->category === 'Information Technology' ? 'fa-laptop' : 'fa-box'))); ?>"></i>
                    </div>
                    <div class="resource-item__body">
                        <div style="display:flex;gap:0.75rem;align-items:center;margin-bottom:0.4rem;flex-wrap:wrap;">
                            <span style="font-size:0.72rem;font-weight:700;color:var(--color-slate-mid);font-family:monospace;"><?php echo e($t->reference); ?></span>
                            <span class="badge <?php echo e($t->status === 'open' ? 'badge--green' : ($t->status === 'awarded' ? 'badge--blue' : 'badge--red')); ?>">
                                <?php echo e(ucfirst($t->status)); ?>

                            </span>
                            <span class="badge badge--gold"><?php echo e($t->category); ?></span>
                        </div>
                        <div class="resource-item__title" style="margin-bottom:0.5rem;"><?php echo e($t->title); ?></div>
                        <p style="font-size:0.85rem;color:var(--color-slate-mid);line-height:1.7;margin-bottom:0.75rem;"><?php echo e($t->description); ?></p>
                        <div class="resource-item__meta">
                            <span><i class="fa fa-calendar-plus"></i> Issued: <?php echo e($t->issued_at->format('M j, Y')); ?></span>
                            <span><i class="fa fa-calendar-xmark"></i> Deadline: <?php echo e($t->deadline->format('M j, Y')); ?></span>
                        </div>
                    </div>
                    <?php if($t->status === 'open' && $t->document): ?>
                    <div style="flex-shrink:0;">
                        <a href="<?php echo e(asset('storage/' . $t->document)); ?>" class="btn btn--forest btn--sm"><i class="fa fa-download"></i> Tender Docs</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/tenders/index.blade.php ENDPATH**/ ?>