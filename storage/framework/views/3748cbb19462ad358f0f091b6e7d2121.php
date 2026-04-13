<?php $__env->startSection('title', 'Leave Management'); ?>
<?php $__env->startSection('breadcrumb', 'HR / Leave Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div><div class="page-title">Leave Requests</div></div>
    <div style="display:flex;gap:8px;">
        <?php if(admin_can('manage_hr')): ?>
        <a href="<?php echo e(route('admin.leave.types')); ?>" class="btn btn-outline"><i class="fas fa-list"></i> Leave Types</a>
        <a href="<?php echo e(route('admin.leave.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> New Request</a>
        <?php endif; ?>
    </div>
</div>

<div class="filter-bar">
    <form method="GET" style="display:contents;">
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="">All</option>
                <?php $__currentLoopData = ['pending','approved','rejected','cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($s); ?>" <?php echo e(request('status') === $s ? 'selected' : ''); ?>><?php echo e(ucfirst($s)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-sm" style="align-self:flex-end;">Filter</button>
        <a href="<?php echo e(route('admin.leave.index')); ?>" class="btn btn-outline btn-sm" style="align-self:flex-end;">Reset</a>
    </form>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Employee</th><th>Department</th><th>Leave Type</th><th>From</th><th>To</th><th>Days</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <div style="font-weight:600;"><?php echo e($req->employee->full_name ?? '—'); ?></div>
                    <div style="font-size:.75rem;color:var(--text-muted);"><?php echo e($req->employee->staff_number ?? ''); ?></div>
                </td>
                <td><?php echo e($req->employee->department->name ?? '—'); ?></td>
                <td><?php echo e($req->leaveType->name ?? '—'); ?></td>
                <td><?php echo e($req->start_date?->format('d M Y')); ?></td>
                <td><?php echo e($req->end_date?->format('d M Y')); ?></td>
                <td><?php echo e($req->days_requested); ?></td>
                <td>
                    <?php $c=['pending'=>'orange','approved'=>'green','rejected'=>'red','cancelled'=>'grey']; ?>
                    <span class="badge badge-<?php echo e($c[$req->status] ?? 'grey'); ?>"><?php echo e(ucfirst($req->status)); ?></span>
                </td>
                <td>
                    <?php if($req->isPending() && admin_can('manage_hr')): ?>
                    <form method="POST" action="<?php echo e(route('admin.leave.approve', $req)); ?>" style="display:inline;">
                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                        <button type="submit" class="btn btn-xs btn-success">Approve</button>
                    </form>
                    <button class="btn btn-xs btn-danger" onclick="document.getElementById('reject-<?php echo e($req->id); ?>').style.display='block'">Reject</button>
                    <div id="reject-<?php echo e($req->id); ?>" style="display:none;margin-top:6px;">
                        <form method="POST" action="<?php echo e(route('admin.leave.reject', $req)); ?>">
                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                            <input type="text" name="rejection_reason" class="form-control" placeholder="Reason for rejection" required>
                            <button type="submit" class="btn btn-xs btn-danger" style="margin-top:4px;">Confirm Reject</button>
                        </form>
                    </div>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="8" style="text-align:center;color:var(--text-muted);">No leave requests.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;"><?php echo e($requests->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/leave/index.blade.php ENDPATH**/ ?>