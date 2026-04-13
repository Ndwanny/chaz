<?php $__env->startSection('title', 'Add Maintenance Record'); ?>
<?php $__env->startSection('breadcrumb', 'Fleet / Maintenance / Add'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div><div class="page-title">Add Maintenance Record</div></div>
    <a href="<?php echo e(route('admin.fleet.maintenance.index')); ?>" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div class="card" style="max-width:720px;">
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('admin.fleet.maintenance.store')); ?>">
            <?php echo csrf_field(); ?>
            <?php if($errors->any()): ?>
            <div class="alert alert-danger" style="margin-bottom:16px;padding:10px 14px;background:#fee2e2;border-radius:6px;color:#991b1b;font-size:.85rem;">
                <ul style="margin:0;padding-left:18px;"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
            </div>
            <?php endif; ?>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div style="grid-column:1/-1;">
                    <label class="form-label">Vehicle <span style="color:red;">*</span></label>
                    <select name="vehicle_id" class="form-control" required>
                        <option value="">— Select Vehicle —</option>
                        <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($v->id); ?>" <?php echo e(old('vehicle_id') == $v->id ? 'selected' : ''); ?>><?php echo e($v->registration_number); ?> — <?php echo e($v->make); ?> <?php echo e($v->model); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="form-label">Maintenance Type <span style="color:red;">*</span></label>
                    <select name="maintenance_type" class="form-control" required>
                        <option value="">— Select Type —</option>
                        <option value="preventive" <?php echo e(old('maintenance_type') == 'preventive' ? 'selected' : ''); ?>>Preventive</option>
                        <option value="corrective" <?php echo e(old('maintenance_type') == 'corrective' ? 'selected' : ''); ?>>Corrective</option>
                        <option value="inspection" <?php echo e(old('maintenance_type') == 'inspection' ? 'selected' : ''); ?>>Inspection</option>
                        <option value="oil_change" <?php echo e(old('maintenance_type') == 'oil_change' ? 'selected' : ''); ?>>Oil Change</option>
                        <option value="tyres" <?php echo e(old('maintenance_type') == 'tyres' ? 'selected' : ''); ?>>Tyres</option>
                        <option value="service" <?php echo e(old('maintenance_type') == 'service' ? 'selected' : ''); ?>>Full Service</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Status <span style="color:red;">*</span></label>
                    <select name="status" class="form-control" required>
                        <option value="scheduled" <?php echo e(old('status','scheduled') == 'scheduled' ? 'selected' : ''); ?>>Scheduled</option>
                        <option value="pending" <?php echo e(old('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="in_progress" <?php echo e(old('status') == 'in_progress' ? 'selected' : ''); ?>>In Progress</option>
                        <option value="completed" <?php echo e(old('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Start Date <span style="color:red;">*</span></label>
                    <input type="date" name="start_date" class="form-control" value="<?php echo e(old('start_date', date('Y-m-d'))); ?>" required>
                </div>
                <div>
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="<?php echo e(old('end_date')); ?>">
                </div>
                <div>
                    <label class="form-label">Next Service Date</label>
                    <input type="date" name="next_service_date" class="form-control" value="<?php echo e(old('next_service_date')); ?>">
                </div>
                <div>
                    <label class="form-label">Mileage at Service (km)</label>
                    <input type="number" name="mileage_at_service" class="form-control" value="<?php echo e(old('mileage_at_service')); ?>" min="0">
                </div>
                <div>
                    <label class="form-label">Next Service Mileage (km)</label>
                    <input type="number" name="next_service_mileage" class="form-control" value="<?php echo e(old('next_service_mileage')); ?>" min="0">
                </div>
                <div>
                    <label class="form-label">Cost (ZMW) <span style="color:red;">*</span></label>
                    <input type="number" name="cost" class="form-control" value="<?php echo e(old('cost')); ?>" step="0.01" min="0" required>
                </div>
                <div>
                    <label class="form-label">Workshop / Service Provider</label>
                    <input type="text" name="workshop" class="form-control" value="<?php echo e(old('workshop')); ?>" maxlength="150">
                </div>
                <div>
                    <label class="form-label">Invoice Number</label>
                    <input type="text" name="invoice_number" class="form-control" value="<?php echo e(old('invoice_number')); ?>" maxlength="30">
                </div>
                <div style="grid-column:1/-1;">
                    <label class="form-label">Description <span style="color:red;">*</span></label>
                    <textarea name="description" class="form-control" rows="2" required><?php echo e(old('description')); ?></textarea>
                </div>
                <div style="grid-column:1/-1;">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2"><?php echo e(old('notes')); ?></textarea>
                </div>
            </div>

            <div style="margin-top:20px;display:flex;gap:10px;">
                <button type="submit" class="btn btn-primary">Save Record</button>
                <a href="<?php echo e(route('admin.fleet.maintenance.index')); ?>" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/fleet/maintenance/form.blade.php ENDPATH**/ ?>