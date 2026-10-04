<div data-review-success hidden></div>
<div data-review-form-wrap>
    <p class="eyebrow">Share yours</p>
    <h3>Add a review</h3>
    <p class="review-form-lead">Tell future guests about your stay or celebration. Your email stays private and is never shown on the site.</p>
    <form id="review-form" class="review-form form-readable" novalidate>
        <div class="form-grid">
            <div class="field">
                <label for="review-name">Name</label>
                <input id="review-name" name="name" type="text" required maxlength="80" autocomplete="name" placeholder="Your name">
            </div>
            <div class="field">
                <label for="review-email">Email</label>
                <input id="review-email" name="email" type="email" required maxlength="120" autocomplete="email" placeholder="you@email.com">
            </div>
            <div class="field full">
                <label for="review-location">Location</label>
                <input id="review-location" name="location" type="text" required maxlength="100" autocomplete="address-level2" placeholder="City, state or country">
            </div>
            <div class="field full">
                <label id="review-rating-label">Your rating</label>
                <div class="rating-stars" role="radiogroup" aria-labelledby="review-rating-label">
                    <label class="rating-star">
                        <input type="radio" name="rating" value="5" checked>
                        <span aria-hidden="true">★</span>
                        <em class="sr-only">5 stars</em>
                    </label>
                    <label class="rating-star">
                        <input type="radio" name="rating" value="4">
                        <span aria-hidden="true">★</span>
                        <em class="sr-only">4 stars</em>
                    </label>
                    <label class="rating-star">
                        <input type="radio" name="rating" value="3">
                        <span aria-hidden="true">★</span>
                        <em class="sr-only">3 stars</em>
                    </label>
                    <label class="rating-star">
                        <input type="radio" name="rating" value="2">
                        <span aria-hidden="true">★</span>
                        <em class="sr-only">2 stars</em>
                    </label>
                    <label class="rating-star">
                        <input type="radio" name="rating" value="1">
                        <span aria-hidden="true">★</span>
                        <em class="sr-only">1 star</em>
                    </label>
                </div>
            </div>
            <div class="field full">
                <label for="review-message">Your review</label>
                <textarea id="review-message" name="message" required minlength="10" maxlength="800" placeholder="What did you love about your stay or celebration?"></textarea>
            </div>
            <div class="hp-field" aria-hidden="true">
                <label for="review-website">Website</label>
                <input id="review-website" name="website" type="text" tabindex="-1" autocomplete="off">
            </div>
        </div>
        <p class="review-form-actions">
            <button class="btn btn-gold review-form-submit" type="submit">Submit review</button>
        </p>
        <p class="review-form-note">Reviews appear after a quick host check — usually within a day.</p>
        <p class="review-form-status" data-review-status role="status" aria-live="polite"></p>
    </form>
</div>
<?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/partials/review-form.blade.php ENDPATH**/ ?>