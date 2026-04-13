<?php $__env->startSection('title', 'Announcements'); ?>
<?php $__env->startSection('breadcrumb', 'Communications / Announcements'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div><div class="page-title">Announcements</div><div class="page-subtitle"><?php echo e($announcements->total()); ?> total</div></div>
    <?php if(admin_can('manage_content') || admin_can('manage_comms')): ?>
    <a href="<?php echo e(route('admin.announcements.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> New Announcement</a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Title</th><th>Category</th><th>Priority</th><th>Audience</th><th>Published</th><th>Expires</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ann): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <div style="font-weight:600;"><?php echo e($ann->title); ?></div>
                    <div style="font-size:.75rem;color:var(--text-muted);">By <?php echo e($ann->createdBy->name ?? '—'); ?></div>
                </td>
                <td><span class="badge badge-blue"><?php echo e(ucfirst($ann->category)); ?></span></td>
                <td><span class="badge badge-<?php echo e($ann->priority_color); ?>"><?php echo e(ucfirst($ann->priority)); ?></span></td>
                <td><?php echo e(ucfirst($ann->target_audience)); ?></td>
                <td><?php echo e($ann->published_at?->format('d M Y') ?? '—'); ?></td>
                <td><?php echo e($ann->expires_at?->format('d M Y') ?? 'Never'); ?></td>
                <td>
                    <?php if(!$ann->is_published): ?>
                        <span class="badge badge-grey">Draft</span>
                    <?php elseif($ann->isExpired()): ?>
                        <span class="badge badge-red">Expired</span>
                    <?php else: ?>
                        <span class="badge badge-green">Live</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if(admin_can('manage_content') || admin_can('manage_comms')): ?>
                    <a href="<?php echo e(route('admin.announcements.edit', $ann)); ?>" class="btn btn-xs btn-outline"><i class="fas fa-pen"></i></a>
                    <form method="POST" action="<?php echo e(route('admin.announcements.destroy', $ann)); ?>" style="display:inline;" onsubmit="return confirm('Delete this announcement?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="8" style="text-align:center;color:var(--text-muted);">No announcements yet.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;"><?php echo e($announcements->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/announcements/index.blade.php ENDPATH**/ ?>