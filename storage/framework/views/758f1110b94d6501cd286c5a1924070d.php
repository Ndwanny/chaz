<?php $__env->startSection('title', 'Suppliers'); ?>
<?php $__env->startSection('page-title', 'Suppliers'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <div class="page-title">Suppliers</div>
        <div class="page-subtitle">Vendor and supplier directory</div>
    </div>
    <?php if(admin_can('manage_procurement')): ?>
    <a href="<?php echo e(route('admin.suppliers.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> New Supplier</a>
    <?php endif; ?>
</div>

<?php if(session('success')): ?>
<div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?></div>
<?php endif; ?>
<?php if(session('error')): ?>
<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?></div>
<?php endif; ?>


<div class="card" style="margin-bottom:1rem;">
    <div class="card-body" style="padding:.75rem 1rem;">
        <form method="GET" style="display:flex;gap:.75rem;flex-wrap:wrap;align-items:flex-end;">
            <div class="form-group" style="margin:0;flex:1;min-width:200px;">
                <input type="text" name="search" class="form-control" placeholder="Search by name…" value="<?php echo e(request('search')); ?>">
            </div>
            <div class="form-group" style="margin:0;">
                <select name="status" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="active"   <?php echo e(request('status') === 'active'   ? 'selected' : ''); ?>>Active</option>
                    <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
            <?php if(request()->hasAny(['search','status'])): ?>
            <a href="<?php echo e(route('admin.suppliers.index')); ?>" class="btn btn-outline">Clear</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Supplier</th>
                    <th>Code</th>
                    <th>Contact</th>
                    <th>Location</th>
                    <th>Payment Terms</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <div style="font-weight:600;"><?php echo e($supplier->name); ?></div>
                    <?php if($supplier->registration_number): ?>
                    <div style="font-size:.72rem;color:var(--slate-mid);">Reg: <?php echo e($supplier->registration_number); ?></div>
                    <?php endif; ?>
                </td>
                <td><code><?php echo e($supplier->code); ?></code></td>
                <td>
                    <?php if($supplier->contact_person): ?>
                    <div style="font-size:.85rem;"><?php echo e($supplier->contact_person); ?></div>
                    <?php endif; ?>
                    <?php if($supplier->email): ?>
                    <div style="font-size:.75rem;color:var(--slate-mid);"><?php echo e($supplier->email); ?></div>
                    <?php endif; ?>
                    <?php if($supplier->phone): ?>
                    <div style="font-size:.75rem;color:var(--slate-mid);"><?php echo e($supplier->phone); ?></div>
                    <?php endif; ?>
                </td>
                <td style="font-size:.85rem;">
                    <?php echo e(collect([$supplier->city, $supplier->country])->filter()->implode(', ') ?: '—'); ?>

                </td>
                <td style="font-size:.85rem;">
                    <?php echo e($supplier->payment_terms ? $supplier->payment_terms . ' days' : '—'); ?>

                </td>
                <td>
                    <?php if($supplier->rating): ?>
                    <span style="font-weight:600;color:var(--forest);"><?php echo e(number_format($supplier->rating, 1)); ?></span>
                    <span style="font-size:.75rem;color:var(--slate-mid);"> / 5</span>
                    <?php else: ?>
                    <span style="color:var(--slate-mid);font-size:.82rem;">—</span>
                    <?php endif; ?>
                </td>
                <td>
                    <span class="badge <?php echo e($supplier->is_active ? 'badge-success' : 'badge-secondary'); ?>">
                        <?php echo e($supplier->is_active ? 'Active' : 'Inactive'); ?>

                    </span>
                </td>
                <td>
                    <?php if(admin_can('manage_procurement')): ?>
                    <div style="display:flex;gap:.4rem;">
                        <a href="<?php echo e(route('admin.suppliers.edit', $supplier)); ?>" class="btn btn-outline btn-xs"><i class="fas fa-pen"></i></a>
                        <?php if($supplier->purchaseOrders()->count() === 0): ?>
                        <form method="POST" action="<?php echo e(route('admin.suppliers.destroy', $supplier)); ?>" onsubmit="return confirm('Delete <?php echo e(addslashes($supplier->name)); ?>?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
                        </form>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="8" style="text-align:center;padding:2.5rem;color:var(--slate-mid);">
                    <i class="fas fa-truck" style="font-size:1.5rem;opacity:.25;display:block;margin-bottom:.5rem;"></i>
                    No suppliers found.
                </td>
            </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-body"><?php echo e($suppliers->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/suppliers/index.blade.php ENDPATH**/ ?>