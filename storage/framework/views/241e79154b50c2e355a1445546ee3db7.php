<?php $__env->startSection('title','Messages'); ?>
<?php $__env->startSection('page-title','Contact Messages'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div><div class="breadcrumb"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a> / Messages</div><h2>Contact Messages</h2></div>
</div>
<div class="card">
    <div class="card-header"><h3>All Messages (<?php echo e($messages->total()); ?>)</h3></div>
    <div class="table-wrap">
        <?php if($messages->count()): ?>
        <table>
            <thead><tr><th>From</th><th>Subject</th><th>Phone</th><th>Received</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr style="<?php echo e(!$msg->read ? 'background:#FFFDF5;font-weight:600;' : ''); ?>">
                <td>
                    <div style="font-size:0.875rem;"><?php echo e($msg->name); ?></div>
                    <div style="font-size:0.75rem;color:var(--slate-mid);"><?php echo e($msg->email); ?></div>
                </td>
                <td style="font-size:0.875rem;max-width:240px;">
                    <?php if(!$msg->read): ?><span style="display:inline-block;width:7px;height:7px;background:var(--gold);border-radius:50%;margin-right:5px;vertical-align:middle;"></span><?php endif; ?>
                    <?php echo e($msg->subject); ?>

                </td>
                <td style="font-size:0.82rem;color:var(--slate-mid);"><?php echo e($msg->phone ?? '—'); ?></td>
                <td style="font-size:0.8rem;color:var(--slate-mid);white-space:nowrap;"><?php echo e($msg->created_at->format('M d, Y H:i')); ?></td>
                <td><span class="badge <?php echo e($msg->read ? 'badge-grey' : 'badge-gold'); ?>"><?php echo e($msg->read ? 'Read' : 'Unread'); ?></span></td>
                <td>
                    <div style="display:flex;gap:0.4rem;">
                        <a href="<?php echo e(route('admin.messages.show', $msg)); ?>" class="btn btn-outline btn-sm"><i class="fa fa-eye"></i> View</a>
                        <form action="<?php echo e(route('admin.messages.destroy', $msg)); ?>" method="POST" onsubmit="return confirm('Delete this message?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div style="padding:1rem 1.5rem;"><?php echo e($messages->links()); ?></div>
        <?php else: ?>
        <div class="empty-state"><i class="fa fa-envelope"></i><p>No messages yet.</p></div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/messages/index.blade.php ENDPATH**/ ?>