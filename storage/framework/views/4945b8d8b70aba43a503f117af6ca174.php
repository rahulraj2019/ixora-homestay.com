<?php if($paginator->hasPages()): ?>
    <nav class="admin-pagination" role="navigation" aria-label="Pagination">
        <?php if($paginator->onFirstPage()): ?>
            <span class="admin-pagination__btn is-disabled" aria-disabled="true">Prev</span>
        <?php else: ?>
            <a class="admin-pagination__btn" href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev">Prev</a>
        <?php endif; ?>

        <div class="admin-pagination__pages">
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(is_string($element)): ?>
                    <span class="admin-pagination__ellipsis"><?php echo e($element); ?></span>
                <?php endif; ?>

                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <span class="admin-pagination__page is-current" aria-current="page"><?php echo e($page); ?></span>
                        <?php else: ?>
                            <a class="admin-pagination__page" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if($paginator->hasMorePages()): ?>
            <a class="admin-pagination__btn" href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next">Next</a>
        <?php else: ?>
            <span class="admin-pagination__btn is-disabled" aria-disabled="true">Next</span>
        <?php endif; ?>
    </nav>
<?php endif; ?>
<?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/vendor/pagination/admin.blade.php ENDPATH**/ ?>