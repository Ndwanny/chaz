<?php $__env->startSection('title', 'Fuel Logs'); ?>
<?php $__env->startSection('breadcrumb', 'Fleet / Fuel'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div><div class="page-title">Fuel Logs</div></div>
    <?php if(admin_can('manage_fleet')): ?>
    <a href="<?php echo e(route('admin.fleet.fuel.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Record Fuel</a>
    <?php endif; ?>
</div>


<div class="stats-grid" style="margin-bottom:24px;">
    <div class="stat-card"><div class="stat-icon blue"><i class="fas fa-gas-pump"></i></div><div><div class="stat-value"><?php echo e(number_format($totalLitres, 1)); ?>L</div><div class="stat-label">Total Litres</div></div></div>
    <div class="stat-card"><div class="stat-icon green"><i class="fas fa-coins"></i></div><div><div class="stat-value">ZMW <?php echo e(number_format($totalCost, 2)); ?></div><div class="stat-label">Total Cost</div></div></div>
</div>


<div class="card" style="margin-bottom:16px;">
    <div class="card-body">
        <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
            <div>
                <label style="font-size:.78rem;font-weight:600;">Vehicle</label>
                <select name="vehicle_id" class="form-control" style="min-width:180px;">
                    <option value="">All Vehicles</option>
                    <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($v->id); ?>" <?php echo e(request('vehicle_id') == $v->id ? 'selected' : ''); ?>><?php echo e($v->registration_number); ?> — <?php echo e($v->make); ?> <?php echo e($v->model); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label style="font-size:.78rem;font-weight:600;">Month</label>
                <input type="month" name="month" class="form-control" value="<?php echo e(request('month')); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="<?php echo e(route('admin.fleet.fuel.index')); ?>" class="btn btn-outline">Reset</a>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Date</th><th>Vehicle</th><th>Driver</th><th>Litres</th><th>Unit Cost</th><th>Total Cost</th><th>Odometer</th><th>Station</th><th>Receipt</th></tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($log->log_date?->format('d M Y')); ?></td>
                <td>
                    <div style="font-weight:600;"><?php echo e($log->vehicle->registration_number ?? '—'); ?></div>
                    <div style="font-size:.75rem;color:var(--text-muted);"><?php echo e($log->vehicle ? $log->vehicle->make . ' ' . $log->vehicle->model : ''); ?></div>
                </td>
                <td><?php echo e($log->driver?->full_name ?? '—'); ?></td>
                <td><?php echo e(number_format($log->litres, 2)); ?>L</td>
                <td><?php echo e(number_format($log->unit_cost, 2)); ?></td>
                <td style="font-weight:700;"><?php echo e(number_format($log->total_cost, 2)); ?></td>
                <td><?php echo e($log->odometer_reading ? number_format($log->odometer_reading) . ' km' : '—'); ?></td>
                <td><?php echo e($log->fuel_station ?? '—'); ?></td>
                <td><code><?php echo e($log->receipt_number ?? '—'); ?></code></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="9" style="text-align:center;color:var(--text-muted);">No fuel records found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;"><?php echo e($logs->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/fleet/fuel/index.blade.php ENDPATH**/ ?>