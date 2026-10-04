
<?php $__env->startSection('title', 'Bookings'); ?>
<?php $__env->startSection('content'); ?>

<?php
    $bookingStatusTones = [
        'new' => 'info',
        'pending' => 'warn',
        'contacted' => 'neutral',
        'confirmed' => 'ok',
        'completed' => 'ok',
        'cancelled' => 'danger',
        'rejected' => 'danger',
    ];
?>
<div class="cards cards--stats" aria-label="Filter by status">
    <?php $__currentLoopData = \App\Models\Booking::statuses(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a
            class="card card--link card--<?php echo e($bookingStatusTones[$key] ?? 'neutral'); ?><?php echo e(request('status') === $key ? ' is-active' : ''); ?>"
            href="<?php echo e(route('admin.bookings.index', array_filter(['status' => $key, 'q' => request('q'), 'payment_status' => request('payment_status'), 'from' => request('from'), 'to' => request('to')]))); ?>#bookings-list"
        >
            <span class="card__label"><?php echo e($label); ?></span>
            <strong class="card__value"><?php echo e($statusCounts[$key] ?? 0); ?></strong>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<form class="toolbar" method="GET" action="<?php echo e(route('admin.bookings.index')); ?>#bookings-list">
    <div><label>Search</label><input name="q" value="<?php echo e(request('q')); ?>" placeholder="Name, phone, reference"></div>
    <div><label>Status</label>
        <select name="status">
            <option value="">All statuses</option>
            <?php $__currentLoopData = \App\Models\Booking::statuses(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($key); ?>" <?php if(request('status')===$key): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div><label>Payment</label>
        <select name="payment_status">
            <option value="">All payments</option>
            <?php $__currentLoopData = \App\Models\Booking::paymentStatuses(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($key); ?>" <?php if(request('payment_status')===$key): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div><label>From</label><input type="date" name="from" value="<?php echo e(request('from')); ?>"></div>
    <div><label>To</label><input type="date" name="to" value="<?php echo e(request('to')); ?>"></div>
    <button class="btn" type="submit">Filter</button>
    <a class="btn line" href="<?php echo e(route('admin.bookings.index')); ?>#bookings-list">Reset</a>
    <a class="btn secondary" href="<?php echo e(route('admin.bookings.export', request()->query())); ?>">Export CSV</a>
</form>

<div class="panel" id="bookings-list">
    <div class="panel__head">
        <h2>
            <?php if(request('status') && isset(\App\Models\Booking::statuses()[request('status')])): ?>
                <?php echo e(\App\Models\Booking::statuses()[request('status')]); ?>

            <?php else: ?>
                All bookings
            <?php endif; ?>
        </h2>
        <span class="muted"><?php echo e($bookings->total()); ?> result<?php echo e($bookings->total() === 1 ? '' : 's'); ?></span>
    </div>

    <div class="admin-list admin-list--bookings">
        <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="booking-card">
                <header class="booking-card__head">
                    <div>
                        <a class="booking-card__ref" href="<?php echo e(route('admin.bookings.show', $b)); ?>"><?php echo e($b->booking_reference); ?></a>
                        <p class="booking-card__when"><?php echo e($b->created_at?->format('d M Y, h:i A')); ?></p>
                    </div>
                    <div class="booking-card__badges">
                        <span class="badge badge-<?php echo e($b->status); ?>"><?php echo e($b->statusLabel()); ?></span>
                        <span class="badge badge-pay-<?php echo e($b->payment_status); ?>"><?php echo e($b->paymentStatusLabel()); ?></span>
                    </div>
                </header>

                <div class="booking-card__guest">
                    <strong><?php echo e($b->name); ?></strong>
                    <span><?php echo e($b->phone); ?></span>
                    <?php if($b->email): ?><span><?php echo e($b->email); ?></span><?php endif; ?>
                </div>

                <div class="booking-card__grid">
                    <div>
                        <span>Stay / Event</span>
                        <strong><?php echo e($b->booking_type); ?></strong>
                        <small><?php echo e($b->guest_count ?: ($b->adults + $b->children)); ?> guests</small>
                    </div>
                    <div>
                        <span>Dates</span>
                        <strong><?php echo e(optional($b->check_in)->format('d M Y') ?: '—'); ?></strong>
                        <?php if($b->check_out): ?>
                            <small>to <?php echo e($b->check_out->format('d M Y')); ?></small>
                        <?php endif; ?>
                    </div>
                    <?php if($b->amount_total): ?>
                        <div>
                            <span>Amount</span>
                            <strong>₹<?php echo e(number_format((float) $b->amount_total, 0)); ?></strong>
                        </div>
                    <?php endif; ?>
                </div>

                <a class="btn booking-card__btn" href="<?php echo e(route('admin.bookings.show', $b)); ?>">Manage booking</a>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="admin-list__item is-empty">No bookings found.</div>
        <?php endif; ?>
    </div>

    <?php echo e($bookings->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp_lite_8_5\www\ixora-homestay\resources\views/admin/bookings/index.blade.php ENDPATH**/ ?>