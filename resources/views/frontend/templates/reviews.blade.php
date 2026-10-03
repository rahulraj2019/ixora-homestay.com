<section class="page-hero reviews-hero">
    <div class="wrap reviews-hero-inner">
        <div class="reviews-hero-copy">
            <p class="eyebrow">Guest reviews</p>
            <h1>Stories from stays at IXORA</h1>
            <p class="lede">Honest notes from families and celebrations at our Niduvaloor homestay in Kannur — plus a place to share yours.</p>
            @if(($reviewsCount ?? 0) > 0)
                <div class="reviews-score reviews-score-hero" data-reviews-score>
                    <strong data-avg>{{ number_format((float) ($reviewsAverage ?? 5), 1) }}</strong>
                    <span class="stars" aria-hidden="true">★★★★★</span>
                    <span class="muted" data-count-label>from {{ $reviewsCount }} guest {{ \Illuminate\Support\Str::plural('review', $reviewsCount) }}</span>
                </div>
            @endif
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
                    @if(($reviewsCount ?? 0) > 0)
                        <p class="muted reviews-page-count">{{ $reviewsCount }} published</p>
                    @endif
                </div>
                <div class="reviews-grid" data-reviews-list>
                    @forelse(($reviews ?? collect()) as $review)
                        <article class="review-card">
                            <div class="stars" aria-label="{{ $review->rating }} out of 5 stars">{{ str_repeat('★', (int) $review->rating) }}{{ str_repeat('☆', 5 - (int) $review->rating) }}</div>
                            <p>{{ $review->message }}</p>
                            <div class="review-meta">
                                <div class="review-avatar" aria-hidden="true">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($review->name, 0, 1)) }}</div>
                                <div>
                                    <strong>{{ $review->name }}</strong>
                                    <span>{{ $review->location ?: 'Guest' }}</span>
                                </div>
                            </div>
                        </article>
                    @empty
                        <p class="muted reviews-empty">No published reviews yet. Be the first to share your stay.</p>
                    @endforelse
                </div>
            </div>

            <aside class="review-form-card" id="review-panel">
                <div class="review-form-card-glow" aria-hidden="true"></div>
                <div class="review-form-card-top">
                    <span class="review-form-badge">Your voice</span>
                    <p class="review-form-kicker">Help the next family choose with confidence</p>
                </div>
                @include('partials.review-form')
            </aside>
        </div>
    </div>
</section>
