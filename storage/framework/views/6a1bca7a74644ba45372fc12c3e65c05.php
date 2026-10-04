<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php echo $__env->make('partials.seo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <link rel="icon" href="<?php echo e(setting('favicon') ? asset('storage/'.setting('favicon')) : asset('assets/images/ixora-homestay-logo.webp')); ?>" type="image/webp">
    <link rel="preload" href="<?php echo e(asset('assets/fonts/gf-18.woff2')); ?>" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?php echo e(asset('assets/fonts/gf-5.woff2')); ?>" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="<?php echo e(asset_versioned('assets/css/fonts.css')); ?>" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="<?php echo e(asset_versioned('assets/css/fonts.css')); ?>"></noscript>
    
    <style>
      .header{position:fixed;top:16px;left:50%;transform:translateX(-50%);z-index:40;height:68px;display:grid;grid-template-columns:auto minmax(0,1fr) auto;align-items:center;column-gap:12px;padding:0 14px 0 18px;width:min(1240px,calc(100% - 32px));max-width:calc(100% - 32px);box-sizing:border-box}
      .header-end{display:flex;align-items:center;justify-content:flex-end;gap:8px;justify-self:end;flex-shrink:0}
      .nav{display:flex;align-items:center;justify-content:center;justify-self:center;min-width:0}
      .nav-toggle{display:none}
      .wa{position:fixed;right:18px;bottom:22px;z-index:80;width:58px;height:58px;border-radius:50%;background:#25d366;display:grid;place-items:center}
      @media (max-width:860px){
        .nav{display:flex;flex-direction:column;opacity:0;visibility:hidden;pointer-events:none;position:absolute;top:calc(100% + 12px);left:0;right:0}
        .nav.open{opacity:1;visibility:visible;pointer-events:auto}
        .nav-toggle{display:grid;place-items:center}
        .header-end .btn-clay{display:none}
        .nav-mobile-head,.nav-mobile-cta{display:none}
        .wa{right:14px;bottom:calc(86px + env(safe-area-inset-bottom, 0px));width:52px;height:52px;z-index:80}
        .mobile-bar-call{display:grid;place-items:center;position:fixed;left:14px;bottom:calc(86px + env(safe-area-inset-bottom, 0px));z-index:80;width:46px;height:46px;border-radius:50%;background:var(--clay,#c45d3a);color:#fff}
      }
      .section{content-visibility:auto;contain-intrinsic-size:1px 720px}
      .hero,.header{content-visibility:visible}
    </style>
    <link rel="stylesheet" href="<?php echo e(asset_versioned('assets/css/style.min.css')); ?>">
    <?php echo $__env->yieldPushContent('head'); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
    <?php echo $__env->make('partials.schema', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body class="<?php echo $__env->yieldContent('body_class'); ?>">
    <a class="skip-link" href="#main-content">Skip to content</a>
    <?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main id="main-content">
        <?php if(session('success') && ! session('booking_reference') && ! session('contact_success')): ?>
            <div class="wrap" style="padding-top:1rem">
                <?php echo $__env->make('partials.flash-card', [
                    'type' => 'success',
                    'eyebrow' => 'Done',
                    'title' => 'Thank you',
                    'message' => session('success'),
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="wrap" style="padding-top:1rem">
                <?php echo $__env->make('partials.flash-card', [
                    'type' => 'error',
                    'eyebrow' => 'Error',
                    'title' => 'Something went wrong',
                    'message' => session('error'),
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.whatsapp', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('partials.mobile-bar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="lightbox" hidden>
      <button type="button" aria-label="Close">✕</button>
      <div class="lightbox-stage">
        <img alt="" width="1200" height="800" decoding="async" hidden>
        <video class="lightbox-video" controls playsinline preload="none" hidden></video>
      </div>
    </div>
    <script>
        window.IXORA = {
            routes: {
                booking: <?php echo json_encode(route('booking.store'), 15, 512) ?>,
                reviews: <?php echo json_encode(route('reviews.index'), 15, 512) ?>,
                reviewsStore: <?php echo json_encode(route('reviews.store'), 15, 512) ?>,
                bookingPage: <?php echo json_encode(route('page.show', 'booking'), 512) ?>,
            },
            csrf: <?php echo json_encode(csrf_token(), 15, 512) ?>,
            whatsapp: <?php echo json_encode(whatsapp_number(), 15, 512) ?>,
            whatsappMessage: <?php echo json_encode(whatsapp_message(), 15, 512) ?>,
            whatsappUrl: <?php echo json_encode(whatsapp_url(), 15, 512) ?>,
        };
    </script>
    <script src="<?php echo e(asset_versioned('assets/js/main.min.js')); ?>" defer></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp_lite_8_5\www\ixora-homestay\resources\views/layouts/app.blade.php ENDPATH**/ ?>