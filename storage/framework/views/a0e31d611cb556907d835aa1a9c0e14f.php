
<?php $__env->startSection('title', 'Pages'); ?>
<?php $__env->startSection('content'); ?>
<div class="toolbar">
    <a class="btn" href="<?php echo e(route('admin.pages.create')); ?>">Create page</a>
</div>
<div class="panel">
    <div class="admin-list">
        <?php $__empty_1 = true; $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="admin-list__item">
                <div>
                    <h3 class="admin-list__title"><?php echo e($page->title); ?></h3>
                    <p class="admin-list__meta">/<?php echo e($page->slug); ?> · template: <?php echo e($page->template ?: '—'); ?></p>
                </div>
                <div class="admin-list__facts">
                    <div class="admin-list__fact">
                        <span>Status</span>
                        <strong><span class="badge"><?php echo e($page->status); ?></span></strong>
                    </div>
                    <div class="admin-list__fact">
                        <span>Template</span>
                        <strong><?php echo e($page->template ?: '—'); ?></strong>
                    </div>
                </div>
                <div class="admin-list__actions">
                    <a class="btn" href="<?php echo e(route('admin.pages.edit', $page)); ?>">Edit</a>
                    <?php if($page->status === 'published' && $page->slug !== 'home'): ?>
                        <a class="btn line" href="<?php echo e(route('page.show', $page->slug)); ?>" target="_blank">View</a>
                    <?php elseif($page->slug === 'home'): ?>
                        <a class="btn line" href="<?php echo e(route('home')); ?>" target="_blank">View</a>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="admin-list__item is-empty">No pages yet.</div>
        <?php endif; ?>
    </div>
    <?php echo e($pages->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/admin/pages/index.blade.php ENDPATH**/ ?>