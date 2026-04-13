<?php $__env->startSection('title', 'Payroll'); ?>
<?php $__env->startSection('breadcrumb', 'Payroll / Periods'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div><div class="page-title">Payroll Periods</div></div>
    <?php if(admin_can('manage_payroll')): ?>
    <a href="<?php echo e(route('admin.payroll.periods.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> New Period</a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Period</th><th>Payment Date</th><th>Runs</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <div style="font-weight:600;"><?php echo e($period->name); ?></div>
                    <div style="font-size:.75rem;color:var(--text-muted);"><?php echo e($period->start_date?->format('d M')); ?> — <?php echo e($period->end_date?->format('d M Y')); ?></div>
                </td>
                <td><?php echo e($period->payment_date?->format('d M Y')); ?></td>
                <td><?php echo e($period->payroll_runs_count); ?></td>
                <td><span class="badge badge-<?php echo e($period->isOpen() ? 'green' : 'grey'); ?>"><?php echo e(ucfirst($period->status)); ?></span></td>
                <td>
                    <?php if(admin_can('manage_payroll')): ?>
                    <?php if($period->isOpen()): ?>
                    <form method="POST" action="<?php echo e(route('admin.payroll.run.store', $period)); ?>" style="display:inline;" onsubmit="return confirm('Run payroll for <?php echo e($period->name); ?>? This will generate payslips for all active employees.')">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-play"></i> Run Payroll</button>
                    </form>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if($period->payroll_runs_count > 0): ?>
                    <a href="<?php echo e(route('admin.payroll.index')); ?>?period=<?php echo e($period->id); ?>" class="btn btn-sm btn-outline"><i class="fas fa-eye"></i> View Runs</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="5" style="text-align:center;color:var(--text-muted);">No payroll periods created yet.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;"><?php echo e($periods->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/payroll/index.blade.php ENDPATH**/ ?>