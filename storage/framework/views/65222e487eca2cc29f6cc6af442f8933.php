<?php $__env->startSection('title', 'Maintenance'); ?>
<?php $__env->startSection('breadcrumb', 'Fleet / Maintenance'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div><div class="page-title">Vehicle Maintenance</div></div>
    <?php if(admin_can('manage_fleet')): ?>
    <a href="<?php echo e(route('admin.fleet.maintenance.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Add Record</a>
    <?php endif; ?>
</div>

<?php if($upcoming->count()): ?>
<div class="card" style="margin-bottom:16px;border-left:4px solid var(--warning, #f59e0b);">
    <div class="card-header"><span class="card-title" style="color:#b45309;"><i class="fas fa-exclamation-triangle"></i> Due for Service (next 30 days)</span></div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Vehicle</th><th>Type</th><th>Due Date</th><th>Mileage Due</th></tr></thead>
            <tbody>
            <?php $__currentLoopData = $upcoming; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><strong><?php echo e($u->vehicle->registration_number ?? '—'); ?></strong> — <?php echo e($u->vehicle ? $u->vehicle->make . ' ' . $u->vehicle->model : ''); ?></td>
                <td><?php echo e($u->type_label); ?></td>
                <td><?php echo e($u->next_service_date?->format('d M Y')); ?></td>
                <td><?php echo e($u->next_service_mileage ? number_format($u->next_service_mileage) . ' km' : '—'); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>


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
                <label style="font-size:.78rem;font-weight:600;">Status</label>
                <select name="status" class="form-control">
                    <option value="">All</option>
                    <option value="scheduled" <?php echo e(request('status') == 'scheduled' ? 'selected' : ''); ?>>Scheduled</option>
                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="in_progress" <?php echo e(request('status') == 'in_progress' ? 'selected' : ''); ?>>In Progress</option>
                    <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="<?php echo e(route('admin.fleet.maintenance.index')); ?>" class="btn btn-outline">Reset</a>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Vehicle</th><th>Type</th><th>Start Date</th><th>Workshop</th><th>Cost</th><th>Next Service</th><th>Status</th><th></th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php $statusColors = ['pending'=>'orange','in_progress'=>'blue','completed'=>'green','scheduled'=>'teal']; ?>
            <tr>
                <td>
                    <div style="font-weight:600;"><?php echo e($record->vehicle->registration_number ?? '—'); ?></div>
                    <div style="font-size:.75rem;color:var(--text-muted);"><?php echo e($record->vehicle ? $record->vehicle->make . ' ' . $record->vehicle->model : ''); ?></div>
                </td>
                <td><?php echo e($record->type_label); ?></td>
                <td><?php echo e($record->start_date?->format('d M Y')); ?></td>
                <td><?php echo e($record->workshop ?? '—'); ?></td>
                <td>ZMW <?php echo e(number_format($record->cost, 2)); ?></td>
                <td><?php echo e($record->next_service_date?->format('d M Y') ?? '—'); ?></td>
                <td><span class="badge badge-<?php echo e($statusColors[$record->status] ?? 'grey'); ?>"><?php echo e(ucfirst(str_replace('_', ' ', $record->status))); ?></span></td>
                <td>
                    <?php if($record->status === 'in_progress' && admin_can('manage_fleet')): ?>
                    <form method="POST" action="<?php echo e(route('admin.fleet.maintenance.complete', $record)); ?>" style="display:inline;" onsubmit="return confirm('Mark as completed?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                        <button type="submit" class="btn btn-xs btn-success">Complete</button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="8" style="text-align:center;color:var(--text-muted);">No maintenance records found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;"><?php echo e($records->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/fleet/maintenance/index.blade.php ENDPATH**/ ?>