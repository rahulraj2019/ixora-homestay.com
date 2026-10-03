

<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('subtitle', 'Overview of bookings, enquiries, and site content'); ?>

<?php $__env->startSection('content'); ?>
<div class="dash-intro">
    <div>
        <p class="dash-intro__eyebrow">Welcome back<?php echo e(auth()->user()?->name ? ', '.auth()->user()->name : ''); ?></p>
        <p class="dash-intro__text">Tap any card below to open that section. Focus on new bookings and pending reviews first.</p>
    </div>
    <div class="dash-intro__actions">
        <a class="btn" href="<?php echo e(route('admin.bookings.index', ['status' => 'new'])); ?>">New bookings</a>
        <a class="btn line" href="<?php echo e(route('home')); ?>" target="_blank" rel="noopener">View website</a>
    </div>
</div>

<div class="cards cards--stats" aria-label="Quick stats">
    <?php $__currentLoopData = $statCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a class="card card--link card--<?php echo e($card['tone'] ?? 'neutral'); ?>" href="<?php echo e($card['url']); ?>">
            <span class="card__label"><?php echo e($card['label']); ?></span>
            <strong class="card__value"><?php echo e($card['value']); ?></strong>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="dash-grid">
    <div class="panel">
        <div class="panel__head">
            <h2>Recent bookings</h2>
            <a class="btn line btn-sm" href="<?php echo e(route('admin.bookings.index')); ?>">View all</a>
        </div>
        <div class="admin-list">
            <?php $__empty_1 = true; $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="admin-list__item">
                    <div>
                        <h3 class="admin-list__title">
                            <a href="<?php echo e(route('admin.bookings.show', $b)); ?>"><?php echo e($b->booking_reference); ?></a>
                        </h3>
                        <p class="admin-list__meta"><?php echo e($b->name); ?> · <?php echo e($b->booking_type); ?></p>
                    </div>
                    <div class="admin-list__facts">
                        <div class="admin-list__fact">
                            <span>Date</span>
                            <strong><?php echo e(optional($b->check_in)->format('d M Y') ?: '—'); ?></strong>
                        </div>
                        <div class="admin-list__fact">
                            <span>Status</span>
                            <strong><span class="badge badge-<?php echo e($b->status); ?>"><?php echo e($b->statusLabel()); ?></span></strong>
                        </div>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="admin-list__item is-empty">No bookings yet.</div>
            <?php endif; ?>
        </div>
    </div>

    <div class="panel">
        <div class="panel__head">
            <h2>Recent enquiries</h2>
            <a class="btn line btn-sm" href="<?php echo e(route('admin.enquiries.index')); ?>">View all</a>
        </div>
        <div class="admin-list">
            <?php $__empty_1 = true; $__currentLoopData = $recentEnquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="admin-list__item">
                    <div>
                        <h3 class="admin-list__title">
                            <a href="<?php echo e(route('admin.enquiries.show', $enquiry)); ?>"><?php echo e($enquiry->name); ?></a>
                        </h3>
                        <p class="admin-list__meta"><?php echo e($enquiry->email); ?></p>
                    </div>
                    <div class="admin-list__facts">
                        <div class="admin-list__fact">
                            <span>Subject</span>
                            <strong><?php echo e(\Illuminate\Support\Str::limit($enquiry->subject ?: $enquiry->message, 48)); ?></strong>
                        </div>
                        <div class="admin-list__fact">
                            <span>Status</span>
                            <strong><span class="badge"><?php echo e($enquiry->status); ?></span></strong>
                        </div>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="admin-list__item is-empty">No enquiries yet.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="dash-grid">
    <div class="panel">
        <div class="panel__head">
            <h2>Recent reviews</h2>
            <a class="btn line btn-sm" href="<?php echo e(route('admin.reviews.index')); ?>">Manage reviews</a>
        </div>
        <div class="admin-list">
            <?php $__empty_1 = true; $__currentLoopData = $recentReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="admin-list__item">
                    <div>
                        <h3 class="admin-list__title"><?php echo e($review->name); ?></h3>
                        <p class="admin-list__meta"><?php echo e($review->location ?: '—'); ?> · <?php echo e($review->rating); ?>/5 · <?php echo e($review->created_at?->format('d M Y')); ?></p>
                        <p class="admin-list__body" style="margin-top:.45rem"><?php echo e(\Illuminate\Support\Str::limit($review->message, 100)); ?></p>
                    </div>
                    <div class="admin-list__facts">
                        <div class="admin-list__fact">
                            <span>Status</span>
                            <strong><span class="badge"><?php echo e($review->status); ?></span></strong>
                        </div>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="admin-list__item is-empty">No reviews yet.</div>
            <?php endif; ?>
        </div>
    </div>

    <div class="panel">
        <div class="panel__head">
            <h2>Recent activity</h2>
            <a class="btn line btn-sm" href="<?php echo e(route('admin.activity.index')); ?>">Full log</a>
        </div>
        <div class="admin-list">
            <?php $__empty_1 = true; $__currentLoopData = $activity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="admin-list__item">
                    <div>
                        <h3 class="admin-list__title"><?php echo e($log->action); ?></h3>
                        <p class="admin-list__meta"><?php echo e($log->created_at?->format('d M Y H:i')); ?> · <?php echo e($log->user?->name ?? 'System'); ?></p>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="admin-list__item is-empty">No activity yet.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/admin/dashboard/index.blade.php ENDPATH**/ ?>