<header class="header">
    <a class="brand" href="<?php echo e(route('home')); ?>">
        <img src="<?php echo e(setting('logo') ? asset('storage/'.setting('logo')) : asset('assets/images/ixora-homestay-logo.webp')); ?>" alt="<?php echo e(setting('business_name', 'IXORA Homestay')); ?> logo — Niduvaloor Kannur" width="84" height="84" decoding="async">
        <div>
            <strong><?php echo e(setting('brand_name', 'IXORA')); ?></strong>
            <span><?php echo e(setting('tagline', 'A lush homestay retreat')); ?></span>
        </div>
    </a>
    <?php echo $__env->make('partials.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="header-end">
        <button class="nav-toggle" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="site-nav">
            <span></span>
        </button>
        <a class="btn btn-clay" href="<?php echo e(route('page.show', 'booking')); ?>">Book Now</a>
    </div>
</header>
<div class="nav-backdrop" hidden></div>
<?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/partials/header.blade.php ENDPATH**/ ?>