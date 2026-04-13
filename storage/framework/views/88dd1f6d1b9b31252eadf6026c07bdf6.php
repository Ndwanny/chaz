<?php $__env->startSection('title', 'Purchase Orders'); ?>
<?php $__env->startSection('breadcrumb', 'Procurement / Purchase Orders'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div><div class="page-title">Purchase Orders</div><div class="page-subtitle"><?php echo e($orders->total()); ?> orders</div></div>
    <?php if(admin_can('manage_procurement')): ?>
    <a href="<?php echo e(route('admin.purchase-orders.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> New PO</a>
    <?php endif; ?>
</div>

<div class="filter-bar">
    <form method="GET" style="display:contents;">
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="">All</option>
                <?php $__currentLoopData = ['draft','pending_approval','approved','ordered','delivered','cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($s); ?>" <?php echo e(request('status') === $s ? 'selected' : ''); ?>><?php echo e(ucfirst(str_replace('_',' ',$s))); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group">
            <label>Supplier</label>
            <select name="supplier_id" class="form-control">
                <option value="">All Suppliers</option>
                <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($sup->id); ?>" <?php echo e(request('supplier_id') == $sup->id ? 'selected' : ''); ?>><?php echo e($sup->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-sm" style="align-self:flex-end;">Filter</button>
        <a href="<?php echo e(route('admin.purchase-orders.index')); ?>" class="btn btn-outline btn-sm" style="align-self:flex-end;">Reset</a>
    </form>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>PO Number</th><th>Supplier</th><th>Department</th><th>Order Date</th><th>Expected Delivery</th><th>Grand Total</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $po): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php $c=['draft'=>'grey','pending_approval'=>'orange','approved'=>'blue','ordered'=>'purple','delivered'=>'green','cancelled'=>'red']; ?>
            <tr>
                <td><code><?php echo e($po->po_number); ?></code></td>
                <td><?php echo e($po->supplier->name ?? '—'); ?></td>
                <td><?php echo e($po->department->name ?? '—'); ?></td>
                <td><?php echo e($po->order_date?->format('d M Y')); ?></td>
                <td><?php echo e($po->expected_delivery?->format('d M Y') ?? '—'); ?></td>
                <td><?php echo e(format_zmw((float)$po->grand_total)); ?></td>
                <td><span class="badge badge-<?php echo e($c[$po->status] ?? 'grey'); ?>"><?php echo e(ucfirst(str_replace('_',' ',$po->status))); ?></span></td>
                <td>
                    <a href="<?php echo e(route('admin.purchase-orders.show', $po)); ?>" class="btn btn-xs btn-outline"><i class="fas fa-eye"></i></a>
                    <?php if($po->status === 'pending_approval' && admin_can('manage_procurement')): ?>
                    <form method="POST" action="<?php echo e(route('admin.purchase-orders.approve', $po)); ?>" style="display:inline;">
                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                        <button type="submit" class="btn btn-xs btn-success">Approve</button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="8" style="text-align:center;color:var(--text-muted);">No purchase orders.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;"><?php echo e($orders->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/purchase-orders/index.blade.php ENDPATH**/ ?>