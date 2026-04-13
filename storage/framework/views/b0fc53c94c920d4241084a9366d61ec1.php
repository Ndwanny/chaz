<?php $__env->startSection('title', 'Inventory'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <div class="page-title">Inventory</div>
        <div class="page-subtitle">Item catalogue and stock levels</div>
    </div>
    <div style="display:flex;gap:.5rem;">
        <?php if(admin_can('manage_inventory') || admin_can('manage_procurement')): ?>
        <a href="<?php echo e(route('admin.inventory.stock')); ?>" class="btn btn-outline"><i class="fas fa-boxes-stacked"></i> Stock Movement</a>
        <a href="<?php echo e(route('admin.inventory.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Add Item</a>
        <?php endif; ?>
    </div>
</div>

<?php if(session('success')): ?>
<div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>


<div class="stats-grid" style="margin-bottom:1.5rem;">
    <div class="stat-card">
        <div class="stat-icon" style="background:#EFF6FF;color:#2563EB;"><i class="fas fa-box"></i></div>
        <div><div class="stat-value"><?php echo e($stats['total']); ?></div><div class="stat-label">Total Items</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FEF3C7;color:#D97706;"><i class="fas fa-triangle-exclamation"></i></div>
        <div><div class="stat-value"><?php echo e($stats['low_stock']); ?></div><div class="stat-label">Low Stock</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FEE2E2;color:#DC2626;"><i class="fas fa-circle-xmark"></i></div>
        <div><div class="stat-value"><?php echo e($stats['out']); ?></div><div class="stat-label">Out of Stock</div></div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title" style="margin:0;">Items</h3>
    </div>
    
    <div class="card-body" style="padding-bottom:0;">
        <form method="GET" style="display:flex;gap:.75rem;flex-wrap:wrap;align-items:flex-end;">
            <div>
                <label style="font-size:.8rem;font-weight:600;display:block;margin-bottom:.25rem;">Search</label>
                <input type="text" name="search" class="form-control form-control-sm" value="<?php echo e(request('search')); ?>" placeholder="Name or code" style="min-width:200px;">
            </div>
            <div>
                <label style="font-size:.8rem;font-weight:600;display:block;margin-bottom:.25rem;">Category</label>
                <select name="category_id" class="form-control form-control-sm" style="min-width:160px;">
                    <option value="">All Categories</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category_id') == $cat->id ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div style="display:flex;align-items:flex-end;gap:.5rem;">
                <label style="display:flex;align-items:center;gap:.4rem;font-size:.85rem;cursor:pointer;padding-bottom:.35rem;">
                    <input type="checkbox" name="low_stock" value="1" <?php echo e(request('low_stock') ? 'checked' : ''); ?>> Low stock only
                </label>
            </div>
            <div style="display:flex;gap:.5rem;padding-bottom:.05rem;">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filter</button>
                <a href="<?php echo e(route('admin.inventory.index')); ?>" class="btn btn-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>

    <div class="table-responsive" style="margin-top:1rem;">
        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Unit</th>
                    <th>Unit Cost (ZMW)</th>
                    <th>In Stock</th>
                    <th>Reorder At</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php $low = $item->isLowStock(); ?>
            <tr class="<?php echo e($low ? 'table-warning' : ''); ?>">
                <td><code><?php echo e($item->code); ?></code></td>
                <td>
                    <div style="font-weight:600;"><?php echo e($item->name); ?></div>
                    <?php if($item->description): ?>
                    <div style="font-size:.75rem;color:#6B7280;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:200px;"><?php echo e($item->description); ?></div>
                    <?php endif; ?>
                </td>
                <td><?php echo e($item->category->name ?? '—'); ?></td>
                <td><?php echo e($item->unit_of_measure); ?></td>
                <td><?php echo e($item->unit_cost ? number_format($item->unit_cost, 2) : '—'); ?></td>
                <td>
                    <span style="font-weight:700;color:<?php echo e((float)$item->current_stock <= 0 ? '#DC2626' : ($low ? '#D97706' : '#16A34A')); ?>;">
                        <?php echo e(number_format($item->current_stock, 2)); ?>

                    </span>
                    <?php if($low): ?>
                    <span class="badge badge-warning" style="margin-left:.3rem;font-size:.68rem;">Low</span>
                    <?php endif; ?>
                </td>
                <td><?php echo e($item->reorder_level); ?></td>
                <td>
                    <?php if($item->is_active): ?>
                    <span class="badge badge-success">Active</span>
                    <?php else: ?>
                    <span class="badge badge-secondary">Inactive</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if(admin_can('manage_inventory') || admin_can('manage_procurement')): ?>
                    <a href="<?php echo e(route('admin.inventory.edit', $item)); ?>" class="btn btn-outline btn-xs"><i class="fas fa-pen"></i></a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="9" style="text-align:center;padding:2rem;color:#6B7280;">
                    <i class="fas fa-box-open" style="font-size:1.5rem;opacity:.3;display:block;margin-bottom:.5rem;"></i>
                    No items found.
                    <?php if(admin_can('manage_inventory') || admin_can('manage_procurement')): ?>
                    <a href="<?php echo e(route('admin.inventory.create')); ?>" style="color:var(--primary);">Add the first item</a>.
                    <?php endif; ?>
                </td>
            </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-body"><?php echo e($items->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/inventory/index.blade.php ENDPATH**/ ?>