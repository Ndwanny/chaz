<?php $__env->startSection('title','View Message'); ?>
<?php $__env->startSection('page-title','View Message'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div><div class="breadcrumb"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a> / <a href="<?php echo e(route('admin.messages.index')); ?>">Messages</a> / View</div><h2>Message from <?php echo e($message->name); ?></h2></div>
    <a href="<?php echo e(route('admin.messages.index')); ?>" class="btn btn-outline"><i class="fa fa-arrow-left"></i> Back</a>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;align-items:flex-start;max-width:1000px;">
    <div class="card">
        <div class="card-header"><h3><i class="fa fa-envelope" style="color:var(--forest);margin-right:0.5rem;"></i><?php echo e($message->subject); ?></h3></div>
        <div class="card-body">
            <div style="background:var(--cream,#FAF7F0);border-radius:8px;padding:1.5rem;font-size:0.95rem;line-height:1.85;color:var(--slate);white-space:pre-line;"><?php echo e($message->message); ?></div>
        </div>
        <div style="padding:1rem 1.5rem;border-top:1px solid var(--border);display:flex;gap:0.75rem;">
            <a href="mailto:<?php echo e($message->email); ?>?subject=Re: <?php echo e(urlencode($message->subject)); ?>" class="btn btn-forest"><i class="fa fa-reply"></i> Reply via Email</a>
            <form action="<?php echo e(route('admin.messages.destroy', $message)); ?>" method="POST" onsubmit="return confirm('Delete this message?')">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><h3>Sender Details</h3></div>
        <div class="card-body" style="display:flex;flex-direction:column;gap:1rem;">
            <?php $__currentLoopData = [['fa-user','Name',$message->name],['fa-envelope','Email',$message->email],['fa-phone','Phone',$message->phone ?? 'Not provided'],['fa-calendar','Received',$message->created_at->format('M d, Y \a\t H:i')],['fa-circle-check','Status',$message->read ? 'Read on '.$message->read_at?->format('M d, Y') : 'Unread']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$icon,$label,$val]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="display:flex;gap:0.75rem;align-items:flex-start;">
                <i class="fa <?php echo e($icon); ?>" style="color:var(--gold);width:16px;margin-top:0.2rem;flex-shrink:0;"></i>
                <div>
                    <div style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.08em;color:var(--slate-mid);font-weight:700;"><?php echo e($label); ?></div>
                    <div style="font-size:0.88rem;color:var(--slate);font-weight:500;"><?php echo e($val); ?></div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/messages/show.blade.php ENDPATH**/ ?>