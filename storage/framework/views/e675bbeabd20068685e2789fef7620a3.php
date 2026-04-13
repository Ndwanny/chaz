<?php $__env->startSection('title', 'Submit Expense'); ?>
<?php $__env->startSection('breadcrumb', 'Finance / Expenses / Submit'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div><div class="page-title">Submit Expense Claim</div></div>
    <a href="<?php echo e(route('admin.finance.expenses.index')); ?>" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div class="card" style="max-width:720px;">
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('admin.finance.expenses.store')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php if($errors->any()): ?>
            <div style="margin-bottom:16px;padding:10px 14px;background:#fee2e2;border-radius:6px;color:#991b1b;font-size:.85rem;">
                <ul style="margin:0;padding-left:18px;"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
            </div>
            <?php endif; ?>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div>
                    <label class="form-label">Category <span style="color:red;">*</span></label>
                    <select name="expense_category_id" class="form-control" required>
                        <option value="">— Select —</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat->id); ?>" <?php echo e(old('expense_category_id') == $cat->id ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="form-label">Department <span style="color:red;">*</span></label>
                    <select name="department_id" class="form-control" required>
                        <option value="">— Select —</option>
                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($dept->id); ?>" <?php echo e(old('department_id') == $dept->id ? 'selected' : ''); ?>><?php echo e($dept->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="form-label">Employee</label>
                    <select name="employee_id" class="form-control">
                        <option value="">— None —</option>
                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($emp->id); ?>" <?php echo e(old('employee_id') == $emp->id ? 'selected' : ''); ?>><?php echo e($emp->full_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="form-label">Budget Line</label>
                    <select name="budget_line_id" class="form-control">
                        <option value="">— None —</option>
                        <?php $__currentLoopData = $budgetLines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($line->id); ?>" <?php echo e(old('budget_line_id') == $line->id ? 'selected' : ''); ?>><?php echo e($line->account_code); ?> — <?php echo e($line->description); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div style="grid-column:1/-1;">
                    <label class="form-label">Description <span style="color:red;">*</span></label>
                    <textarea name="description" class="form-control" rows="2" required><?php echo e(old('description')); ?></textarea>
                </div>
                <div>
                    <label class="form-label">Amount (ZMW) <span style="color:red;">*</span></label>
                    <input type="number" name="amount" class="form-control" value="<?php echo e(old('amount')); ?>" step="0.01" min="0.01" required>
                </div>
                <div>
                    <label class="form-label">Expense Date <span style="color:red;">*</span></label>
                    <input type="date" name="expense_date" class="form-control" value="<?php echo e(old('expense_date', date('Y-m-d'))); ?>" required>
                </div>
                <div>
                    <label class="form-label">Payment Method</label>
                    <select name="payment_method" class="form-control">
                        <option value="">— Select —</option>
                        <?php $__currentLoopData = ['cash'=>'Cash','bank_transfer'=>'Bank Transfer','cheque'=>'Cheque','mobile_money'=>'Mobile Money']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($val); ?>" <?php echo e(old('payment_method') == $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="form-label">Receipt Number</label>
                    <input type="text" name="receipt_number" class="form-control" value="<?php echo e(old('receipt_number')); ?>" maxlength="50">
                </div>
                <div style="grid-column:1/-1;">
                    <label class="form-label">Receipt Document (PDF/Image, max 5MB)</label>
                    <input type="file" name="receipt_document" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                </div>
                <div style="grid-column:1/-1;">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="2"><?php echo e(old('notes')); ?></textarea>
                </div>
            </div>

            <div style="margin-top:20px;display:flex;gap:10px;">
                <button type="submit" class="btn btn-primary">Submit Expense</button>
                <a href="<?php echo e(route('admin.finance.expenses.index')); ?>" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/finance/expenses/form.blade.php ENDPATH**/ ?>