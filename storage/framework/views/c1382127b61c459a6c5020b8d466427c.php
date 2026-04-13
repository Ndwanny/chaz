<?php $__env->startSection('title', isset($vehicle) ? 'Edit Vehicle' : 'Add Vehicle'); ?>
<?php $__env->startSection('breadcrumb', 'Fleet / Vehicles / ' . (isset($vehicle) ? 'Edit' : 'Add')); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div><div class="page-title"><?php echo e(isset($vehicle) ? 'Edit Vehicle' : 'Add Vehicle'); ?></div></div>
    <a href="<?php echo e(route('admin.fleet.vehicles.index')); ?>" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div class="card" style="max-width:720px;">
    <div class="card-body">
        <form method="POST" action="<?php echo e(isset($vehicle) ? route('admin.fleet.vehicles.update', $vehicle) : route('admin.fleet.vehicles.store')); ?>">
            <?php echo csrf_field(); ?>
            <?php if(isset($vehicle)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
            <?php if($errors->any()): ?>
            <div style="margin-bottom:16px;padding:10px 14px;background:#fee2e2;border-radius:6px;color:#991b1b;font-size:.85rem;">
                <ul style="margin:0;padding-left:18px;"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
            </div>
            <?php endif; ?>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div>
                    <label class="form-label">Registration Number <span style="color:red;">*</span></label>
                    <input type="text" name="registration_number" class="form-control" value="<?php echo e(old('registration_number', $vehicle->registration_number ?? '')); ?>" maxlength="20" required>
                </div>
                <div>
                    <label class="form-label">Status <span style="color:red;">*</span></label>
                    <select name="status" class="form-control" required>
                        <?php $__currentLoopData = ['available','active','maintenance','out_of_service']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s); ?>" <?php echo e(old('status', $vehicle->status ?? 'available') == $s ? 'selected' : ''); ?>><?php echo e(ucfirst(str_replace('_',' ',$s))); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="form-label">Make <span style="color:red;">*</span></label>
                    <input type="text" name="make" class="form-control" value="<?php echo e(old('make', $vehicle->make ?? '')); ?>" maxlength="60" required>
                </div>
                <div>
                    <label class="form-label">Model <span style="color:red;">*</span></label>
                    <input type="text" name="model" class="form-control" value="<?php echo e(old('model', $vehicle->model ?? '')); ?>" maxlength="60" required>
                </div>
                <div>
                    <label class="form-label">Year <span style="color:red;">*</span></label>
                    <input type="number" name="year" class="form-control" value="<?php echo e(old('year', $vehicle->year ?? date('Y'))); ?>" min="1990" max="<?php echo e(date('Y') + 1); ?>" required>
                </div>
                <div>
                    <label class="form-label">Color</label>
                    <input type="text" name="color" class="form-control" value="<?php echo e(old('color', $vehicle->color ?? '')); ?>" maxlength="30">
                </div>
                <div>
                    <label class="form-label">Category <span style="color:red;">*</span></label>
                    <select name="category_id" class="form-control" required>
                        <option value="">— Select —</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->id); ?>" <?php echo e(old('category_id', $vehicle->category_id ?? '') == $cat->id ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="form-label">Department</label>
                    <select name="department_id" class="form-control">
                        <option value="">— None —</option>
                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($dept->id); ?>" <?php echo e(old('department_id', $vehicle->department_id ?? '') == $dept->id ? 'selected' : ''); ?>><?php echo e($dept->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="form-label">Fuel Type <span style="color:red;">*</span></label>
                    <select name="fuel_type" class="form-control" required>
                        <?php $__currentLoopData = ['petrol','diesel','electric','hybrid']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ft): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($ft); ?>" <?php echo e(old('fuel_type', $vehicle->fuel_type ?? 'diesel') == $ft ? 'selected' : ''); ?>><?php echo e(ucfirst($ft)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="form-label">Engine Capacity</label>
                    <input type="text" name="engine_capacity" class="form-control" value="<?php echo e(old('engine_capacity', $vehicle->engine_capacity ?? '')); ?>" maxlength="20" placeholder="e.g. 3.0L">
                </div>
                <div>
                    <label class="form-label">Seating Capacity</label>
                    <input type="number" name="seating_capacity" class="form-control" value="<?php echo e(old('seating_capacity', $vehicle->seating_capacity ?? '')); ?>" min="1">
                </div>
                <div>
                    <label class="form-label">Current Mileage (km)</label>
                    <input type="number" name="current_mileage" class="form-control" value="<?php echo e(old('current_mileage', $vehicle->current_mileage ?? 0)); ?>" min="0">
                </div>
                <div>
                    <label class="form-label">Chassis Number</label>
                    <input type="text" name="chassis_number" class="form-control" value="<?php echo e(old('chassis_number', $vehicle->chassis_number ?? '')); ?>" maxlength="50">
                </div>
                <div>
                    <label class="form-label">Engine Number</label>
                    <input type="text" name="engine_number" class="form-control" value="<?php echo e(old('engine_number', $vehicle->engine_number ?? '')); ?>" maxlength="50">
                </div>
                <div>
                    <label class="form-label">Purchase Date</label>
                    <input type="date" name="purchase_date" class="form-control" value="<?php echo e(old('purchase_date', $vehicle?->purchase_date?->format('Y-m-d') ?? '')); ?>">
                </div>
                <div>
                    <label class="form-label">Purchase Price (ZMW)</label>
                    <input type="number" name="purchase_price" class="form-control" value="<?php echo e(old('purchase_price', $vehicle->purchase_price ?? '')); ?>" step="0.01" min="0">
                </div>
                <div style="grid-column:1/-1;">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2"><?php echo e(old('notes', $vehicle->notes ?? '')); ?></textarea>
                </div>
            </div>

            <div style="margin-top:20px;display:flex;gap:10px;">
                <button type="submit" class="btn btn-primary"><?php echo e(isset($vehicle) ? 'Update Vehicle' : 'Add Vehicle'); ?></button>
                <a href="<?php echo e(route('admin.fleet.vehicles.index')); ?>" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/fleet/vehicles/form.blade.php ENDPATH**/ ?>