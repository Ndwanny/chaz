<?php $__env->startSection('title', 'Settings'); ?>
<?php $__env->startSection('page-title', 'Settings'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <div class="page-title">System Settings</div>
        <div class="page-subtitle">Configure organisation details, HR policies, payroll and portal options</div>
    </div>
</div>

<?php if(session('success')): ?>
<div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?></div>
<?php endif; ?>
<?php if($errors->any()): ?>
<div class="alert alert-danger">
    <ul style="margin:0;padding-left:1.2rem;">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php endif; ?>


<div style="display:flex;gap:.25rem;flex-wrap:wrap;margin-bottom:1.25rem;border-bottom:2px solid var(--border);padding-bottom:0;">
    <?php $__currentLoopData = $schema; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupKey => $groupDef): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <button type="button"
            class="settings-tab <?php echo e($loop->first ? 'active' : ''); ?>"
            data-tab="<?php echo e($groupKey); ?>"
            onclick="switchTab('<?php echo e($groupKey); ?>')">
        <i class="fas <?php echo e($groupDef['icon']); ?>"></i>
        <?php echo e($groupDef['label']); ?>

    </button>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<form action="<?php echo e(route('admin.settings.update')); ?>" method="POST">
    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

    <?php $__currentLoopData = $schema; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupKey => $groupDef): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="settings-panel <?php echo e($loop->first ? '' : 'hidden'); ?>" id="tab-<?php echo e($groupKey); ?>">
        <div class="card">
            <div class="card-header">
                <span class="card-title">
                    <i class="fas <?php echo e($groupDef['icon']); ?>" style="color:var(--forest);margin-right:.4rem;"></i>
                    <?php echo e($groupDef['label']); ?> Settings
                </span>
            </div>
            <div class="card-body">
                <div class="form-grid form-grid--2">
                <?php $__currentLoopData = $groupDef['fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $key     = $field['key'];
                    $current = old('settings.'.$key, $stored[$key] ?? $field['default']);
                    $type    = $field['type'];
                ?>

                <?php if($type === 'boolean'): ?>
                
                <div class="form-group" style="grid-column:1/-1;display:flex;align-items:center;justify-content:space-between;padding:.75rem 1rem;background:var(--bg-alt);border-radius:8px;border:1px solid var(--border);">
                    <div>
                        <div style="font-weight:500;font-size:.875rem;"><?php echo e($field['label']); ?></div>
                        <?php if(!empty($field['help'])): ?>
                        <div style="font-size:.76rem;color:var(--slate-mid);margin-top:2px;"><?php echo e($field['help']); ?></div>
                        <?php endif; ?>
                    </div>
                    <label class="toggle-switch">
                        <input type="hidden"   name="settings[<?php echo e($key); ?>]" value="0">
                        <input type="checkbox" name="settings[<?php echo e($key); ?>]" value="1" <?php echo e($current ? 'checked' : ''); ?> onchange="this.previousElementSibling.disabled = this.checked">
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <?php elseif($type === 'textarea'): ?>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label"><?php echo e($field['label']); ?></label>
                    <?php if(!empty($field['help'])): ?>
                    <div style="font-size:.76rem;color:var(--slate-mid);margin-bottom:.3rem;"><?php echo e($field['help']); ?></div>
                    <?php endif; ?>
                    <textarea name="settings[<?php echo e($key); ?>]" class="form-control" rows="3"><?php echo e($current); ?></textarea>
                </div>

                <?php elseif($type === 'select'): ?>
                <div class="form-group">
                    <label class="form-label"><?php echo e($field['label']); ?></label>
                    <?php if(!empty($field['help'])): ?>
                    <div style="font-size:.76rem;color:var(--slate-mid);margin-bottom:.3rem;"><?php echo e($field['help']); ?></div>
                    <?php endif; ?>
                    <select name="settings[<?php echo e($key); ?>]" class="form-control">
                        <?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optVal => $optLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($optVal); ?>" <?php echo e($current == $optVal ? 'selected' : ''); ?>><?php echo e($optLabel); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <?php else: ?>
                <div class="form-group">
                    <label class="form-label"><?php echo e($field['label']); ?></label>
                    <?php if(!empty($field['help'])): ?>
                    <div style="font-size:.76rem;color:var(--slate-mid);margin-bottom:.3rem;"><?php echo e($field['help']); ?></div>
                    <?php endif; ?>
                    <input type="<?php echo e($type); ?>"
                           name="settings[<?php echo e($key); ?>]"
                           class="form-control"
                           value="<?php echo e($current); ?>"
                           <?php if($type === 'number'): ?> step="any" <?php endif; ?>>
                </div>
                <?php endif; ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:.75rem;margin-top:1rem;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Settings
            </button>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</form>

<?php $__env->startPush('styles'); ?>
<style>
.settings-tab {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .55rem 1rem;
    font-size: .875rem;
    font-weight: 500;
    background: none;
    border: none;
    border-bottom: 3px solid transparent;
    color: var(--slate-mid);
    cursor: pointer;
    transition: color .15s, border-color .15s;
    margin-bottom: -2px;
}
.settings-tab:hover { color: var(--forest); }
.settings-tab.active { color: var(--forest); border-bottom-color: var(--forest); }
.settings-panel.hidden { display: none; }

/* Toggle switch */
.toggle-switch { position: relative; display: inline-block; width: 44px; height: 24px; flex-shrink: 0; }
.toggle-switch input[type="checkbox"] { opacity: 0; width: 0; height: 0; position: absolute; }
.toggle-switch input[type="hidden"]   { display: none; }
.toggle-slider {
    position: absolute; inset: 0;
    background: #cbd5e0; border-radius: 24px; cursor: pointer;
    transition: background .2s;
}
.toggle-slider::before {
    content: '';
    position: absolute; width: 18px; height: 18px; left: 3px; top: 3px;
    background: #fff; border-radius: 50%;
    transition: transform .2s;
    box-shadow: 0 1px 3px rgba(0,0,0,.2);
}
.toggle-switch input[type="checkbox"]:checked + .toggle-slider { background: var(--forest); }
.toggle-switch input[type="checkbox"]:checked + .toggle-slider::before { transform: translateX(20px); }

@media (max-width: 640px) {
    .settings-tab { padding: .45rem .65rem; font-size: .8rem; }
    .settings-tab i { display: none; }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function switchTab(key) {
    document.querySelectorAll('.settings-panel').forEach(p => p.classList.add('hidden'));
    document.querySelectorAll('.settings-tab').forEach(t => t.classList.remove('active'));
    document.getElementById('tab-' + key).classList.remove('hidden');
    document.querySelector('[data-tab="' + key + '"]').classList.add('active');
}

// Fix boolean hidden inputs: when checkbox is checked, hidden sibling should be disabled
// so only the checkbox value ("1") is submitted, not the hidden "0".
document.querySelectorAll('.toggle-switch input[type="checkbox"]').forEach(cb => {
    function sync() {
        cb.previousElementSibling.disabled = cb.checked;
    }
    sync();
    cb.addEventListener('change', sync);
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>