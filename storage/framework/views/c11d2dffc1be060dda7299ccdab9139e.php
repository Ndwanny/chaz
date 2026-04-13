<?php $__env->startSection('title', 'Finance Report'); ?>
<?php $__env->startSection('page-title', 'Reports'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <div class="page-title">Finance Report</div>
        <div class="page-subtitle">Expenses and procurement — <?php echo e($year); ?></div>
    </div>
    <a href="<?php echo e(route('admin.reports.index')); ?>" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Reports</a>
</div>


<div class="card" style="margin-bottom:1rem;">
    <div class="card-body" style="padding:.75rem 1rem;">
        <form method="GET" style="display:flex;gap:.75rem;align-items:flex-end;">
            <div class="form-group" style="margin:0;">
                <select name="year" class="form-control">
                    <?php $__currentLoopData = range(now()->year - 2, now()->year); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($y); ?>" <?php echo e($year == $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
        </form>
    </div>
</div>


<div class="stats-grid" style="margin-bottom:1.5rem;">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-receipt"></i></div>
        <div><div class="stat-value">ZMW <?php echo e(number_format($data['total_expenses'] / 1000, 0)); ?>K</div><div class="stat-label">Total Expenses</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
        <div><div class="stat-value">ZMW <?php echo e(number_format($data['paid_expenses'] / 1000, 0)); ?>K</div><div class="stat-label">Paid Expenses</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-clock"></i></div>
        <div><div class="stat-value">ZMW <?php echo e(number_format($data['pending_expenses'] / 1000, 0)); ?>K</div><div class="stat-label">Pending Approval</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon teal"><i class="fas fa-shopping-cart"></i></div>
        <div><div class="stat-value">ZMW <?php echo e(number_format($data['po_total'] / 1000, 0)); ?>K</div><div class="stat-label">Purchase Orders</div></div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">

    
    <div class="card">
        <div class="card-header"><span class="card-title">Expenses by Department</span></div>
        <div class="table-responsive">
            <table>
                <thead><tr><th>Department</th><th style="text-align:right;">Total (ZMW)</th></tr></thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $data['by_department']->sortByDesc('total'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="font-size:.875rem;"><?php echo e($row->department->name ?? 'Unknown'); ?></td>
                    <td style="text-align:right;font-weight:600;"><?php echo e(number_format($row->total, 2)); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="2" style="text-align:center;padding:1.5rem;color:var(--slate-mid);">No data</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="card">
        <div class="card-header"><span class="card-title">Expenses by Category</span></div>
        <div class="table-responsive">
            <table>
                <thead><tr><th>Category</th><th style="text-align:right;">Total (ZMW)</th></tr></thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $data['by_category']->sortByDesc('total'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="font-size:.875rem;"><?php echo e($row->category->name ?? 'Unknown'); ?></td>
                    <td style="text-align:right;font-weight:600;"><?php echo e(number_format($row->total, 2)); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="2" style="text-align:center;padding:1.5rem;color:var(--slate-mid);">No data</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php $__env->startPush('styles'); ?>
<style>
@media (max-width: 768px) {
    div[style*="grid-template-columns:1fr 1fr"] { grid-template-columns: 1fr !important; }
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/reports/finance.blade.php ENDPATH**/ ?>