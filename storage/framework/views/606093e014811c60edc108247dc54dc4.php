
<?php $__env->startSection('title', 'Enquiries'); ?>
<?php $__env->startSection('content'); ?>

<?php
    $enquiryStatusTones = [
        'new' => 'info',
        'pending' => 'warn',
        'contacted' => 'neutral',
        'closed' => 'ok',
    ];
?>
<div class="cards cards--stats" aria-label="Filter by status">
    <a class="card card--link card--neutral<?php echo e(($status ?? '') === '' ? ' is-active' : ''); ?>" href="<?php echo e(route('admin.enquiries.index')); ?>#enquiries-list">
        <span class="card__label">All</span>
        <strong class="card__value"><?php echo e($statusCounts['all'] ?? 0); ?></strong>
    </a>
    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a
            class="card card--link card--<?php echo e($enquiryStatusTones[$key] ?? 'neutral'); ?><?php echo e(($status ?? '') === $key ? ' is-active' : ''); ?>"
            href="<?php echo e(route('admin.enquiries.index', ['status' => $key])); ?>#enquiries-list"
        >
            <span class="card__label"><?php echo e($label); ?></span>
            <strong class="card__value"><?php echo e($statusCounts[$key] ?? 0); ?></strong>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="panel" id="enquiries-list">
    <div class="panel__head">
        <h2>
            <?php if(($status ?? '') !== '' && isset($statuses[$status])): ?>
                <?php echo e($statuses[$status]); ?>

            <?php else: ?>
                All enquiries
            <?php endif; ?>
        </h2>
        <span class="muted"><?php echo e($enquiries->total()); ?> result<?php echo e($enquiries->total() === 1 ? '' : 's'); ?></span>
    </div>
    <div class="admin-list">
        <?php $__empty_1 = true; $__currentLoopData = $enquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="admin-list__item">
                <div>
                    <h3 class="admin-list__title"><?php echo e($e->name); ?></h3>
                    <p class="admin-list__meta"><?php echo e($e->email); ?><?php if($e->phone): ?> · <?php echo e($e->phone); ?><?php endif; ?></p>
                </div>
                <div class="admin-list__facts">
                    <div class="admin-list__fact">
                        <span>Subject</span>
                        <strong><?php echo e($e->subject ?: '—'); ?></strong>
                    </div>
                    <div class="admin-list__fact">
                        <span>Status</span>
                        <strong><span class="badge"><?php echo e($e->status); ?></span></strong>
                    </div>
                </div>
                <div class="admin-list__actions">
                    <a class="btn" href="<?php echo e(route('admin.enquiries.show', $e)); ?>">Open</a>
                </div>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="admin-list__item is-empty">No enquiries found.</div>
        <?php endif; ?>
    </div>
    <?php echo e($enquiries->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/admin/enquiries/index.blade.php ENDPATH**/ ?>