<?php $__env->startSection('title', 'Expenses'); ?>
<?php $__env->startSection('breadcrumb', 'Finance / Expenses'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div><div class="page-title">Expense Claims</div></div>
    <a href="<?php echo e(route('admin.finance.expenses.create')); ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Submit Expense</a>
</div>

<div class="stats-grid" style="margin-bottom:20px;">
    <div class="stat-card"><div class="stat-icon orange"><i class="fas fa-hourglass-half"></i></div><div><div class="stat-value">ZMW <?php echo e(number_format($totals['pending'], 2)); ?></div><div class="stat-label">Pending</div></div></div>
    <div class="stat-card"><div class="stat-icon blue"><i class="fas fa-thumbs-up"></i></div><div><div class="stat-value">ZMW <?php echo e(number_format($totals['approved'], 2)); ?></div><div class="stat-label">Approved</div></div></div>
    <div class="stat-card"><div class="stat-icon green"><i class="fas fa-check-double"></i></div><div><div class="stat-value">ZMW <?php echo e(number_format($totals['paid'], 2)); ?></div><div class="stat-label">Paid</div></div></div>
</div>

<div class="card" style="margin-bottom:16px;">
    <div class="card-body">
        <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
            <div>
                <label style="font-size:.78rem;font-weight:600;">Status</label>
                <select name="status" class="form-control">
                    <option value="">All</option>
                    <?php $__currentLoopData = ['pending','approved','paid','rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($s); ?>" <?php echo e(request('status') === $s ? 'selected' : ''); ?>><?php echo e(ucfirst($s)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label style="font-size:.78rem;font-weight:600;">Category</label>
                <select name="expense_category_id" class="form-control">
                    <option value="">All Categories</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($cat->id); ?>" <?php echo e(request('expense_category_id') == $cat->id ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label style="font-size:.78rem;font-weight:600;">Department</label>
                <select name="department_id" class="form-control">
                    <option value="">All</option>
                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($dept->id); ?>" <?php echo e(request('department_id') == $dept->id ? 'selected' : ''); ?>><?php echo e($dept->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="<?php echo e(route('admin.finance.expenses.index')); ?>" class="btn btn-outline">Reset</a>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>#</th><th>Description</th><th>Department</th><th>Category</th><th>Date</th><th>Amount (ZMW)</th><th>Status</th><th></th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><code><?php echo e($exp->expense_number); ?></code></td>
                <td>
                    <div style="font-weight:600;"><?php echo e(Str::limit($exp->description, 60)); ?></div>
                    <div style="font-size:.75rem;color:var(--text-muted);">By <?php echo e($exp->createdBy->name ?? '—'); ?></div>
                </td>
                <td><?php echo e($exp->department->name ?? '—'); ?></td>
                <td><?php echo e($exp->category->name ?? '—'); ?></td>
                <td><?php echo e($exp->expense_date?->format('d M Y')); ?></td>
                <td style="font-weight:700;"><?php echo e(number_format($exp->amount, 2)); ?></td>
                <td>
                    <?php $c=['pending'=>'orange','approved'=>'blue','paid'=>'green','rejected'=>'red']; ?>
                    <span class="badge badge-<?php echo e($c[$exp->status] ?? 'grey'); ?>"><?php echo e(ucfirst($exp->status)); ?></span>
                </td>
                <td style="white-space:nowrap;">
                    <a href="<?php echo e(route('admin.finance.expenses.show', $exp)); ?>" class="btn btn-xs btn-outline"><i class="fas fa-eye"></i></a>
                    <?php if($exp->isPending() && admin_can('manage_finance')): ?>
                    <form method="POST" action="<?php echo e(route('admin.finance.expenses.approve', $exp)); ?>" style="display:inline;">
                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                        <button type="submit" class="btn btn-xs btn-success">Approve</button>
                    </form>
                    <?php endif; ?>
                    <?php if($exp->isApproved() && admin_can('manage_finance')): ?>
                    <form method="POST" action="<?php echo e(route('admin.finance.expenses.pay', $exp)); ?>" style="display:inline;">
                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                        <button type="submit" class="btn btn-xs btn-primary">Mark Paid</button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="8" style="text-align:center;color:var(--text-muted);">No expenses found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="padding:12px 16px;"><?php echo e($expenses->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/finance/expenses/index.blade.php ENDPATH**/ ?>