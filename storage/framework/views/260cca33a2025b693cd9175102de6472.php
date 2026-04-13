<?php $__env->startSection('title', 'Fleet Report'); ?>
<?php $__env->startSection('page-title', 'Reports'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <div class="page-title">Fleet Report</div>
        <div class="page-subtitle">Vehicle and fuel usage — <?php echo e($year); ?></div>
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
        <div class="stat-icon blue"><i class="fas fa-car"></i></div>
        <div><div class="stat-value"><?php echo e($data['total_vehicles']); ?></div><div class="stat-label">Total Vehicles</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-car-side"></i></div>
        <div><div class="stat-value"><?php echo e($data['active_vehicles']); ?></div><div class="stat-label">Active / Available</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-gas-pump"></i></div>
        <div><div class="stat-value"><?php echo e(number_format($data['total_fuel_litres'], 0)); ?> L</div><div class="stat-label">Fuel Used (<?php echo e($year); ?>)</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-money-bill-wave"></i></div>
        <div><div class="stat-value">ZMW <?php echo e(number_format($data['total_fuel_cost'], 0)); ?></div><div class="stat-label">Fuel Cost (<?php echo e($year); ?>)</div></div>
    </div>
</div>


<div class="card">
    <div class="card-header"><span class="card-title">Fuel Usage by Vehicle — <?php echo e($year); ?></span></div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Vehicle</th>
                    <th>Registration</th>
                    <th style="text-align:right;">Litres</th>
                    <th style="text-align:right;">Cost (ZMW)</th>
                    <th style="text-align:right;">Avg Cost/L</th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $data['fuel_by_vehicle']->sortByDesc('cost'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td style="font-size:.875rem;"><?php echo e($row->vehicle->make ?? '—'); ?> <?php echo e($row->vehicle->model ?? ''); ?></td>
                <td><code><?php echo e($row->vehicle->registration_number ?? '—'); ?></code></td>
                <td style="text-align:right;"><?php echo e(number_format($row->litres, 1)); ?></td>
                <td style="text-align:right;font-weight:600;"><?php echo e(number_format($row->cost, 2)); ?></td>
                <td style="text-align:right;color:var(--slate-mid);font-size:.85rem;">
                    <?php echo e($row->litres > 0 ? number_format($row->cost / $row->litres, 2) : '—'); ?>

                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--slate-mid);">No fuel records for <?php echo e($year); ?>.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/reports/fleet.blade.php ENDPATH**/ ?>