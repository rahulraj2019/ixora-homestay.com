
<?php $__env->startSection('title', 'Reviews'); ?>
<?php $__env->startSection('subtitle', 'Approve guest feedback before it appears on the website'); ?>
<?php $__env->startSection('content'); ?>

<div class="cards cards--compact" aria-label="Filter by status">
    <a class="card card--link card--compact<?php echo e(($status ?? '') === '' ? ' is-active' : ''); ?>" href="<?php echo e(route('admin.reviews.index')); ?>#reviews-list">
        <span class="card__label">All</span>
        <strong class="card__value"><?php echo e($statusCounts['all'] ?? 0); ?></strong>
    </a>
    <?php $__currentLoopData = ['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a
            class="card card--link card--compact<?php echo e(($status ?? '') === $key ? ' is-active' : ''); ?>"
            href="<?php echo e(route('admin.reviews.index', ['status' => $key])); ?>#reviews-list"
        >
            <span class="card__label"><?php echo e($label); ?></span>
            <strong class="card__value"><?php echo e($statusCounts[$key] ?? 0); ?></strong>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="panel" id="reviews-list">
    <div class="panel__head">
        <h2>
            <?php if(($status ?? '') !== ''): ?>
                <?php echo e(ucfirst($status)); ?> reviews
            <?php else: ?>
                All reviews
            <?php endif; ?>
        </h2>
        <span class="muted"><?php echo e($reviews->total()); ?> result<?php echo e($reviews->total() === 1 ? '' : 's'); ?></span>
    </div>
    <div class="admin-list">
        <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="admin-list__item">
                <div>
                    <h3 class="admin-list__title"><?php echo e($review->name); ?></h3>
                    <p class="admin-list__meta"><?php echo e($review->location ?: 'Guest'); ?> · <?php echo e($review->rating); ?>/5</p>
                    <p class="admin-list__body" style="margin-top:.55rem"><?php echo e(Str::limit($review->message, 160)); ?></p>
                </div>
                <div class="admin-list__facts">
                    <div class="admin-list__fact">
                        <span>Rating</span>
                        <strong><?php echo e($review->rating); ?>/5</strong>
                    </div>
                    <div class="admin-list__fact">
                        <span>Status</span>
                        <strong>
                            <form method="POST" action="<?php echo e(route('admin.reviews.update', $review)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <select name="status" onchange="this.form.submit()">
                                    <?php $__currentLoopData = ['pending', 'approved', 'rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($s); ?>" <?php if($review->status === $s): echo 'selected'; endif; ?>><?php echo e($s); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </form>
                        </strong>
                    </div>
                </div>
                <div class="admin-list__actions">
                    <form method="POST" action="<?php echo e(route('admin.reviews.destroy', $review)); ?>" onsubmit="return confirm('Delete this review?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="btn danger" type="submit">Delete</button>
                    </form>
                </div>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="admin-list__item is-empty">No reviews found for this filter.</div>
        <?php endif; ?>
    </div>
    <?php echo e($reviews->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Home\resources\views/admin/reviews/index.blade.php ENDPATH**/ ?>