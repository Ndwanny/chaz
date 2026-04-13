<?php $__env->startSection('title', 'HR Report'); ?>
<?php $__env->startSection('page-title', 'Reports'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <div class="page-title">HR Report</div>
        <div class="page-subtitle">Workforce overview — <?php echo e(now()->format('F Y')); ?></div>
    </div>
    <a href="<?php echo e(route('admin.reports.index')); ?>" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Reports</a>
</div>


<div class="card" style="margin-bottom:1rem;">
    <div class="card-body" style="padding:.75rem 1rem;">
        <form method="GET" style="display:flex;gap:.75rem;align-items:flex-end;flex-wrap:wrap;">
            <div class="form-group" style="margin:0;flex:1;min-width:200px;">
                <select name="department_id" class="form-control">
                    <option value="">All Departments</option>
                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($dept->id); ?>" <?php echo e($deptId == $dept->id ? 'selected' : ''); ?>><?php echo e($dept->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
            <?php if($deptId): ?>
            <a href="<?php echo e(route('admin.reports.hr')); ?>" class="btn btn-outline">Clear</a>
            <?php endif; ?>
        </form>
    </div>
</div>


<div class="stats-grid" style="margin-bottom:1.5rem;">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-users"></i></div>
        <div><div class="stat-value"><?php echo e($data['total_employees']); ?></div><div class="stat-label">Active Employees</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-user-clock"></i></div>
        <div><div class="stat-value"><?php echo e($data['on_probation']); ?></div><div class="stat-label">Interns / Probation</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-calendar-check"></i></div>
        <div><div class="stat-value"><?php echo e($data['leave_summary']->where('status','approved')->first()?->total ?? 0); ?></div><div class="stat-label">Leave Approved (<?php echo e(now()->year); ?>)</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-calendar-times"></i></div>
        <div><div class="stat-value"><?php echo e($data['leave_summary']->where('status','pending')->first()?->total ?? 0); ?></div><div class="stat-label">Leave Pending</div></div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1.25rem;">

    
    <div class="card">
        <div class="card-header"><span class="card-title">By Department</span></div>
        <div class="table-responsive">
            <table>
                <thead><tr><th>Department</th><th style="text-align:right;">Count</th></tr></thead>
                <tbody>
                <?php $__currentLoopData = $data['by_department']->sortByDesc('total'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="font-size:.875rem;"><?php echo e($row->department->name ?? 'Unknown'); ?></td>
                    <td style="text-align:right;font-weight:600;"><?php echo e($row->total); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="card">
        <div class="card-header"><span class="card-title">By Employment Type</span></div>
        <div class="table-responsive">
            <table>
                <thead><tr><th>Type</th><th style="text-align:right;">Count</th></tr></thead>
                <tbody>
                <?php $__currentLoopData = $data['by_type']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="font-size:.875rem;text-transform:capitalize;"><?php echo e(str_replace('_', ' ', $row->employment_type ?? 'Unknown')); ?></td>
                    <td style="text-align:right;font-weight:600;"><?php echo e($row->total); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="card">
        <div class="card-header"><span class="card-title">By Gender</span></div>
        <div class="table-responsive">
            <table>
                <thead><tr><th>Gender</th><th style="text-align:right;">Count</th></tr></thead>
                <tbody>
                <?php $__currentLoopData = $data['by_gender']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="font-size:.875rem;text-transform:capitalize;"><?php echo e($row->gender ?? 'Not specified'); ?></td>
                    <td style="text-align:right;font-weight:600;"><?php echo e($row->total); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="card-header" style="margin-top:.5rem;border-top:1px solid var(--border);"><span class="card-title">Leave Summary (<?php echo e(now()->year); ?>)</span></div>
        <div class="table-responsive">
            <table>
                <thead><tr><th>Status</th><th style="text-align:right;">Requests</th></tr></thead>
                <tbody>
                <?php $__currentLoopData = $data['leave_summary']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><span class="badge badge-<?php echo e($row->status === 'approved' ? 'success' : ($row->status === 'pending' ? 'gold' : 'secondary')); ?>"><?php echo e(ucfirst($row->status)); ?></span></td>
                    <td style="text-align:right;font-weight:600;"><?php echo e($row->total); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php $__env->startPush('styles'); ?>
<style>
@media (max-width: 900px) {
    div[style*="grid-template-columns:1fr 1fr 1fr"] { grid-template-columns: 1fr !important; }
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/reports/hr.blade.php ENDPATH**/ ?>