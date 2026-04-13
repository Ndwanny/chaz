<?php $__env->startSection('title', 'Audit Log'); ?>
<?php $__env->startSection('page-title', 'Reports'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <div class="page-title">Audit Log</div>
        <div class="page-subtitle">System activity trail</div>
    </div>
    <a href="<?php echo e(route('admin.reports.index')); ?>" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Reports</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>When</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Record</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td style="font-size:.8rem;white-space:nowrap;color:var(--slate-mid);">
                    <?php echo e($log->created_at?->format('d M Y H:i')); ?>

                </td>
                <td style="font-size:.875rem;"><?php echo e($log->admin->name ?? '—'); ?></td>
                <td>
                    <code style="font-size:.78rem;background:var(--bg-alt);padding:2px 6px;border-radius:4px;">
                        <?php echo e(str_replace('_', ' ', $log->action)); ?>

                    </code>
                </td>
                <td style="font-size:.82rem;color:var(--slate-mid);">
                    <?php if($log->model_type): ?>
                    <?php echo e(class_basename($log->model_type)); ?>

                    <?php if($log->model_id): ?> <span style="opacity:.6;">#<?php echo e($log->model_id); ?></span> <?php endif; ?>
                    <?php else: ?>
                    —
                    <?php endif; ?>
                </td>
                <td style="font-size:.78rem;color:var(--slate-mid);"><?php echo e($log->ip_address ?? '—'); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="5" style="text-align:center;padding:2.5rem;color:var(--slate-mid);">
                    <i class="fas fa-scroll" style="font-size:1.5rem;opacity:.25;display:block;margin-bottom:.5rem;"></i>
                    No audit log entries.
                </td>
            </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-body"><?php echo e($logs->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/reports/audit.blade.php ENDPATH**/ ?>