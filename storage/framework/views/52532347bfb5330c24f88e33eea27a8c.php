<section class="page-hero reviews-hero">
    <div class="wrap reviews-hero-inner">
        <div class="reviews-hero-copy">
            <p class="eyebrow">Guest reviews</p>
            <h1>Stories from stays at IXORA</h1>
            <p class="lede">Honest notes from families and celebrations at our Niduvaloor homestay in Kannur — plus a place to share yours.</p>
            <?php if(($reviewsCount ?? 0) > 0): ?>
                <div class="reviews-score reviews-score-hero" data-reviews-score>
                    <strong data-avg><?php echo e(number_format((float) ($reviewsAverage ?? 5), 1)); ?></strong>
                    <span class="stars" aria-hidden="true">★★★★★</span>
                    <span class="muted" data-count-label>from <?php echo e($reviewsCount); ?> guest <?php echo e(\Illuminate\Support\Str::plural('review', $reviewsCount)); ?></span>
                </div>
            <?php endif; ?>
        </div>
        <a class="reviews-hero-cta" href="#review-panel">
            <span class="reviews-hero-cta-mark" aria-hidden="true">★</span>
            <span>
                <strong>Share your stay</strong>
                <em>Takes about a minute</em>
            </span>
        </a>
    </div>
</section>

<section class="section reviews-page" id="reviews" aria-labelledby="reviews-page-heading">
    <div class="wrap">
        <div class="reviews-page-layout">
            <div class="reviews-page-main">
                <div class="section-head reviews-page-head">
                    <div>
                        <p class="eyebrow">All reviews</p>
                        <h2 id="reviews-page-heading">Guest stories</h2>
                    </div>
                    <?php if(($reviewsCount ?? 0) > 0): ?>
                        <p class="muted reviews-page-count"><?php echo e($reviewsCount); ?> published</p>
                    <?php endif; ?>
                </div>
                <div class="reviews-grid" data-reviews-list>
                    <?php $__empty_1 = true; $__currentLoopData = ($reviews ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <article class="review-card">
                            <div class="stars" aria-label="<?php echo e($review->rating); ?> out of 5 stars"><?php echo e(str_repeat('★', (int) $review->rating)); ?><?php echo e(str_repeat('☆', 5 - (int) $review->rating)); ?></div>
                            <p><?php echo e($review->message); ?></p>
                            <div class="review-meta">
                                <div class="review-avatar" aria-hidden="true"><?php echo e(\Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($review->name, 0, 1))); ?></div>
                                <div>
                                    <strong><?php echo e($review->name); ?></strong>
                                    <span><?php echo e($review->location ?: 'Guest'); ?></span>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="muted reviews-empty">No published reviews yet. Be the first to share your stay.</p>
                    <?php endif; ?>
                </div>
            </div>

            <aside class="review-form-card" id="review-panel">
                <div class="review-form-card-glow" aria-hidden="true"></div>
                <div class="review-form-card-top">
                    <span class="review-form-badge">Your voice</span>
                    <p class="review-form-kicker">Help the next family choose with confidence</p>
                </div>
                <?php echo $__env->make('partials.review-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </aside>
        </div>
    </div>
</section>
<?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/frontend/templates/reviews.blade.php ENDPATH**/ ?>