<?php $__env->startSection('title', 'Users'); ?>
<?php $__env->startSection('breadcrumb', 'System / Users'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div><div class="page-title">Admin Users</div><div class="page-subtitle"><?php echo e($users->total()); ?> users registered</div></div>
    <?php if(admin_can('manage_system')): ?>
    <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> New User</a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Name</th><th>Email</th><th>Role</th><th>Department</th><th>Staff ID</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div class="user-avatar" style="width:30px;height:30px;font-size:.72rem;background:var(--primary);border-radius:50%;display:grid;place-items:center;color:#fff;font-weight:700;flex-shrink:0;"><?php echo e($user->initials); ?></div>
                        <span><?php echo e($user->name); ?></span>
                    </div>
                </td>
                <td><?php echo e($user->email); ?></td>
                <td><?php echo e($user->roleModel->display_name ?? ucfirst($user->role)); ?></td>
                <td><?php echo e($user->department->name ?? '—'); ?></td>
                <td><?php echo e($user->staff_id ?? '—'); ?></td>
                <td><span class="badge badge-<?php echo e($user->is_active ? 'green' : 'red'); ?>"><?php echo e($user->is_active ? 'Active' : 'Inactive'); ?></span></td>
                <td>
                    <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn btn-sm btn-outline"><i class="fas fa-pen"></i> Edit</a>
                    <?php if($user->id !== session('admin_id')): ?>
                    <form method="POST" action="<?php echo e(route('admin.users.destroy', $user)); ?>" style="display:inline;" onsubmit="return confirm('Delete this user?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="7" style="text-align:center;color:var(--text-muted);">No users found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;"><?php echo e($users->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/users/index.blade.php ENDPATH**/ ?>