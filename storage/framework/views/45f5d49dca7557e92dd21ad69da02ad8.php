<?php $__env->startSection('title', isset($announcement) ? 'Edit Announcement' : 'New Announcement'); ?>
<?php $__env->startSection('page-title', 'Announcements'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <div class="page-title"><?php echo e(isset($announcement) ? 'Edit Announcement' : 'New Announcement'); ?></div>
        <div class="page-subtitle"><?php echo e(isset($announcement) ? 'Update this announcement' : 'Post a new announcement to staff'); ?></div>
    </div>
    <a href="<?php echo e(route('admin.announcements.index')); ?>" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<?php if($errors->any()): ?>
<div class="alert alert-danger">
    <ul style="margin:0;padding-left:1.2rem;">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php endif; ?>

<form method="POST"
      action="<?php echo e(isset($announcement) ? route('admin.announcements.update', $announcement) : route('admin.announcements.store')); ?>"
      enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php if(isset($announcement)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

    <div style="display:grid;grid-template-columns:1fr 320px;gap:1.25rem;align-items:start;">

        
        <div class="card">
            <div class="card-header">
                <span class="card-title"><i class="fas fa-bullhorn" style="color:var(--forest);margin-right:.4rem;"></i> Announcement Content</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="<?php echo e(old('title', $announcement->title ?? '')); ?>" required maxlength="200" placeholder="Announcement headline…">
                </div>

                <div class="form-group">
                    <label class="form-label">Content <span class="text-danger">*</span></label>
                    <textarea name="content" class="form-control" rows="10" required placeholder="Full announcement text…"><?php echo e(old('content', $announcement->content ?? '')); ?></textarea>
                </div>

                <?php if(!isset($announcement)): ?>
                <div class="form-group">
                    <label class="form-label">Attachment <span style="font-size:.78rem;color:var(--slate-mid);">(PDF, DOCX, JPG, PNG — max 10 MB)</span></label>
                    <input type="file" name="attachment" class="form-control" accept=".pdf,.docx,.jpg,.jpeg,.png">
                </div>
                <?php elseif($announcement->attachment): ?>
                <div class="form-group">
                    <label class="form-label">Current Attachment</label>
                    <div style="font-size:.85rem;padding:.5rem .75rem;background:var(--bg);border-radius:6px;">
                        <i class="fas fa-paperclip"></i> <?php echo e(basename($announcement->attachment)); ?>

                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div style="display:flex;flex-direction:column;gap:1.25rem;">

            <div class="card">
                <div class="card-header">
                    <span class="card-title"><i class="fas fa-sliders" style="color:var(--forest);margin-right:.4rem;"></i> Settings</span>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category" class="form-control" required>
                            <?php $__currentLoopData = ['general' => 'General', 'hr' => 'HR', 'finance' => 'Finance', 'it' => 'IT', 'operations' => 'Operations', 'event' => 'Event', 'urgent' => 'Urgent']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($val); ?>" <?php echo e(old('category', $announcement->category ?? 'general') === $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Priority <span class="text-danger">*</span></label>
                        <select name="priority" class="form-control" required>
                            <?php $__currentLoopData = ['low' => 'Low', 'normal' => 'Normal', 'high' => 'High', 'urgent' => 'Urgent']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($val); ?>" <?php echo e(old('priority', $announcement->priority ?? 'normal') === $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Target Audience <span class="text-danger">*</span></label>
                        <select name="target_audience" class="form-control" id="target_audience" required>
                            <?php $__currentLoopData = ['all' => 'All Staff', 'staff' => 'Staff Only', 'management' => 'Management', 'department' => 'Specific Department']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($val); ?>" <?php echo e(old('target_audience', $announcement->target_audience ?? 'all') === $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="form-group" id="department_row" style="<?php echo e(old('target_audience', $announcement->target_audience ?? 'all') === 'department' ? '' : 'display:none;'); ?>">
                        <label class="form-label">Department</label>
                        <select name="target_id" class="form-control">
                            <option value="">— Select Department —</option>
                            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($dept->id); ?>" <?php echo e(old('target_id', $announcement->target_id ?? '') == $dept->id ? 'selected' : ''); ?>><?php echo e($dept->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Expiry Date <span style="font-size:.78rem;color:var(--slate-mid);">(optional)</span></label>
                        <input type="datetime-local" name="expires_at" class="form-control"
                               value="<?php echo e(old('expires_at', $announcement?->expires_at?->format('Y-m-d\TH:i') ?? '')); ?>">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="form-group" style="margin-bottom:1rem;">
                        <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;font-weight:500;">
                            <input type="checkbox" name="is_published" value="1"
                                   <?php echo e(old('is_published', $announcement->is_published ?? false) ? 'checked' : ''); ?>>
                            Publish immediately
                        </label>
                        <div style="font-size:.76rem;color:var(--slate-mid);margin-top:.25rem;margin-left:1.25rem;">
                            Unchecked saves as draft
                        </div>
                    </div>

                    <div style="display:flex;gap:.75rem;">
                        <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center;">
                            <i class="fas fa-save"></i> <?php echo e(isset($announcement) ? 'Update' : 'Save'); ?>

                        </button>
                        <a href="<?php echo e(route('admin.announcements.index')); ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

<?php $__env->startPush('styles'); ?>
<style>
@media (max-width: 900px) {
    form > div[style*="grid-template-columns"] { grid-template-columns: 1fr !important; }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('target_audience').addEventListener('change', function () {
    document.getElementById('department_row').style.display = this.value === 'department' ? '' : 'none';
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/announcements/form.blade.php ENDPATH**/ ?>