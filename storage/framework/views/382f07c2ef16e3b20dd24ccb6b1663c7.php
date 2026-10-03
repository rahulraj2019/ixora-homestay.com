<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="theme-color" content="#12291f">
    <title><?php echo $__env->yieldContent('title', 'Admin'); ?> — IXORA</title>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/admin.css')); ?>?v=13">
</head>
<body class="admin">
<?php
    $navGroups = [
        [
            'label' => 'Overview',
            'items' => [
                ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'match' => 'admin.dashboard'],
            ],
        ],
        [
            'label' => 'Operations',
            'items' => [
                ['label' => 'Bookings', 'route' => 'admin.bookings.index', 'match' => 'admin.bookings.*'],
                ['label' => 'Enquiries', 'route' => 'admin.enquiries.index', 'match' => 'admin.enquiries.*'],
                ['label' => 'Reviews', 'route' => 'admin.reviews.index', 'match' => 'admin.reviews.*'],
            ],
        ],
        [
            'label' => 'Website',
            'items' => [
                ['label' => 'Pages', 'route' => 'admin.pages.index', 'match' => 'admin.pages.*'],
                ['label' => 'FAQs', 'route' => 'admin.faqs.index', 'match' => 'admin.faqs.*'],
                ['label' => 'Media Library', 'route' => 'admin.media.index', 'match' => 'admin.media.*'],
                ['label' => 'Site Images', 'route' => 'admin.site-images.index', 'match' => 'admin.site-images.*'],
                ['label' => 'Nearby places', 'route' => 'admin.nearby-places.index', 'match' => 'admin.nearby-places.*'],
            ],
        ],
        [
            'label' => 'System',
            'items' => array_values(array_filter([
                ['label' => 'SEO / Redirects', 'route' => 'admin.seo.redirects', 'match' => 'admin.seo.*'],
                ['label' => 'Settings', 'route' => 'admin.settings.index', 'match' => 'admin.settings.*'],
                ['label' => 'My account', 'route' => 'admin.profile.edit', 'match' => 'admin.profile.*'],
                auth()->user()?->isSuperAdmin()
                    ? ['label' => 'Users', 'route' => 'admin.users.index', 'match' => 'admin.users.*']
                    : null,
                ['label' => 'Activity', 'route' => 'admin.activity.index', 'match' => 'admin.activity.*'],
            ])),
        ],
    ];
?>
<div class="admin-shell">
    <aside class="admin-sidebar" id="admin-sidebar">
        <div class="brand">
            <span class="brand__mark" aria-hidden="true">I</span>
            <div>
                <strong>IXORA</strong>
                <small>Admin panel</small>
            </div>
        </div>
        <nav aria-label="Admin">
            <?php $__currentLoopData = $navGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p class="nav-group"><?php echo e($group['label']); ?></p>
                <?php $__currentLoopData = $group['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a
                        href="<?php echo e(route($item['route'])); ?>"
                        class="<?php echo e(request()->routeIs($item['match']) ? 'active' : ''); ?>"
                    ><?php echo e($item['label']); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <p class="nav-group">Shortcuts</p>
            <a href="<?php echo e(route('home')); ?>" target="_blank" rel="noopener">View website ↗</a>
        </nav>
        <div class="sidebar-footer">
            <a class="sidebar-user sidebar-user--link<?php echo e(request()->routeIs('admin.profile.*') ? ' is-active' : ''); ?>" href="<?php echo e(route('admin.profile.edit')); ?>">
                <span class="sidebar-user__avatar" aria-hidden="true"><?php echo e(strtoupper(substr(auth()->user()->name ?? 'A', 0, 1))); ?></span>
                <div>
                    <strong><?php echo e(auth()->user()->name ?? 'Admin'); ?></strong>
                    <small><?php echo e(auth()->user()->email ?? ''); ?></small>
                </div>
            </a>
            <form method="POST" action="<?php echo e(route('admin.logout')); ?>" class="logout">
                <?php echo csrf_field(); ?>
                <button type="submit">Logout</button>
            </form>
        </div>
    </aside>
    <div class="admin-main">
        <header class="admin-top">
            <div class="admin-top__title">
                <button type="button" class="nav-burger" id="admin-nav-toggle" aria-controls="admin-sidebar" aria-expanded="false" aria-label="Open menu">
                    <span></span><span></span><span></span>
                </button>
                <div>
                    <h1><?php echo $__env->yieldContent('title', 'Dashboard'); ?></h1>
                    <?php if (! empty(trim($__env->yieldContent('subtitle')))): ?>
                        <p class="admin-top__subtitle"><?php echo $__env->yieldContent('subtitle'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="admin-top__meta">
                <a class="user-chip" href="<?php echo e(route('admin.profile.edit')); ?>"><?php echo e(auth()->user()->name ?? ''); ?></a>
            </div>
        </header>
        <?php if(session('success')): ?>
            <div class="alert ok"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert err"><?php echo e(session('error')); ?></div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="alert err">
                <ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
            </div>
        <?php endif; ?>
        <div class="admin-content">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
</div>
<div class="admin-backdrop" id="admin-backdrop" hidden></div>
<script>
(() => {
    const shell = document.querySelector('.admin-shell');
    const toggle = document.getElementById('admin-nav-toggle');
    const backdrop = document.getElementById('admin-backdrop');
    const sidebar = document.getElementById('admin-sidebar');
    if (!shell || !toggle) return;

    const setOpen = (open) => {
        shell.classList.toggle('nav-open', open);
        document.body.classList.toggle('nav-locked', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
        if (backdrop) backdrop.hidden = !open;
    };

    toggle.addEventListener('click', () => setOpen(!shell.classList.contains('nav-open')));
    backdrop?.addEventListener('click', () => setOpen(false));
    sidebar?.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
            if (window.matchMedia('(max-width: 860px)').matches) {
                setOpen(false);
            }
        });
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && shell.classList.contains('nav-open')) {
            setOpen(false);
            toggle.focus();
        }
    });
    window.addEventListener('resize', () => {
        if (!window.matchMedia('(max-width: 860px)').matches) {
            setOpen(false);
        }
    });
})();
</script>
</body>
</html>
<?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/admin/layouts/app.blade.php ENDPATH**/ ?>