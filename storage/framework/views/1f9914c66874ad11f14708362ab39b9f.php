<?php $__env->startSection('title', 'Budgets'); ?>
<?php $__env->startSection('breadcrumb', 'Finance / Budgets'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <div class="page-title">Budgets</div>
        <?php if($activePeriod): ?><div class="page-subtitle"><?php echo e($activePeriod->name); ?></div><?php endif; ?>
    </div>
    <div style="display:flex;gap:8px;">
        <a href="<?php echo e(route('admin.finance.budgets.periods')); ?>" class="btn btn-outline"><i class="fas fa-calendar-alt"></i> Periods</a>
        <?php if(admin_can('manage_finance')): ?>
        <a href="<?php echo e(route('admin.finance.budgets.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> New Budget</a>
        <?php endif; ?>
    </div>
</div>


<?php if($periods->count() > 1): ?>
<div class="card" style="margin-bottom:16px;">
    <div class="card-body">
        <form method="GET" style="display:flex;gap:12px;align-items:flex-end;">
            <div>
                <label style="font-size:.78rem;font-weight:600;">Period</label>
                <select name="period_id" class="form-control" onchange="this.form.submit()">
                    <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($p->id); ?>" <?php echo e($periodId == $p->id ? 'selected' : ''); ?>><?php echo e($p->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Department</th><th>Period</th><th>Total Budget</th><th>Spent</th><th>Remaining</th><th>Utilisation</th><th>Status</th><th></th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $budgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $budget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php $c=['draft'=>'grey','submitted'=>'orange','approved'=>'green','rejected'=>'red']; ?>
            <tr>
                <td><strong><?php echo e($budget->department->name ?? '—'); ?></strong></td>
                <td><?php echo e($budget->budgetPeriod->name ?? '—'); ?></td>
                <td>ZMW <?php echo e(number_format($budget->total_budget, 2)); ?></td>
                <td>ZMW <?php echo e(number_format($budget->total_spent, 2)); ?></td>
                <td style="<?php echo e($budget->remaining < 0 ? 'color:#dc2626;font-weight:700;' : ''); ?>">ZMW <?php echo e(number_format($budget->remaining, 2)); ?></td>
                <td>
                    <div style="display:flex;align-items:center;gap:6px;">
                        <div style="flex:1;background:#e5e7eb;border-radius:4px;height:6px;"><div style="background:<?php echo e($budget->utilization > 90 ? '#dc2626' : 'var(--primary)'); ?>;width:<?php echo e(min($budget->utilization,100)); ?>%;height:6px;border-radius:4px;"></div></div>
                        <span style="font-size:.75rem;"><?php echo e($budget->utilization); ?>%</span>
                    </div>
                </td>
                <td><span class="badge badge-<?php echo e($c[$budget->status] ?? 'grey'); ?>"><?php echo e(ucfirst($budget->status)); ?></span></td>
                <td style="white-space:nowrap;">
                    <a href="<?php echo e(route('admin.finance.budgets.show', $budget)); ?>" class="btn btn-xs btn-outline"><i class="fas fa-eye"></i></a>
                    <?php if($budget->status === 'draft' && admin_can('manage_finance')): ?>
                    <form method="POST" action="<?php echo e(route('admin.finance.budgets.approve', $budget)); ?>" style="display:inline;">
                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                        <button type="submit" class="btn btn-xs btn-success">Approve</button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="8" style="text-align:center;color:var(--text-muted);">No budgets for this period.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;"><?php echo e($budgets->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/finance/budgets/index.blade.php ENDPATH**/ ?>