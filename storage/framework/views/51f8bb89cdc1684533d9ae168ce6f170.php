<?php $__env->startSection('title', 'Employees'); ?>
<?php $__env->startSection('breadcrumb', 'HR / Employees'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div><div class="page-title">Employees</div><div class="page-subtitle"><?php echo e($employees->total()); ?> records</div></div>
    <?php if(admin_can('manage_employees')): ?>
    <a href="<?php echo e(route('admin.employees.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Add Employee</a>
    <?php endif; ?>
</div>

<div class="filter-bar">
    <form method="GET" style="display:contents;">
        <div class="form-group">
            <label>Department</label>
            <select name="department_id" class="form-control">
                <option value="">All Departments</option>
                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($dept->id); ?>" <?php echo e(request('department_id') == $dept->id ? 'selected' : ''); ?>><?php echo e($dept->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="">All</option>
                <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                <option value="on_leave" <?php echo e(request('status') === 'on_leave' ? 'selected' : ''); ?>>On Leave</option>
                <option value="terminated" <?php echo e(request('status') === 'terminated' ? 'selected' : ''); ?>>Terminated</option>
            </select>
        </div>
        <div class="form-group">
            <label>Search</label>
            <input type="text" name="search" class="form-control" value="<?php echo e(request('search')); ?>" placeholder="Name or staff number…">
        </div>
        <div class="form-group" style="justify-content:flex-end;">
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            <a href="<?php echo e(route('admin.employees.index')); ?>" class="btn btn-outline btn-sm">Reset</a>
        </div>
    </form>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Staff #</th><th>Name</th><th>Department</th><th>Job Title</th><th>Type</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><code><?php echo e($emp->staff_number); ?></code></td>
                <td>
                    <div style="font-weight:600;"><?php echo e($emp->full_name); ?></div>
                    <div style="font-size:.75rem;color:var(--text-muted);"><?php echo e($emp->email); ?></div>
                </td>
                <td><?php echo e($emp->department->name ?? '—'); ?></td>
                <td><?php echo e($emp->job_title); ?></td>
                <td><span class="badge badge-blue"><?php echo e(ucfirst($emp->employment_type)); ?></span></td>
                <td>
                    <?php $statusColors = ['active'=>'green','on_leave'=>'orange','suspended'=>'red','terminated'=>'red','resigned'=>'grey']; ?>
                    <span class="badge badge-<?php echo e($statusColors[$emp->employment_status] ?? 'grey'); ?>"><?php echo e(ucfirst(str_replace('_',' ',$emp->employment_status))); ?></span>
                </td>
                <td>
                    <a href="<?php echo e(route('admin.employees.show', $emp)); ?>" class="btn btn-sm btn-outline"><i class="fas fa-eye"></i></a>
                    <?php if(admin_can('manage_employees')): ?>
                    <a href="<?php echo e(route('admin.employees.edit', $emp)); ?>" class="btn btn-sm btn-outline"><i class="fas fa-pen"></i></a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="7" style="text-align:center;color:var(--text-muted);">No employees found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;"><?php echo e($employees->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/employees/index.blade.php ENDPATH**/ ?>