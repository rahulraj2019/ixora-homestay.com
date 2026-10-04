<section class="page-hero">
    <div class="wrap" style="max-width:760px">
        <p class="eyebrow">About IXORA Homestay Kannur...</p>
        <h1><?php echo e($page->title); ?></h1>
        <?php if($page->meta_description): ?>
            <p class="lede"><?php echo e($page->meta_description); ?></p>
        <?php endif; ?>
        <p><a class="btn btn-dark" href="<?php echo e(route('page.show', 'stay')); ?>">See family rooms</a> <a class="btn btn-line" href="<?php echo e(route('page.show', 'booking')); ?>">Book Homestay in Kannur</a></p>
    </div>
</section>
<?php /**PATH C:\xampp_lite_8_5\www\ixora-homestay\resources\views/frontend/templates/about.blade.php ENDPATH**/ ?>