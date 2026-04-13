<?php $__env->startSection('title', 'Payroll Report'); ?>
<?php $__env->startSection('page-title', 'Reports'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <div class="page-title">Payroll Report</div>
        <div class="page-subtitle">Annual payroll summary — <?php echo e($year); ?></div>
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
        <div class="stat-icon green"><i class="fas fa-money-bill-wave"></i></div>
        <div><div class="stat-value">ZMW <?php echo e(number_format($data['total_net'] / 1000, 0)); ?>K</div><div class="stat-label">Total Net Paid</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-landmark"></i></div>
        <div><div class="stat-value">ZMW <?php echo e(number_format($data['total_tax'] / 1000, 0)); ?>K</div><div class="stat-label">Total Tax Deducted</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-minus-circle"></i></div>
        <div><div class="stat-value">ZMW <?php echo e(number_format($data['total_deductions'] / 1000, 0)); ?>K</div><div class="stat-label">Total Other Deductions</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-file-invoice"></i></div>
        <div><div class="stat-value"><?php echo e($data['monthly_breakdown']->count()); ?></div><div class="stat-label">Payroll Runs</div></div>
    </div>
</div>


<div class="card">
    <div class="card-header"><span class="card-title">Monthly Breakdown — <?php echo e($year); ?></span></div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Period</th>
                    <th>Employees</th>
                    <th style="text-align:right;">Basic (ZMW)</th>
                    <th style="text-align:right;">Allowances</th>
                    <th style="text-align:right;">Deductions</th>
                    <th style="text-align:right;">Tax</th>
                    <th style="text-align:right;">Net Pay</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $data['monthly_breakdown']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $run): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td style="font-weight:600;"><?php echo e($run->payrollPeriod->name ?? '—'); ?></td>
                <td><?php echo e($run->employee_count); ?></td>
                <td style="text-align:right;"><?php echo e(number_format($run->total_basic, 0)); ?></td>
                <td style="text-align:right;"><?php echo e(number_format($run->total_allowances, 0)); ?></td>
                <td style="text-align:right;"><?php echo e(number_format($run->total_deductions, 0)); ?></td>
                <td style="text-align:right;"><?php echo e(number_format($run->total_tax, 0)); ?></td>
                <td style="text-align:right;font-weight:700;color:var(--forest);"><?php echo e(number_format($run->total_net, 0)); ?></td>
                <td><span class="badge badge-<?php echo e($run->status === 'approved' ? 'success' : ($run->status === 'draft' ? 'gold' : 'grey')); ?>"><?php echo e(ucfirst($run->status)); ?></span></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="8" style="text-align:center;padding:2rem;color:var(--slate-mid);">No payroll runs for <?php echo e($year); ?>.</td></tr>
            <?php endif; ?>
            </tbody>
            <?php if($data['monthly_breakdown']->count() > 1): ?>
            <tfoot>
                <tr style="font-weight:700;background:var(--bg-alt);">
                    <td>Total</td>
                    <td>—</td>
                    <td style="text-align:right;"><?php echo e(number_format($data['monthly_breakdown']->sum('total_basic'), 0)); ?></td>
                    <td style="text-align:right;"><?php echo e(number_format($data['monthly_breakdown']->sum('total_allowances'), 0)); ?></td>
                    <td style="text-align:right;"><?php echo e(number_format($data['monthly_breakdown']->sum('total_deductions'), 0)); ?></td>
                    <td style="text-align:right;"><?php echo e(number_format($data['monthly_breakdown']->sum('total_tax'), 0)); ?></td>
                    <td style="text-align:right;color:var(--forest);"><?php echo e(number_format($data['monthly_breakdown']->sum('total_net'), 0)); ?></td>
                    <td></td>
                </tr>
            </tfoot>
            <?php endif; ?>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/reports/payroll.blade.php ENDPATH**/ ?>