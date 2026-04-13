<?php $__env->startSection('title', 'Publications — CHAZ'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-hero">
    <div class="container">
        <div class="page-hero__eyebrow">Downloads</div>
        <h1 class="page-hero__title">Publications</h1>
        <p class="page-hero__sub">Programme reports, policy briefs, strategic plans, evaluation reports and training manuals.</p>
        <div class="page-hero__breadcrumb"><a href="<?php echo e(route('home')); ?>">Home</a> / <a href="<?php echo e(route('downloads')); ?>">Downloads</a> / Publications</div>
    </div>
</div>
<section class="section">
    <div class="container">
        <div class="resource-list">
            <?php $__currentLoopData = $publications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="resource-item fade-in">
                <div class="resource-item__icon"><i class="fa fa-file-pdf"></i></div>
                <div class="resource-item__body">
                    <div class="resource-item__title"><?php echo e($pub->title); ?></div>
                    <div class="resource-item__meta">
                        <span><i class="fa fa-calendar"></i> <?php echo e($pub->year); ?></span>
                        <span><i class="fa fa-tag"></i> <?php echo e($pub->type); ?></span>
                        <?php if($pub->pages): ?><span><i class="fa fa-file"></i> <?php echo e($pub->pages); ?> pages</span><?php endif; ?>
                        <?php if($pub->file_size): ?><span><i class="fa fa-weight-hanging"></i> <?php echo e($pub->file_size); ?></span><?php endif; ?>
                    </div>
                </div>
                <div class="resource-item__actions">
                    <a href="<?php echo e($pub->file_path ? asset('storage/' . $pub->file_path) : '#'); ?>" class="btn btn--forest btn--sm"><i class="fa fa-download"></i> Download</a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/downloads/publications.blade.php ENDPATH**/ ?>