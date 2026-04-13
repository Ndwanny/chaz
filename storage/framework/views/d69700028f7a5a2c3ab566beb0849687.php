<?php $__env->startSection('title', 'Gallery — CHAZ'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-hero">
    <div class="container">
        <div class="page-hero__eyebrow">Media</div>
        <h1 class="page-hero__title">Photo Gallery</h1>
        <p class="page-hero__sub">Images from CHAZ member institutions, programme activities, community outreach, and key events across Zambia.</p>
        <div class="page-hero__breadcrumb"><a href="<?php echo e(route('home')); ?>">Home</a> / Gallery</div>
    </div>
</div>
<section class="section">
    <div class="container">
        <?php
        $categories = ['All','HIV & AIDS','Malaria','Immunisation','Maternal Health','TB','Community'];
        $items = [
            ['cat'=>'Immunisation','label'=>'Vaccination Campaign — Eastern Province','span'=>'wide'],
            ['cat'=>'HIV & AIDS','label'=>'ART Clinic — Macha Mission Hospital','span'=>'tall'],
            ['cat'=>'Malaria','label'=>'Bed Net Distribution — Western Province','span'=>''],
            ['cat'=>'Maternal Health','label'=>'Antenatal Care — Mwandi Mission','span'=>''],
            ['cat'=>'TB','label'=>'TB Screening — Ndola','span'=>''],
            ['cat'=>'Community','label'=>'Community Health Workers Training','span'=>'wide'],
            ['cat'=>'Immunisation','label'=>'Child Health Week — Lusaka','span'=>''],
            ['cat'=>'HIV & AIDS','label'=>'PMTCT Counselling Session','span'=>'tall'],
            ['cat'=>'Malaria','label'=>'Rapid Diagnostic Testing','span'=>''],
        ];
        $gradients = [
            'background:linear-gradient(135deg,#1B4332,#40916C)',
            'background:linear-gradient(135deg,#2D6A4F,#52B788)',
            'background:linear-gradient(135deg,#40916C,#74C69D)',
            'background:linear-gradient(135deg,#1B4332,#2D6A4F)',
            'background:linear-gradient(135deg,#C9A84C,#E9C46A)',
            'background:linear-gradient(135deg,#0F2A1E,#1B4332)',
            'background:linear-gradient(135deg,#2D6A4F,#C9A84C)',
            'background:linear-gradient(135deg,#40916C,#1B4332)',
            'background:linear-gradient(135deg,#C9A84C,#40916C)',
        ];
        ?>

        <div style="display:flex;gap:0.75rem;flex-wrap:wrap;margin-bottom:2rem;">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button class="filter-btn <?php echo e($loop->first ? 'active' : ''); ?>"><?php echo e($cat); ?></button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="gallery-grid">
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="gallery-item <?php echo e($item['span'] === 'wide' ? 'gallery-item--wide' : ($item['span'] === 'tall' ? 'gallery-item--tall' : '')); ?>" style="<?php echo e($gradients[$i]); ?>">
                <div class="gallery-item__placeholder">
                    <i class="fa fa-image"></i>
                    <span style="font-size:0.75rem;padding:0 1rem;text-align:center;"><?php echo e($item['label']); ?></span>
                </div>
                <div class="gallery-item__overlay">
                    <i class="fa fa-magnifying-glass-plus"></i>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <p style="text-align:center;margin-top:2.5rem;color:var(--color-slate-mid);font-size:0.875rem;">
            Photos shown are representative. To share images from your CHAZ member institution, contact <a href="mailto:communications@chaz.org.zm" style="color:var(--color-forest);">communications@chaz.org.zm</a>
        </p>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/gallery.blade.php ENDPATH**/ ?>