<?php
    $current = $page->slug ?? (request()->routeIs('home') ? 'home' : request()->path());
    $tel = preg_replace('/\s+/', '', setting('phone_primary', '+918921525086'));
    $items = [
        [
            'key' => 'home',
            'label' => 'Home',
            'url' => route('home'),
            'active' => request()->routeIs('home') || $current === 'home',
            'icon' => '<path d="M4 10.5 12 4l8 6.5V20a1 1 0 0 1-1 1h-5v-6H10v6H5a1 1 0 0 1-1-1v-9.5z"/>',
        ],
        [
            'key' => 'stay',
            'label' => 'Stay',
            'url' => route('page.show', 'stay'),
            'active' => $current === 'stay',
            'icon' => '<path d="M3 11h18v9H3v-9zm2-6h14l1 4H4l1-4zm1 8v5h4v-5H6zm8 0v5h4v-5h-4z"/>',
        ],
        [
            'key' => 'booking',
            'label' => 'Book',
            'url' => route('page.show', 'booking'),
            'active' => $current === 'booking',
            'primary' => true,
            'icon' => '<path d="M7 3h2v2h6V3h2v2h3v16H4V5h3V3zm13 7H6v9h14v-9z"/>',
        ],
        [
            'key' => 'gallery',
            'label' => 'Gallery',
            'url' => route('page.show', 'gallery'),
            'active' => $current === 'gallery',
            'icon' => '<path d="M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1zm1 2v10h14V7H5zm2 2h4v4H7V9zm6 1 4 5H9l2-2.5L13 10z"/>',
        ],
        [
            'key' => 'explore',
            'label' => 'Nearby',
            'url' => route('page.show', 'explore'),
            'active' => $current === 'explore',
            'icon' => '<path fill-rule="evenodd" d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/>',
        ],
    ];
?>
<nav class="mobile-bar" aria-label="Quick actions">
    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a
            class="mobile-bar__item<?php echo e(! empty($item['primary']) ? ' is-primary' : ''); ?><?php echo e(! empty($item['active']) ? ' is-active' : ''); ?>"
            href="<?php echo e($item['url']); ?>"
            <?php if(! empty($item['active'])): ?> aria-current="page" <?php endif; ?>
        >
            <span class="mobile-bar__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"><?php echo $item['icon']; ?></svg>
            </span>
            <span class="mobile-bar__label"><?php echo e($item['label']); ?></span>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</nav>
<a class="mobile-bar-call" href="tel:<?php echo e($tel); ?>" aria-label="Call to book">
    <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="currentColor" d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.2 1.2.4 2.5.6 3.8.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.6 21 3 13.4 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.8.1.4 0 .8-.3 1.1L6.6 10.8z"/></svg>
</a>
<?php /**PATH C:\xampp_lite_8_5\www\ixora-homestay\resources\views/partials/mobile-bar.blade.php ENDPATH**/ ?>