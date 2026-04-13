<?php $__env->startSection('title', isset($supplier) ? 'Edit Supplier' : 'New Supplier'); ?>
<?php $__env->startSection('page-title', isset($supplier) ? 'Edit Supplier' : 'New Supplier'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <div class="page-title"><?php echo e(isset($supplier) ? 'Edit: ' . $supplier->name : 'New Supplier'); ?></div>
        <div class="page-subtitle"><?php echo e(isset($supplier) ? 'Update supplier details' : 'Add a new vendor or supplier'); ?></div>
    </div>
    <a href="<?php echo e(route('admin.suppliers.index')); ?>" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<?php if($errors->any()): ?>
<div class="alert alert-danger">
    <ul style="margin:0;padding-left:1.2rem;">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php endif; ?>

<form method="POST" action="<?php echo e(isset($supplier) ? route('admin.suppliers.update', $supplier) : route('admin.suppliers.store')); ?>">
    <?php echo csrf_field(); ?>
    <?php if(isset($supplier)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;align-items:start;">

        
        <div class="card">
            <div class="card-header">
                <span class="card-title"><i class="fas fa-building" style="color:var(--forest);margin-right:.4rem;"></i> Basic Information</span>
            </div>
            <div class="card-body">
                <div class="form-grid form-grid--2">
                    <div class="form-group" style="grid-column:1/-1;">
                        <label class="form-label">Supplier Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $supplier->name ?? '')); ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Code <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control" value="<?php echo e(old('code', $supplier->code ?? '')); ?>" <?php echo e(isset($supplier) ? 'readonly' : 'required'); ?> placeholder="e.g. SUP-001">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Registration No.</label>
                        <input type="text" name="registration_number" class="form-control" value="<?php echo e(old('registration_number', $supplier->registration_number ?? '')); ?>" placeholder="Company reg. number">
                    </div>
                    <div class="form-group">
                        <label class="form-label">TPIN</label>
                        <input type="text" name="tpin" class="form-control" value="<?php echo e(old('tpin', $supplier->tpin ?? '')); ?>" placeholder="Tax Payer Identification No.">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Payment Terms (days)</label>
                        <input type="number" name="payment_terms" class="form-control" value="<?php echo e(old('payment_terms', $supplier->payment_terms ?? '')); ?>" min="0" placeholder="e.g. 30">
                    </div>
                </div>

                <?php if(isset($supplier)): ?>
                <div class="form-group">
                    <label class="form-label">Rating (0–5)</label>
                    <input type="number" name="rating" class="form-control" value="<?php echo e(old('rating', $supplier->rating ?? '')); ?>" min="0" max="5" step="0.1">
                </div>
                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;font-size:.875rem;">
                        <input type="checkbox" name="is_active" value="1" <?php echo e(old('is_active', $supplier->is_active ?? true) ? 'checked' : ''); ?>>
                        Active
                    </label>
                </div>
                <?php endif; ?>

                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Any additional notes…"><?php echo e(old('notes', $supplier->notes ?? '')); ?></textarea>
                </div>
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:1.25rem;">
            
            <div class="card">
                <div class="card-header">
                    <span class="card-title"><i class="fas fa-address-book" style="color:var(--forest);margin-right:.4rem;"></i> Contact Details</span>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Contact Person</label>
                        <input type="text" name="contact_person" class="form-control" value="<?php echo e(old('contact_person', $supplier->contact_person ?? '')); ?>">
                    </div>
                    <div class="form-grid form-grid--2">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $supplier->email ?? '')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone', $supplier->phone ?? '')); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2"><?php echo e(old('address', $supplier->address ?? '')); ?></textarea>
                    </div>
                    <div class="form-grid form-grid--2">
                        <div class="form-group">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" value="<?php echo e(old('city', $supplier->city ?? '')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-control" value="<?php echo e(old('country', $supplier->country ?? '')); ?>" placeholder="e.g. Zambia">
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="card">
                <div class="card-header">
                    <span class="card-title"><i class="fas fa-university" style="color:var(--forest);margin-right:.4rem;"></i> Banking Details</span>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Bank Name</label>
                        <input type="text" name="bank_name" class="form-control" value="<?php echo e(old('bank_name', $supplier->bank_name ?? '')); ?>">
                    </div>
                    <div class="form-grid form-grid--2">
                        <div class="form-group">
                            <label class="form-label">Account Number</label>
                            <input type="text" name="bank_account" class="form-control" value="<?php echo e(old('bank_account', $supplier->bank_account ?? '')); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Branch</label>
                            <input type="text" name="bank_branch" class="form-control" value="<?php echo e(old('bank_branch', $supplier->bank_branch ?? '')); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div style="display:flex;gap:.75rem;margin-top:1.25rem;">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> <?php echo e(isset($supplier) ? 'Update Supplier' : 'Create Supplier'); ?>

        </button>
        <a href="<?php echo e(route('admin.suppliers.index')); ?>" class="btn btn-secondary">Cancel</a>
    </div>
</form>

<?php $__env->startPush('styles'); ?>
<style>
@media (max-width: 900px) {
    form > div[style*="grid-template-columns"] { grid-template-columns: 1fr !important; }
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/suppliers/form.blade.php ENDPATH**/ ?>