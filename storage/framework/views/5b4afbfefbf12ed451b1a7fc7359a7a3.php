<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
<?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
    $loc = $page->slug === 'home' ? url('/') : url('/'.$page->slug);
    $priority = match ($page->slug) {
        'home' => '1.0',
        'stay', 'booking', 'events', 'gallery' => '0.9',
        'explore', 'faq', 'contact' => '0.8',
        default => '0.6',
    };
?>
    <url>
        <loc><?php echo e($loc); ?></loc>
        <lastmod><?php echo e($page->updated_at?->toAtomString()); ?></lastmod>
        <changefreq><?php echo e($page->slug === 'home' ? 'daily' : 'weekly'); ?></changefreq>
        <priority><?php echo e($priority); ?></priority>
    </url>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</urlset>
<?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/frontend/sitemap-xml.blade.php ENDPATH**/ ?>