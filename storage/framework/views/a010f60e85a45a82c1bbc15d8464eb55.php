<?php $__env->startSection('title', 'New Trip Request'); ?>
<?php $__env->startSection('breadcrumb', 'Fleet / Trips / New'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div><div class="page-title">New Trip Request</div></div>
    <a href="<?php echo e(route('admin.fleet.trips.index')); ?>" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div class="card" style="max-width:720px;">
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('admin.fleet.trips.store')); ?>">
            <?php echo csrf_field(); ?>
            <?php if($errors->any()): ?>
            <div class="alert alert-danger" style="margin-bottom:16px;padding:10px 14px;background:#fee2e2;border-radius:6px;color:#991b1b;font-size:.85rem;">
                <ul style="margin:0;padding-left:18px;"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
            </div>
            <?php endif; ?>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div>
                    <label class="form-label">Vehicle <span style="color:red;">*</span></label>
                    <select name="vehicle_id" class="form-control" required>
                        <option value="">— Select Vehicle —</option>
                        <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($v->id); ?>" <?php echo e(old('vehicle_id') == $v->id ? 'selected' : ''); ?>><?php echo e($v->registration_number); ?> — <?php echo e($v->make); ?> <?php echo e($v->model); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="form-label">Driver <span style="color:red;">*</span></label>
                    <select name="driver_id" class="form-control" required>
                        <option value="">— Select Driver —</option>
                        <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($d->id); ?>" <?php echo e(old('driver_id') == $d->id ? 'selected' : ''); ?>><?php echo e($d->full_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div style="grid-column:1/-1;">
                    <label class="form-label">Purpose <span style="color:red;">*</span></label>
                    <input type="text" name="purpose" class="form-control" value="<?php echo e(old('purpose')); ?>" maxlength="300" required>
                </div>
                <div>
                    <label class="form-label">Departure Location <span style="color:red;">*</span></label>
                    <input type="text" name="departure_location" class="form-control" value="<?php echo e(old('departure_location')); ?>" maxlength="200" required>
                </div>
                <div>
                    <label class="form-label">Destination <span style="color:red;">*</span></label>
                    <input type="text" name="destination" class="form-control" value="<?php echo e(old('destination')); ?>" maxlength="200" required>
                </div>
                <div>
                    <label class="form-label">Departure Date <span style="color:red;">*</span></label>
                    <input type="date" name="departure_date" class="form-control" value="<?php echo e(old('departure_date', date('Y-m-d'))); ?>" required>
                </div>
                <div>
                    <label class="form-label">Departure Time</label>
                    <input type="time" name="departure_time" class="form-control" value="<?php echo e(old('departure_time')); ?>">
                </div>
                <div>
                    <label class="form-label">Expected Return Date</label>
                    <input type="date" name="return_date" class="form-control" value="<?php echo e(old('return_date')); ?>">
                </div>
                <div>
                    <label class="form-label">Expected Return Time</label>
                    <input type="time" name="return_time" class="form-control" value="<?php echo e(old('return_time')); ?>">
                </div>
                <div>
                    <label class="form-label">Passengers</label>
                    <input type="number" name="passenger_count" class="form-control" value="<?php echo e(old('passenger_count', 0)); ?>" min="0">
                </div>
                <div style="grid-column:1/-1;">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2"><?php echo e(old('notes')); ?></textarea>
                </div>
            </div>

            <div style="margin-top:20px;display:flex;gap:10px;">
                <button type="submit" class="btn btn-primary">Submit Trip Request</button>
                <a href="<?php echo e(route('admin.fleet.trips.index')); ?>" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/fleet/trips/form.blade.php ENDPATH**/ ?>