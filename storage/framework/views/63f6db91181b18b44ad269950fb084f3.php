<?php $__env->startSection('title', 'Trips'); ?>
<?php $__env->startSection('breadcrumb', 'Fleet / Trips'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div><div class="page-title">Trip Logs</div></div>
    <?php if(admin_can('manage_fleet')): ?>
    <a href="<?php echo e(route('admin.fleet.trips.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> New Trip</a>
    <?php endif; ?>
</div>


<div class="card" style="margin-bottom:16px;">
    <div class="card-body">
        <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
            <div>
                <label style="font-size:.78rem;font-weight:600;">Vehicle</label>
                <select name="vehicle_id" class="form-control" style="min-width:180px;">
                    <option value="">All Vehicles</option>
                    <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($v->id); ?>" <?php echo e(request('vehicle_id') == $v->id ? 'selected' : ''); ?>><?php echo e($v->registration_number); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label style="font-size:.78rem;font-weight:600;">Status</label>
                <select name="status" class="form-control">
                    <option value="">All</option>
                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="approved" <?php echo e(request('status') == 'approved' ? 'selected' : ''); ?>>Approved</option>
                    <option value="ongoing" <?php echo e(request('status') == 'ongoing' ? 'selected' : ''); ?>>Ongoing</option>
                    <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="<?php echo e(route('admin.fleet.trips.index')); ?>" class="btn btn-outline">Reset</a>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Trip #</th><th>Vehicle</th><th>Driver</th><th>Destination</th><th>Departure</th><th>Distance</th><th>Status</th><th></th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php $statusColors = ['pending'=>'orange','approved'=>'blue','ongoing'=>'teal','completed'=>'green','cancelled'=>'red']; ?>
            <tr>
                <td><code><?php echo e($trip->trip_number); ?></code></td>
                <td><?php echo e($trip->vehicle->registration_number ?? '—'); ?></td>
                <td><?php echo e($trip->driver?->full_name ?? '—'); ?></td>
                <td>
                    <div><?php echo e($trip->destination); ?></div>
                    <div style="font-size:.75rem;color:var(--text-muted);">from <?php echo e($trip->departure_location); ?></div>
                </td>
                <td><?php echo e($trip->departure_date?->format('d M Y')); ?></td>
                <td><?php echo e($trip->distance_km ? number_format($trip->distance_km) . ' km' : '—'); ?></td>
                <td><span class="badge badge-<?php echo e($statusColors[$trip->status] ?? 'grey'); ?>"><?php echo e(ucfirst($trip->status)); ?></span></td>
                <td style="white-space:nowrap;">
                    <?php if(admin_can('manage_fleet')): ?>
                        <?php if($trip->status === 'pending'): ?>
                        <form method="POST" action="<?php echo e(route('admin.fleet.trips.approve', $trip)); ?>" style="display:inline;">
                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="btn btn-xs btn-success">Approve</button>
                        </form>
                        <?php elseif($trip->status === 'approved'): ?>
                        <form method="POST" action="<?php echo e(route('admin.fleet.trips.depart', $trip)); ?>" style="display:inline;">
                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="btn btn-xs btn-primary">Depart</button>
                        </form>
                        <?php elseif($trip->status === 'ongoing'): ?>
                        <button type="button" class="btn btn-xs btn-outline" onclick="document.getElementById('complete-<?php echo e($trip->id); ?>').style.display='block'">Complete</button>
                        <form id="complete-<?php echo e($trip->id); ?>" method="POST" action="<?php echo e(route('admin.fleet.trips.complete', $trip)); ?>" style="display:none;margin-top:4px;">
                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                            <input type="number" name="ending_odometer" placeholder="End odometer (km)" class="form-control" style="width:160px;display:inline-block;" required>
                            <button type="submit" class="btn btn-xs btn-success">Save</button>
                        </form>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="8" style="text-align:center;color:var(--text-muted);">No trips found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;"><?php echo e($trips->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/fleet/trips/index.blade.php ENDPATH**/ ?>