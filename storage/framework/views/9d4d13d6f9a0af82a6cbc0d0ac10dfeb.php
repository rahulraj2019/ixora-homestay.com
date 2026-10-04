<?php
    $type = $type ?? 'success';
    $eyebrow = $eyebrow ?? ($type === 'success' ? 'All set' : 'Please check');
    $title = $title ?? ($type === 'success' ? 'Thank you!' : 'Something needs attention');
    $message = $message ?? '';
?>
<div class="flash-card flash-<?php echo e($type); ?>" id="<?php echo e($id ?? ''); ?>" role="<?php echo e($type === 'success' ? 'status' : 'alert'); ?>">
    <div class="flash-icon" aria-hidden="true">
        <?php if($type === 'success'): ?>
            ✓
        <?php else: ?>
            !
        <?php endif; ?>
    </div>
    <div class="flash-body">
        <p class="flash-eyebrow"><?php echo e($eyebrow); ?></p>
        <h2 class="flash-title"><?php echo e($title); ?></h2>
        <?php if($message): ?>
            <p class="flash-text"><?php echo e($message); ?></p>
        <?php endif; ?>
        <?php if(isset($reference)): ?>
            <p class="flash-ref"><strong>Reference:</strong> <span><?php echo e($reference); ?></span></p>
        <?php endif; ?>
        <?php if(isset($actions)): ?>
            <div class="flash-actions">
                <?php echo $actions; ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/partials/flash-card.blade.php ENDPATH**/ ?>