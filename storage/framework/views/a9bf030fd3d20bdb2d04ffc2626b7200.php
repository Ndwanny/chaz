<?php $__env->startSection('title', 'Departments'); ?>
<?php $__env->startSection('page-title', 'Departments'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <div class="page-title">Departments</div>
        <div class="page-subtitle">Organisational structure and units</div>
    </div>
    <?php if(admin_can('manage_system')): ?>
    <a href="<?php echo e(route('admin.departments.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> New Department</a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Department</th>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Parent</th>
                    <th>Head</th>
                    <th>Province</th>
                    <th>Employees</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $typeColors = [
                    'executive'   => 'badge-gold',
                    'operational' => 'badge-blue',
                    'support'     => 'badge-grey',
                    'provincial'  => 'badge-green',
                ];
            ?>
            <tr>
                <td>
                    <div style="font-weight:600;"><?php echo e($dept->name); ?></div>
                    <?php if($dept->description): ?>
                    <div style="font-size:.72rem;color:var(--slate-mid);margin-top:1px;max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?php echo e($dept->description); ?></div>
                    <?php endif; ?>
                </td>
                <td><code><?php echo e($dept->code); ?></code></td>
                <td>
                    <span class="badge <?php echo e($typeColors[$dept->type] ?? 'badge-grey'); ?>"><?php echo e($dept->type_label); ?></span>
                </td>
                <td style="font-size:.85rem;"><?php echo e($dept->parent->name ?? '—'); ?></td>
                <td style="font-size:.85rem;"><?php echo e($dept->head->name ?? '—'); ?></td>
                <td style="font-size:.85rem;"><?php echo e($dept->province ?? '—'); ?></td>
                <td>
                    <span class="badge <?php echo e($dept->employees_count > 0 ? 'badge-green' : 'badge-grey'); ?>">
                        <?php echo e($dept->employees_count); ?>

                    </span>
                </td>
                <td>
                    <span class="badge <?php echo e($dept->is_active ? 'badge-success' : 'badge-secondary'); ?>">
                        <?php echo e($dept->is_active ? 'Active' : 'Inactive'); ?>

                    </span>
                </td>
                <td>
                    <?php if(admin_can('manage_system')): ?>
                    <div style="display:flex;gap:.4rem;">
                        <a href="<?php echo e(route('admin.departments.edit', $dept)); ?>" class="btn btn-outline btn-xs"><i class="fas fa-pen"></i></a>
                        <?php if($dept->employees_count === 0): ?>
                        <form method="POST" action="<?php echo e(route('admin.departments.destroy', $dept)); ?>" onsubmit="return confirm('Delete <?php echo e(addslashes($dept->name)); ?>?')">
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
                <td colspan="9" style="text-align:center;padding:2.5rem;color:var(--slate-mid);">
                    <i class="fas fa-sitemap" style="font-size:1.5rem;opacity:.25;display:block;margin-bottom:.5rem;"></i>
                    No departments found.
                </td>
            </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-body"><?php echo e($departments->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/departments/index.blade.php ENDPATH**/ ?>