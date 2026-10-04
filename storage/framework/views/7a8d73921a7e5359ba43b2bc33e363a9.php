<?php $__env->startSection('body_class', ($page->slug ?? '') === 'home' ? 'home' : ''); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $template = $page->template ?: $page->slug;
        $view = 'frontend.templates.'.$template;
        $hasTemplate = view()->exists($view);
        $blocks = $page->activeBlocks;
    ?>

    <?php if($hasTemplate): ?>
        <?php echo $__env->make($view, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php else: ?>
        <section class="page-hero">
            <div class="wrap">
                <p class="eyebrow"><?php echo e($page->slug); ?></p>
                <h1><?php echo e($page->title); ?></h1>
                <?php if($page->meta_description): ?>
                    <p class="lede"><?php echo e($page->meta_description); ?></p>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php $__currentLoopData = $blocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $block): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->first([
            'frontend.blocks.'.$block->block_type,
            'frontend.blocks.generic',
        ], ['block' => $block], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp_lite_8_5\www\ixora-homestay\resources\views/frontend/page.blade.php ENDPATH**/ ?>