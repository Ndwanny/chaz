<?php $__env->startSection('title', 'Fleet — Vehicles'); ?>
<?php $__env->startSection('breadcrumb', 'Fleet / Vehicles'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div><div class="page-title">Fleet Vehicles</div><div class="page-subtitle"><?php echo e($vehicles->total()); ?> vehicles registered</div></div>
    <?php if(admin_can('manage_fleet')): ?>
    <a href="<?php echo e(route('admin.fleet.vehicles.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Add Vehicle</a>
    <?php endif; ?>
</div>

<div class="filter-bar">
    <form method="GET" style="display:contents;">
        <div class="form-group">
            <label>Category</label>
            <select name="category_id" class="form-control">
                <option value="">All Categories</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category_id') == $cat->id ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="">All</option>
                <?php $__currentLoopData = ['available','active','maintenance','out_of_service']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($s); ?>" <?php echo e(request('status') === $s ? 'selected' : ''); ?>><?php echo e(ucfirst(str_replace('_',' ',$s))); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-sm" style="align-self:flex-end;">Filter</button>
        <a href="<?php echo e(route('admin.fleet.vehicles.index')); ?>" class="btn btn-outline btn-sm" style="align-self:flex-end;">Reset</a>
    </form>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Registration</th><th>Vehicle</th><th>Category</th><th>Fuel</th><th>Mileage</th><th>Status</th><th>Insurance</th><th>Actions</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $ins = $vehicle->currentInsurance;
                $insStatus = $ins ? ($ins->isExpiringSoon() ? 'orange' : 'green') : 'red';
                $statusColors = ['available'=>'green','active'=>'blue','maintenance'=>'orange','out_of_service'=>'red'];
            ?>
            <tr>
                <td><strong><?php echo e($vehicle->registration_number); ?></strong></td>
                <td>
                    <div><?php echo e($vehicle->year); ?> <?php echo e($vehicle->make); ?> <?php echo e($vehicle->model); ?></div>
                    <div style="font-size:.75rem;color:var(--text-muted);"><?php echo e($vehicle->color); ?></div>
                </td>
                <td><?php echo e($vehicle->category->name ?? '—'); ?></td>
                <td><?php echo e(ucfirst($vehicle->fuel_type)); ?></td>
                <td><?php echo e(number_format($vehicle->current_mileage ?? 0)); ?> km</td>
                <td><span class="badge badge-<?php echo e($statusColors[$vehicle->status] ?? 'grey'); ?>"><?php echo e(ucfirst(str_replace('_',' ',$vehicle->status))); ?></span></td>
                <td>
                    <?php if($ins): ?>
                    <span class="badge badge-<?php echo e($insStatus); ?>"><?php echo e($ins->isExpiringSoon() ? 'Expiring Soon' : 'Valid'); ?></span>
                    <?php else: ?>
                    <span class="badge badge-red">No Insurance</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?php echo e(route('admin.fleet.vehicles.show', $vehicle)); ?>" class="btn btn-xs btn-outline"><i class="fas fa-eye"></i></a>
                    <?php if(admin_can('manage_fleet')): ?>
                    <a href="<?php echo e(route('admin.fleet.vehicles.edit', $vehicle)); ?>" class="btn btn-xs btn-outline"><i class="fas fa-pen"></i></a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="8" style="text-align:center;color:var(--text-muted);">No vehicles found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;"><?php echo e($vehicles->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/fleet/vehicles/index.blade.php ENDPATH**/ ?>