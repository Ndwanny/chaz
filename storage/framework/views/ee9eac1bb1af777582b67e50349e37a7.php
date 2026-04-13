<?php $__env->startSection('title','News Articles'); ?>
<?php $__env->startSection('page-title','News Articles'); ?>
<?php $__env->startSection('topbar-actions'); ?>
    <a href="<?php echo e(route('admin.news.create')); ?>" class="topbar__btn topbar__btn--forest"><i class="fa fa-plus"></i> New Article</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <div class="breadcrumb"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a> / News</div>
        <h2>News Articles</h2>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>All Articles (<?php echo e($news->total()); ?>)</h3>
    </div>
    <div class="table-wrap">
        <?php if($news->count()): ?>
        <table>
            <thead>
                <tr><th>Title</th><th>Tag</th><th>Author</th><th>Status</th><th>Published</th><th>Actions</th></tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td style="max-width:300px;">
                    <div style="font-weight:600;font-size:0.875rem;color:var(--slate);"><?php echo e($article->title); ?></div>
                    <div style="font-size:0.75rem;color:var(--slate-mid);margin-top:0.2rem;"><?php echo e(Str::limit($article->excerpt, 80)); ?></div>
                </td>
                <td><span class="badge badge-blue"><?php echo e($article->tag); ?></span></td>
                <td style="font-size:0.83rem;"><?php echo e($article->author); ?></td>
                <td><span class="badge <?php echo e($article->status === 'published' ? 'badge-green' : 'badge-grey'); ?>"><?php echo e($article->status); ?></span></td>
                <td style="font-size:0.8rem;color:var(--slate-mid);">
                    <?php echo e($article->published_at ? $article->published_at->format('M d, Y') : '—'); ?>

                </td>
                <td>
                    <div style="display:flex;gap:0.4rem;">
                        <a href="<?php echo e(route('admin.news.edit', $article)); ?>" class="btn btn-outline btn-sm"><i class="fa fa-pen"></i> Edit</a>
                        <form action="<?php echo e(route('admin.news.destroy', $article)); ?>" method="POST" onsubmit="return confirm('Delete this article?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div style="padding:1rem 1.5rem;"><?php echo e($news->links()); ?></div>
        <?php else: ?>
        <div class="empty-state"><i class="fa fa-newspaper"></i><p>No articles yet. <a href="<?php echo e(route('admin.news.create')); ?>" style="color:var(--forest);">Create your first article.</a></p></div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\dev\chaz\resources\views/admin/news/index.blade.php ENDPATH**/ ?>