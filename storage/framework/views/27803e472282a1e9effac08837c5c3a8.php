<?php
    $current = $page->slug ?? request()->path();
    $nav = [
        ['slug' => 'home', 'label' => 'Home', 'url' => route('home')],
        ['slug' => 'about', 'label' => 'About', 'url' => route('page.show', 'about')],
        ['slug' => 'events', 'label' => 'Events', 'url' => route('page.show', 'events')],
        ['slug' => 'explore', 'label' => 'Explore', 'url' => route('page.show', 'explore')],
        ['slug' => 'gallery', 'label' => 'Gallery', 'url' => route('page.show', 'gallery')],
        ['slug' => 'contact', 'label' => 'Contact', 'url' => route('page.show', 'contact')],
    ];
    $phoneTel = preg_replace('/\s+/', '', setting('phone_primary', '+918921525086'));
?>
<nav class="nav" id="site-nav" aria-label="Primary">
    <div class="nav-mobile-head">
        <p class="nav-mobile-kicker"><?php echo e(setting('brand_name', 'IXORA')); ?></p>
        <p class="nav-mobile-title">Where would you like to go?</p>
    </div>

    <div class="nav-links">
        <?php $__currentLoopData = $nav; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a
                class="nav-link<?php echo e(($current === $item['slug'] || ($item['slug'] === 'home' && request()->routeIs('home'))) ? ' is-active' : ''); ?>"
                href="<?php echo e($item['url']); ?>"
                <?php if($current === $item['slug'] || ($item['slug'] === 'home' && request()->routeIs('home'))): ?> aria-current="page" <?php endif; ?>
            >
                <span><?php echo e($item['label']); ?></span>
                <span class="nav-link-arrow" aria-hidden="true">›</span>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="nav-mobile-cta">
        <a class="btn btn-clay nav-mobile-book" href="<?php echo e(route('page.show', 'booking')); ?>">Book Now</a>
        <a class="btn btn-line nav-mobile-call" href="tel:<?php echo e($phoneTel); ?>">Call hosts</a>
    </div>
</nav>
<?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/partials/navigation.blade.php ENDPATH**/ ?>