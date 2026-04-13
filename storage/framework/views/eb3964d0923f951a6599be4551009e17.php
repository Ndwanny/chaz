<?php $__env->startSection('title', $news ? 'Edit Article' : 'New Article'); ?>
<?php $__env->startSection('page-title', $news ? 'Edit Article' : 'New Article'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <div class="breadcrumb">
            <a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a> /
            <a href="<?php echo e(route('admin.news.index')); ?>">News</a> /
            <?php echo e($news ? 'Edit' : 'New Article'); ?>

        </div>
        <h2><?php echo e($news ? 'Edit: ' . Str::limit($news->title, 50) : 'Create New Article'); ?></h2>
    </div>
    <a href="<?php echo e(route('admin.news.index')); ?>" class="btn btn-outline"><i class="fa fa-arrow-left"></i> Back</a>
</div>

<form action="<?php echo e($action); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php if($news): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

    <div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;align-items:flex-start;">

        
        <div style="display:flex;flex-direction:column;gap:1.5rem;">
            <div class="card">
                <div class="card-header"><h3>Article Content</h3></div>
                <div class="card-body">
                    <div class="form-grid">
                        <div class="form-group span-2">
                            <label class="form-label">Title <span>*</span></label>
                            <input type="text" name="title" class="form-control" value="<?php echo e(old('title', $news?->title)); ?>" required placeholder="Article headline">
                            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group span-2">
                            <label class="form-label">Excerpt <span>*</span></label>
                            <textarea name="excerpt" class="form-control" rows="3" required placeholder="Short summary shown on news listing pages..."><?php echo e(old('excerpt', $news?->excerpt)); ?></textarea>
                            <?php $__errorArgs = ['excerpt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group span-2">
                            <label class="form-label">Full Content <span>*</span></label>
                            <textarea name="content" class="form-control" rows="14" required placeholder="Full article body..."><?php echo e(old('content', $news?->content)); ?></textarea>
                            <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div style="display:flex;flex-direction:column;gap:1.5rem;">
            <div class="card">
                <div class="card-header"><h3>Publishing</h3></div>
                <div class="card-body">
                    <div class="form-group" style="margin-bottom:1.25rem;">
                        <label class="form-label">Status <span>*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="draft"     <?php echo e(old('status', $news?->status) === 'draft'     ? 'selected' : ''); ?>>Draft</option>
                            <option value="published" <?php echo e(old('status', $news?->status) === 'published' ? 'selected' : ''); ?>>Published</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom:1.5rem;">
                        <label class="form-label">Publish Date</label>
                        <input type="datetime-local" name="published_at" class="form-control"
                               value="<?php echo e(old('published_at', $news?->published_at?->format('Y-m-d\TH:i'))); ?>">
                        <div class="form-hint">Leave blank to auto-set on publish.</div>
                    </div>
                    <button type="submit" class="btn btn-forest" style="width:100%;justify-content:center;">
                        <i class="fa fa-<?php echo e($news ? 'floppy-disk' : 'plus'); ?>"></i>
                        <?php echo e($news ? 'Save Changes' : 'Create Article'); ?>

                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h3>Metadata</h3></div>
                <div class="card-body">
                    <div class="form-group" style="margin-bottom:1.25rem;">
                        <label class="form-label">Category Tag <span>*</span></label>
                        <input type="text" name="tag" class="form-control" value="<?php echo e(old('tag', $news?->tag)); ?>" required list="tag-suggestions" placeholder="e.g. HIV & AIDS">
                        <datalist id="tag-suggestions">
                            <?php $__currentLoopData = ['HIV & AIDS','Tuberculosis','Malaria','Immunisation','Maternal Health','Community Health','Advocacy','Partnerships','Events','General']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($t); ?>">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Author <span>*</span></label>
                        <input type="text" name="author" class="form-control" value="<?php echo e(old('author', $news?->author ?? 'CHAZ Communications')); ?>" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/news/form.blade.php ENDPATH**/ ?>