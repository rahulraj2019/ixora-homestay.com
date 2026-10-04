<?php if($image): ?>
<img
    src="<?php echo e($image['url']); ?>"
    <?php if(!empty($image['srcset'])): ?> srcset="<?php echo e($image['srcset']); ?>" <?php endif; ?>
    <?php if(!empty($image['sizes'])): ?> sizes="<?php echo e($image['sizes']); ?>" <?php endif; ?>
    alt="<?php echo e($image['alt']); ?>"
    <?php if($image['width']): ?> width="<?php echo e($image['width']); ?>" <?php endif; ?>
    <?php if($image['height']): ?> height="<?php echo e($image['height']); ?>" <?php endif; ?>
    <?php echo e($attributes->merge(['decoding' => 'async'])); ?>

>
<?php endif; ?>
<?php /**PATH C:\xampp_lite_8_5\www\ixora-homestay\resources\views/components/site-img.blade.php ENDPATH**/ ?>