<?php $__env->startSection('title', 'News & Updates — CHAZ'); ?>

<?php $__env->startSection('content'); ?>

<div class="page-hero">
    <div class="container">
        <div class="page-hero__eyebrow"><span>✛</span> News</div>
        <h1 class="page-hero__title">News &amp; Updates</h1>
        <p class="page-hero__sub">Stay up to date with the latest from CHAZ — programme outcomes, advocacy wins, partnerships, and health stories from across Zambia.</p>
        <div class="page-hero__breadcrumb">
            <a href="<?php echo e(route('home')); ?>">Home</a> <i class="fa fa-chevron-right" style="font-size:0.65rem"></i> News
        </div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="news-grid">
            <?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="news-card fade-in">
                <div class="news-card__img">
                    <div class="news-card__img-placeholder"><i class="fa fa-newspaper"></i></div>
                    <span class="news-card__tag"><?php echo e($article['tag']); ?></span>
                </div>
                <div class="news-card__body">
                    <div class="news-card__date"><i class="fa fa-calendar"></i> <?php echo e($article->published_at->format('F j, Y')); ?></div>
                    <h3 class="news-card__title"><?php echo e($article->title); ?></h3>
                    <p class="news-card__excerpt"><?php echo e($article->excerpt); ?></p>
                    <a href="<?php echo e(route('news.show', $article->slug)); ?>" class="news-card__link">
                        Read Full Story <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/news/index.blade.php ENDPATH**/ ?>