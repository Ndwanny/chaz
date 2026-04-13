<?php $__env->startSection('title', 'Requisitions'); ?>
<?php $__env->startSection('breadcrumb', 'Procurement / Requisitions'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div><div class="page-title">Purchase Requisitions</div><div class="page-subtitle"><?php echo e($requisitions->total()); ?> requisitions</div></div>
    <a href="<?php echo e(route('admin.requisitions.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> New Requisition</a>
</div>

<div class="filter-bar">
    <form method="GET" style="display:contents;">
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="">All</option>
                <?php $__currentLoopData = ['pending','approved','rejected','converted']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($s); ?>" <?php echo e(request('status') === $s ? 'selected' : ''); ?>><?php echo e(ucfirst($s)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group">
            <label>Department</label>
            <select name="department_id" class="form-control">
                <option value="">All Departments</option>
                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($dept->id); ?>" <?php echo e(request('department_id') == $dept->id ? 'selected' : ''); ?>><?php echo e($dept->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-sm" style="align-self:flex-end;">Filter</button>
        <a href="<?php echo e(route('admin.requisitions.index')); ?>" class="btn btn-outline btn-sm" style="align-self:flex-end;">Reset</a>
    </form>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>REQ #</th><th>Department</th><th>Requested By</th><th>Purpose</th><th>Priority</th><th>Required By</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $requisitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php $c=['pending'=>'orange','approved'=>'green','rejected'=>'red','converted'=>'blue']; $p=['low'=>'grey','normal'=>'blue','high'=>'orange','urgent'=>'red']; ?>
            <tr>
                <td><code><?php echo e($req->req_number); ?></code></td>
                <td><?php echo e($req->department->name ?? '—'); ?></td>
                <td><?php echo e($req->requestedBy->name ?? '—'); ?></td>
                <td><?php echo e(\Str::limit($req->purpose, 50)); ?></td>
                <td><span class="badge badge-<?php echo e($p[$req->priority] ?? 'grey'); ?>"><?php echo e(ucfirst($req->priority)); ?></span></td>
                <td><?php echo e($req->required_by?->format('d M Y')); ?></td>
                <td><span class="badge badge-<?php echo e($c[$req->status] ?? 'grey'); ?>"><?php echo e(ucfirst($req->status)); ?></span></td>
                <td>
                    <a href="<?php echo e(route('admin.requisitions.show', $req)); ?>" class="btn btn-xs btn-outline"><i class="fas fa-eye"></i></a>
                    <?php if($req->isPending() && admin_can('manage_procurement')): ?>
                    <form method="POST" action="<?php echo e(route('admin.requisitions.approve', $req)); ?>" style="display:inline;">
                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                        <button type="submit" class="btn btn-xs btn-success">Approve</button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="8" style="text-align:center;color:var(--text-muted);">No requisitions found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;"><?php echo e($requisitions->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/requisitions/index.blade.php ENDPATH**/ ?>