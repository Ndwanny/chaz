<?php $__env->startSection('title', 'Roles & Permissions'); ?>
<?php $__env->startSection('page-title', 'Roles & Permissions'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <div class="page-title">Roles & Permissions</div>
        <div class="page-subtitle">Define what each user type can access</div>
    </div>
    <?php if(admin_can('manage_system')): ?>
    <a href="<?php echo e(route('admin.roles.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> New Role</a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Role Name</th>
                    <th>Slug</th>
                    <th>Level</th>
                    <th>Permissions</th>
                    <th>Users</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <div style="font-weight:600;"><?php echo e($role->name); ?></div>
                    <?php if($role->description): ?>
                    <div style="font-size:.75rem;color:var(--slate-mid);margin-top:2px;"><?php echo e($role->description); ?></div>
                    <?php endif; ?>
                </td>
                <td><code><?php echo e($role->slug); ?></code></td>
                <td>
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:50%;background:rgba(27,67,50,.1);color:var(--forest);font-weight:700;font-size:.82rem;">
                        <?php echo e($role->level); ?>

                    </span>
                </td>
                <td>
                    <?php $perms = $role->permissions; ?>
                    <?php if($perms->count()): ?>
                        <div style="display:flex;flex-wrap:wrap;gap:.3rem;max-width:320px;">
                            <?php $__currentLoopData = $perms->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge badge-blue"><?php echo e($p->name); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($perms->count() > 4): ?>
                            <span class="badge badge-grey">+<?php echo e($perms->count() - 4); ?> more</span>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <span style="color:var(--slate-mid);font-size:.8rem;">No permissions</span>
                    <?php endif; ?>
                </td>
                <td>
                    <span class="badge <?php echo e($role->admins_count > 0 ? 'badge-green' : 'badge-grey'); ?>">
                        <?php echo e($role->admins_count); ?> <?php echo e(Str::plural('user', $role->admins_count)); ?>

                    </span>
                </td>
                <td>
                    <?php if($role->is_active): ?>
                    <span class="badge badge-success">Active</span>
                    <?php else: ?>
                    <span class="badge badge-secondary">Inactive</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if(admin_can('manage_system')): ?>
                    <div style="display:flex;gap:.4rem;">
                        <a href="<?php echo e(route('admin.roles.edit', $role)); ?>" class="btn btn-outline btn-xs"><i class="fas fa-pen"></i></a>
                        <?php if($role->admins_count === 0): ?>
                        <form method="POST" action="<?php echo e(route('admin.roles.destroy', $role)); ?>" onsubmit="return confirm('Delete role <?php echo e(addslashes($role->name)); ?>?')">
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
                <td colspan="7" style="text-align:center;padding:2.5rem;color:var(--slate-mid);">
                    <i class="fas fa-user-shield" style="font-size:1.5rem;opacity:.25;display:block;margin-bottom:.5rem;"></i>
                    No roles defined yet.
                </td>
            </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/roles/index.blade.php ENDPATH**/ ?>