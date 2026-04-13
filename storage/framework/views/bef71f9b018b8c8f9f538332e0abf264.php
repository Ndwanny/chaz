<?php $__env->startSection('title', 'Employee Portal Accounts'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1 class="page-title">Employee Portal Accounts</h1>
    <p class="page-subtitle">Manage employee self-service portal access — HR use only</p>
</div>

<?php if(session('success')): ?>
<div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>
<?php if(session('error')): ?>
<div class="alert alert-danger"><?php echo e(session('error')); ?></div>
<?php endif; ?>


<div class="stats-grid" style="margin-bottom:1.5rem;">
    <div class="stat-card">
        <div class="stat-icon" style="background:#ECFDF5;color:#059669;"><i class="fas fa-users"></i></div>
        <div>
            <div class="stat-value"><?php echo e($stats['total']); ?></div>
            <div class="stat-label">Active Employees</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#EFF6FF;color:#2563EB;"><i class="fas fa-door-open"></i></div>
        <div>
            <div class="stat-value"><?php echo e($stats['active']); ?></div>
            <div class="stat-label">Portal Access Enabled</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FFF7ED;color:#EA580C;"><i class="fas fa-lock"></i></div>
        <div>
            <div class="stat-value"><?php echo e($stats['pending']); ?></div>
            <div class="stat-label">No Portal Access</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#F0FDF4;color:#16A34A;"><i class="fas fa-shield-halved"></i></div>
        <div>
            <div class="stat-value">HR Only</div>
            <div class="stat-label">Access Restricted</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.75rem;">
        <h3 class="card-title" style="margin:0;">Employee Portal Access</h3>

        
        <form method="POST" action="<?php echo e(route('admin.portal-accounts.bulk-activate')); ?>" style="display:flex;gap:.5rem;align-items:center;">
            <?php echo csrf_field(); ?>
            <select name="department_id" class="form-control form-control-sm" style="min-width:180px;" required>
                <option value="">— Select Department —</option>
                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($dept->id); ?>"><?php echo e($dept->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Activate portal for all employees in this department who don\'t have access yet?')">
                <i class="fas fa-bolt"></i> Bulk Activate
            </button>
        </form>
    </div>

    
    <div class="card-body" style="padding-bottom:0;">
        <form method="GET" action="<?php echo e(route('admin.portal-accounts.index')); ?>" style="display:flex;gap:.75rem;flex-wrap:wrap;align-items:flex-end;">
            <div>
                <label style="font-size:.8rem;font-weight:600;display:block;margin-bottom:.25rem;">Search</label>
                <input type="text" name="search" class="form-control form-control-sm" value="<?php echo e(request('search')); ?>" placeholder="Name or staff number" style="min-width:200px;">
            </div>
            <div>
                <label style="font-size:.8rem;font-weight:600;display:block;margin-bottom:.25rem;">Department</label>
                <select name="department_id" class="form-control form-control-sm" style="min-width:160px;">
                    <option value="">All Departments</option>
                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($dept->id); ?>" <?php echo e(request('department_id') == $dept->id ? 'selected' : ''); ?>><?php echo e($dept->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label style="font-size:.8rem;font-weight:600;display:block;margin-bottom:.25rem;">Portal Status</label>
                <select name="portal_status" class="form-control form-control-sm">
                    <option value="">All</option>
                    <option value="active"     <?php echo e(request('portal_status') === 'active'     ? 'selected' : ''); ?>>Enabled</option>
                    <option value="inactive"   <?php echo e(request('portal_status') === 'inactive'   ? 'selected' : ''); ?>>Disabled</option>
                    <option value="no_account" <?php echo e(request('portal_status') === 'no_account' ? 'selected' : ''); ?>>No Account</option>
                </select>
            </div>
            <div style="display:flex;gap:.5rem;">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filter</button>
                <a href="<?php echo e(route('admin.portal-accounts.index')); ?>" class="btn btn-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>

    <div class="table-responsive" style="margin-top:1rem;">
        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Staff No.</th>
                    <th>Department</th>
                    <th>Portal Status</th>
                    <th>Password</th>
                    <th>Last Login</th>
                    <th style="min-width:260px;">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>
                    <div style="font-weight:600;"><?php echo e($emp->full_name); ?></div>
                    <div style="font-size:.78rem;color:#6B7280;"><?php echo e($emp->designation ?? '—'); ?></div>
                </td>
                <td><code><?php echo e($emp->staff_number); ?></code></td>
                <td><?php echo e($emp->department->name ?? '—'); ?></td>
                <td>
                    <?php if($emp->portal_active): ?>
                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> Enabled</span>
                    <?php else: ?>
                        <span class="badge badge-secondary"><i class="fas fa-ban"></i> Disabled</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($emp->portal_password): ?>
                        <span class="badge badge-info"><i class="fas fa-key"></i> Custom</span>
                    <?php else: ?>
                        <span class="badge badge-warning" title="Default: <?php echo e(strtolower($emp->staff_number)); ?>"><i class="fas fa-unlock"></i> Default</span>
                    <?php endif; ?>
                </td>
                <td style="font-size:.8rem;color:#6B7280;">
                    <?php echo e($emp->portal_last_login?->diffForHumans() ?? 'Never'); ?>

                </td>
                <td>
                    <div style="display:flex;gap:.35rem;flex-wrap:wrap;align-items:center;">
                        
                        <?php if($emp->portal_active): ?>
                        <form method="POST" action="<?php echo e(route('admin.portal-accounts.deactivate', $emp)); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-warning btn-xs" onclick="return confirm('Suspend portal access for <?php echo e(addslashes($emp->full_name)); ?>?')" title="Suspend Access">
                                <i class="fas fa-ban"></i> Suspend
                            </button>
                        </form>
                        <?php else: ?>
                        <form method="POST" action="<?php echo e(route('admin.portal-accounts.activate', $emp)); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-success btn-xs" title="Enable Portal Access">
                                <i class="fas fa-check"></i> Activate
                            </button>
                        </form>
                        <?php endif; ?>

                        
                        <form method="POST" action="<?php echo e(route('admin.portal-accounts.reset-password', $emp)); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-secondary btn-xs" onclick="return confirm('Reset password to default (staff number) for <?php echo e(addslashes($emp->full_name)); ?>?')" title="Reset to default password">
                                <i class="fas fa-rotate-left"></i> Reset
                            </button>
                        </form>

                        
                        <button type="button" class="btn btn-primary btn-xs" onclick="openPasswordModal(<?php echo e($emp->id); ?>, '<?php echo e(addslashes($emp->full_name)); ?>')" title="Set Custom Password">
                            <i class="fas fa-lock"></i> Set PW
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" style="text-align:center;padding:2rem;color:#6B7280;">
                    <i class="fas fa-users" style="font-size:1.5rem;opacity:.3;display:block;margin-bottom:.5rem;"></i>
                    No employees found.
                </td>
            </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-body"><?php echo e($employees->withQueryString()->links()); ?></div>
</div>


<div class="card" style="margin-top:1.25rem;border-left:4px solid #3B82F6;">
    <div class="card-body" style="padding:1rem 1.25rem;">
        <h6 style="font-weight:700;color:#1D4ED8;margin:0 0 .5rem;"><i class="fas fa-circle-info"></i> Portal Account Notes</h6>
        <ul style="margin:0;padding-left:1.25rem;font-size:.85rem;color:#374151;line-height:1.8;">
            <li><strong>Default password</strong> = employee's staff number in lowercase (e.g. <code>chaz-0042</code>)</li>
            <li>Employees with <span class="badge badge-warning">Default</span> password have never set a personal password</li>
            <li>Use <strong>Activate</strong> to grant an employee access to the self-service portal</li>
            <li>Use <strong>Suspend</strong> to temporarily block portal access without deleting the account</li>
            <li>Use <strong>Reset</strong> to revert a forgotten custom password back to the default (staff number)</li>
            <li>All portal account changes are recorded in the audit log</li>
        </ul>
    </div>
</div>


<div id="password-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:12px;padding:2rem;min-width:380px;max-width:440px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,.2);">
        <h5 style="margin:0 0 1.25rem;font-weight:700;">Set Portal Password</h5>
        <p id="modal-employee-name" style="font-size:.85rem;color:#6B7280;margin-bottom:1.25rem;"></p>
        <form id="password-form" method="POST">
            <?php echo csrf_field(); ?>
            <div style="margin-bottom:1rem;">
                <label style="font-size:.8rem;font-weight:600;display:block;margin-bottom:.35rem;">New Password</label>
                <input type="password" name="new_password" class="form-control" minlength="6" required autocomplete="new-password">
            </div>
            <div style="margin-bottom:1.5rem;">
                <label style="font-size:.8rem;font-weight:600;display:block;margin-bottom:.35rem;">Confirm Password</label>
                <input type="password" name="new_password_confirmation" class="form-control" required autocomplete="new-password">
            </div>
            <div style="display:flex;gap:.75rem;">
                <button type="submit" class="btn btn-primary" style="flex:1;">Save Password</button>
                <button type="button" class="btn btn-secondary" onclick="closePasswordModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function openPasswordModal(employeeId, name) {
    document.getElementById('modal-employee-name').textContent = 'Employee: ' + name;
    document.getElementById('password-form').action = '/admin/portal-accounts/' + employeeId + '/set-password';
    document.getElementById('password-modal').style.display = 'flex';
}
function closePasswordModal() {
    document.getElementById('password-modal').style.display = 'none';
    document.getElementById('password-form').reset();
}
document.getElementById('password-modal').addEventListener('click', function(e) {
    if (e.target === this) closePasswordModal();
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/portal-accounts/index.blade.php ENDPATH**/ ?>