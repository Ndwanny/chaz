<?php $__env->startSection('title', isset($item) ? 'Edit Item' : 'Add Item'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <div class="page-title"><?php echo e(isset($item) ? 'Edit Item' : 'New Item'); ?></div>
        <div class="page-subtitle"><?php echo e(isset($item) ? $item->name : 'Add item to inventory catalogue'); ?></div>
    </div>
    <a href="<?php echo e(route('admin.inventory.index')); ?>" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<?php if($errors->any()): ?>
<div class="alert alert-danger">
    <ul style="margin:0;padding-left:1.2rem;">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php endif; ?>

<div class="card" style="max-width:700px;">
    <div class="card-body">
        <form method="POST" action="<?php echo e(isset($item) ? route('admin.inventory.update', $item) : route('admin.inventory.store')); ?>">
            <?php echo csrf_field(); ?>
            <?php if(isset($item)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label class="form-label">Item Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $item->name ?? '')); ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Item Code <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control" value="<?php echo e(old('code', $item->code ?? '')); ?>" required placeholder="e.g. ITM-0001">
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-control" required>
                        <option value="">— Select Category —</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->id); ?>" <?php echo e(old('category_id', $item->category_id ?? '') == $cat->id ? 'selected' : ''); ?>>
                            <?php echo e($cat->name); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Unit of Measure <span class="text-danger">*</span></label>
                    <input type="text" name="unit_of_measure" class="form-control" value="<?php echo e(old('unit_of_measure', $item->unit_of_measure ?? '')); ?>" required placeholder="e.g. pcs, litres, kg, boxes">
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label class="form-label">Unit Cost (ZMW)</label>
                    <input type="number" name="unit_cost" class="form-control" step="0.01" min="0" value="<?php echo e(old('unit_cost', $item->unit_cost ?? '')); ?>" placeholder="0.00">
                </div>
                <div class="form-group">
                    <label class="form-label">Reorder Level <span class="text-danger">*</span></label>
                    <input type="number" name="reorder_level" class="form-control" min="0" value="<?php echo e(old('reorder_level', $item->reorder_level ?? 10)); ?>" required>
                    <small class="text-muted">Alert when stock drops to this level</small>
                </div>
            </div>

            <?php if(!isset($item)): ?>
            <div class="form-group">
                <label class="form-label">Opening Stock</label>
                <input type="number" name="current_stock" class="form-control" step="0.01" min="0" value="<?php echo e(old('current_stock', 0)); ?>">
                <small class="text-muted">Current quantity on hand</small>
            </div>
            <?php endif; ?>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="2"><?php echo e(old('description', $item->description ?? '')); ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Specifications / Notes</label>
                <textarea name="specifications" class="form-control" rows="2" placeholder="Technical specs, brand, model, etc."><?php echo e(old('specifications', $item->specifications ?? '')); ?></textarea>
            </div>

            <?php if(isset($item)): ?>
            <div class="form-group">
                <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1" <?php echo e(old('is_active', $item->is_active) ? 'checked' : ''); ?>>
                    <span>Active (visible in procurement)</span>
                </label>
            </div>
            <?php endif; ?>

            <div style="display:flex;gap:.75rem;margin-top:1.5rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <?php echo e(isset($item) ? 'Update Item' : 'Create Item'); ?>

                </button>
                <a href="<?php echo e(route('admin.inventory.index')); ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/inventory/form.blade.php ENDPATH**/ ?>