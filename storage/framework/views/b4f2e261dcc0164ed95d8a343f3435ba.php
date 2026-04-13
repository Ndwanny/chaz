<?php $__env->startSection('title', 'Reports'); ?>
<?php $__env->startSection('breadcrumb', 'Reports'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div><div class="page-title">Reports</div><div class="page-subtitle">Organizational reporting and analytics</div></div>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:20px;">

    <?php if(admin_can('view_employees') || admin_can('manage_hr')): ?>
    <a href="<?php echo e(route('admin.reports.hr')); ?>" class="card" style="text-decoration:none;color:inherit;transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(26,60,107,.15)'" onmouseout="this.style.boxShadow=''">
        <div class="card-body" style="text-align:center;padding:30px 20px;">
            <div style="font-size:2.5rem;color:var(--primary);margin-bottom:12px;"><i class="fas fa-users"></i></div>
            <div style="font-weight:700;font-size:1rem;color:var(--primary);">HR Report</div>
            <div style="font-size:.8rem;color:var(--text-muted);margin-top:6px;">Employees, leave, headcount by department</div>
        </div>
    </a>
    <?php endif; ?>

    <?php if(admin_can('view_payroll') || admin_can('manage_payroll')): ?>
    <a href="<?php echo e(route('admin.reports.payroll')); ?>" class="card" style="text-decoration:none;color:inherit;transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(26,60,107,.15)'" onmouseout="this.style.boxShadow=''">
        <div class="card-body" style="text-align:center;padding:30px 20px;">
            <div style="font-size:2.5rem;color:var(--success);margin-bottom:12px;"><i class="fas fa-money-bill-wave"></i></div>
            <div style="font-weight:700;font-size:1rem;color:var(--primary);">Payroll Report</div>
            <div style="font-size:.8rem;color:var(--text-muted);margin-top:6px;">Monthly payroll summary, PAYE, NAPSA, NHIMA</div>
        </div>
    </a>
    <?php endif; ?>

    <?php if(admin_can('view_fleet') || admin_can('manage_fleet')): ?>
    <a href="<?php echo e(route('admin.reports.fleet')); ?>" class="card" style="text-decoration:none;color:inherit;transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(26,60,107,.15)'" onmouseout="this.style.boxShadow=''">
        <div class="card-body" style="text-align:center;padding:30px 20px;">
            <div style="font-size:2.5rem;color:var(--warning);margin-bottom:12px;"><i class="fas fa-car"></i></div>
            <div style="font-weight:700;font-size:1rem;color:var(--primary);">Fleet Report</div>
            <div style="font-size:.8rem;color:var(--text-muted);margin-top:6px;">Fuel consumption, trips, maintenance costs</div>
        </div>
    </a>
    <?php endif; ?>

    <?php if(admin_can('view_finance') || admin_can('manage_finance')): ?>
    <a href="<?php echo e(route('admin.reports.finance')); ?>" class="card" style="text-decoration:none;color:inherit;transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(26,60,107,.15)'" onmouseout="this.style.boxShadow=''">
        <div class="card-body" style="text-align:center;padding:30px 20px;">
            <div style="font-size:2.5rem;color:var(--info);margin-bottom:12px;"><i class="fas fa-chart-pie"></i></div>
            <div style="font-weight:700;font-size:1rem;color:var(--primary);">Finance Report</div>
            <div style="font-size:.8rem;color:var(--text-muted);margin-top:6px;">Budget utilization, expenses by department</div>
        </div>
    </a>
    <?php endif; ?>

    <?php if(admin_can('manage_system')): ?>
    <a href="<?php echo e(route('admin.reports.audit')); ?>" class="card" style="text-decoration:none;color:inherit;transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(26,60,107,.15)'" onmouseout="this.style.boxShadow=''">
        <div class="card-body" style="text-align:center;padding:30px 20px;">
            <div style="font-size:2.5rem;color:var(--danger);margin-bottom:12px;"><i class="fas fa-clipboard-list"></i></div>
            <div style="font-weight:700;font-size:1rem;color:var(--primary);">Audit Log</div>
            <div style="font-size:.8rem;color:var(--text-muted);margin-top:6px;">All system actions and changes</div>
        </div>
    </a>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>