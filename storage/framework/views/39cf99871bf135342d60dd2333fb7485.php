<?php
  $heroImage = app(\App\Services\SiteImageService::class)->get('home.hero');
?>
<?php $__env->startPush('head'); ?>
  <?php if($heroImage): ?>
    <link
      rel="preload"
      as="image"
      href="<?php echo e($heroImage['url']); ?>"
      <?php if(!empty($heroImage['srcset'])): ?> imagesrcset="<?php echo e($heroImage['srcset']); ?>" <?php endif; ?>
      <?php if(!empty($heroImage['sizes'])): ?> imagesizes="<?php echo e($heroImage['sizes']); ?>" <?php endif; ?>
      fetchpriority="high"
      <?php if(str_ends_with($heroImage['url'], '.webp')): ?> type="image/webp" <?php endif; ?>
    >
  <?php endif; ?>
<?php $__env->stopPush(); ?>

<section class="hero">
    <?php if (isset($component)) { $__componentOriginald67ae95db5947856cc75436a3fd8df98 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald67ae95db5947856cc75436a3fd8df98 = $attributes; } ?>
<?php $component = App\View\Components\SiteImg::resolve(['slotKey' => 'home.hero'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('site-img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\SiteImg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'hero-bg','fetchpriority' => 'high']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald67ae95db5947856cc75436a3fd8df98)): ?>
<?php $attributes = $__attributesOriginald67ae95db5947856cc75436a3fd8df98; ?>
<?php unset($__attributesOriginald67ae95db5947856cc75436a3fd8df98); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald67ae95db5947856cc75436a3fd8df98)): ?>
<?php $component = $__componentOriginald67ae95db5947856cc75436a3fd8df98; ?>
<?php unset($__componentOriginald67ae95db5947856cc75436a3fd8df98); ?>
<?php endif; ?>
    <div class="hero-shade"></div>
    <div class="wrap hero-content">
      <p class="eyebrow">Best Homestay in Kannur · Near Thaliparamba</p>
      <h1>Ixora Homestay<br>for Family Stays<br><em>&amp; Celebrations</em></h1>
      <p class="lede">Book an affordable family homestay in Kannur at Niduvaloor Gate — private 2 BHK home stay in Kannur Kerala near Thaliparamba, with kitchen, courtyard, parking and easy day trips.</p>
      <div class="hero-actions">
        <a class="btn btn-gold" href="<?php echo e(route('page.show', 'booking')); ?>">Book Homestay in Kannur</a>
        <a class="btn btn-ghost" href="<?php echo e(route('page.show', 'gallery')); ?>">View the venue</a>
        <?php
          $tourVideoPath = public_path('assets/videos/ixora-homestay-property-tour.mp4');
          $tourPosterPath = public_path('assets/images/ixora-homestay-tour-poster.jpg');
          $hasTourVideo = is_file($tourVideoPath) && filesize($tourVideoPath) > 0;
        ?>
        <?php if($hasTourVideo): ?>
          <button
            type="button"
            class="btn btn-ghost btn-watch-tour"
            data-video-open
            data-video-src="<?php echo e(asset('assets/videos/ixora-homestay-property-tour.mp4')); ?>?v=<?php echo e(filemtime($tourVideoPath)); ?>"
            data-video-poster="<?php echo e(asset('assets/images/ixora-homestay-tour-poster.jpg')); ?>?v=<?php echo e(is_file($tourPosterPath) ? filemtime($tourPosterPath) : time()); ?>"
            data-video-title="IXORA Homestay property tour"
          >
            <span class="btn-watch-icon" aria-hidden="true">
              <svg viewBox="0 0 24 24" width="18" height="18" focusable="false"><path fill="currentColor" d="M8 5.14v13.72L19 12 8 5.14z"/></svg>
            </span>
            Watch property tour
          </button>
        <?php endif; ?>
      </div>
      <div class="hero-pills">
        <span class="pill">Family Homestay in Kannur</span>
        <span class="pill">Near Thaliparamba</span>
        <span class="pill">Private 2 BHK</span>
      </div>
    </div>
  </section>

  <div class="wrap">
    <form class="book-card form-readable" data-search>
      <div class="field">
        <label for="checkin">Check-in</label>
        <input id="checkin" name="checkin" type="date">
      </div>
      <div class="field">
        <label for="checkout">Check-out</label>
        <input id="checkout" name="checkout" type="date">
      </div>
      <div class="field field-guests">
        <label>Guests</label>
        <div class="guest-pair" role="group" aria-label="Guest counts">
          <div class="guest-pair-item">
            <div class="stepper guest-stepper" data-step data-min="1" data-max="30" data-target="#home-adults">
              <button type="button" data-step="minus" aria-label="Fewer adults">−</button>
              <div class="guest-stepper-meta">
                <span class="guest-pair-label">Adults</span>
                <strong data-count>2</strong>
              </div>
              <button type="button" data-step="plus" aria-label="More adults">+</button>
            </div>
            <input id="home-adults" name="adults" type="hidden" value="2">
          </div>
          <div class="guest-pair-item">
            <div class="stepper guest-stepper" data-step data-min="0" data-max="30" data-target="#home-children">
              <button type="button" data-step="minus" aria-label="Fewer children">−</button>
              <div class="guest-stepper-meta">
                <span class="guest-pair-label">Children</span>
                <strong data-count>0</strong>
              </div>
              <button type="button" data-step="plus" aria-label="More children">+</button>
            </div>
            <input id="home-children" name="children" type="hidden" value="0">
          </div>
        </div>
      </div>
      <div class="field">
        <label for="type">Booking type</label>
        <select id="type" name="type">
          <option value="homestay">Homestay</option>
          <option value="birthday">Birthday Party</option>
          <option value="engagement">Engagement</option>
          <option value="family">Family Gathering</option>
          <option value="friends">Friends Get-together</option>
          <option value="custom">Custom Event</option>
        </select>
      </div>
      <button class="btn btn-dark" type="submit">Search</button>
      <p class="guest-note book-card-note">Children under 10 · Age 10+ count as adults</p>
    </form>
  </div>

  <section class="section">
    <div class="wrap split">
      <div>
        <p class="eyebrow">Niduvaloor Homestay</p>
        <h2>Affordable family homestay in Kannur with private house</h2>
        <p class="lede">Looking for a comfortable Kannur homestay for family or friends? IXORA gives you the full private 2 BHK — bedrooms, living area, kitchen and dining — plus courtyard space for a peaceful weekend stay in Kannur Kerala.</p>
        <div class="amenity-grid">
          <div class="amenity"><i></i> 2 Bedrooms</div>
          <div class="amenity"><i></i> Living area</div>
          <div class="amenity"><i></i> Kitchen</div>
          <div class="amenity"><i></i> Dining room</div>
          <div class="amenity"><i></i> Private courtyard</div>
          <div class="amenity"><i></i> Event stage</div>
          <div class="amenity"><i></i> Campfire</div>
          <div class="amenity"><i></i> BBQ grill</div>
          <div class="amenity"><i></i> Carrom &amp; games</div>
          <div class="amenity"><i></i> Photo point</div>
          <div class="amenity"><i></i> Parking</div>
        </div>
        <a class="btn btn-dark" href="<?php echo e(route('page.show', 'stay')); ?>">Explore the venue</a>
      </div>
      <div class="photo-stack">
        <div class="tall"><?php if (isset($component)) { $__componentOriginald67ae95db5947856cc75436a3fd8df98 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald67ae95db5947856cc75436a3fd8df98 = $attributes; } ?>
<?php $component = App\View\Components\SiteImg::resolve(['slotKey' => 'home.stack_tall'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('site-img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\SiteImg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['loading' => 'lazy']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald67ae95db5947856cc75436a3fd8df98)): ?>
<?php $attributes = $__attributesOriginald67ae95db5947856cc75436a3fd8df98; ?>
<?php unset($__attributesOriginald67ae95db5947856cc75436a3fd8df98); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald67ae95db5947856cc75436a3fd8df98)): ?>
<?php $component = $__componentOriginald67ae95db5947856cc75436a3fd8df98; ?>
<?php unset($__componentOriginald67ae95db5947856cc75436a3fd8df98); ?>
<?php endif; ?></div>
        <div class="stack">
          <?php if (isset($component)) { $__componentOriginald67ae95db5947856cc75436a3fd8df98 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald67ae95db5947856cc75436a3fd8df98 = $attributes; } ?>
<?php $component = App\View\Components\SiteImg::resolve(['slotKey' => 'home.stack_1'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('site-img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\SiteImg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['loading' => 'lazy']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald67ae95db5947856cc75436a3fd8df98)): ?>
<?php $attributes = $__attributesOriginald67ae95db5947856cc75436a3fd8df98; ?>
<?php unset($__attributesOriginald67ae95db5947856cc75436a3fd8df98); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald67ae95db5947856cc75436a3fd8df98)): ?>
<?php $component = $__componentOriginald67ae95db5947856cc75436a3fd8df98; ?>
<?php unset($__componentOriginald67ae95db5947856cc75436a3fd8df98); ?>
<?php endif; ?>
          <?php if (isset($component)) { $__componentOriginald67ae95db5947856cc75436a3fd8df98 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald67ae95db5947856cc75436a3fd8df98 = $attributes; } ?>
<?php $component = App\View\Components\SiteImg::resolve(['slotKey' => 'home.stack_2'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('site-img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\SiteImg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['loading' => 'lazy']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald67ae95db5947856cc75436a3fd8df98)): ?>
<?php $attributes = $__attributesOriginald67ae95db5947856cc75436a3fd8df98; ?>
<?php unset($__attributesOriginald67ae95db5947856cc75436a3fd8df98); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald67ae95db5947856cc75436a3fd8df98)): ?>
<?php $component = $__componentOriginald67ae95db5947856cc75436a3fd8df98; ?>
<?php unset($__componentOriginald67ae95db5947856cc75436a3fd8df98); ?>
<?php endif; ?>
        </div>
      </div>
    </div>
  </section>

  <section class="section" style="padding-top:0">
    <div class="wrap duo">
      <article class="feature">
        <?php if (isset($component)) { $__componentOriginald67ae95db5947856cc75436a3fd8df98 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald67ae95db5947856cc75436a3fd8df98 = $attributes; } ?>
<?php $component = App\View\Components\SiteImg::resolve(['slotKey' => 'home.feature_stay'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('site-img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\SiteImg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['loading' => 'lazy']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald67ae95db5947856cc75436a3fd8df98)): ?>
<?php $attributes = $__attributesOriginald67ae95db5947856cc75436a3fd8df98; ?>
<?php unset($__attributesOriginald67ae95db5947856cc75436a3fd8df98); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald67ae95db5947856cc75436a3fd8df98)): ?>
<?php $component = $__componentOriginald67ae95db5947856cc75436a3fd8df98; ?>
<?php unset($__componentOriginald67ae95db5947856cc75436a3fd8df98); ?>
<?php endif; ?>
        <div class="shade"></div>
        <div class="copy">
          <p class="eyebrow">Stay</p>
          <h3>Stay with us</h3>
          <ul>
            <li>Private 2 BHK</li><li>Kitchen</li><li>Living room</li><li>Dining area</li><li>Courtyard</li>
          </ul>
          <a class="btn btn-gold" href="<?php echo e(route('page.show', 'stay')); ?>">View stay options</a>
        </div>
      </article>
      <article class="feature">
        <?php if (isset($component)) { $__componentOriginald67ae95db5947856cc75436a3fd8df98 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald67ae95db5947856cc75436a3fd8df98 = $attributes; } ?>
<?php $component = App\View\Components\SiteImg::resolve(['slotKey' => 'home.feature_events'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('site-img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\SiteImg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['loading' => 'lazy']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald67ae95db5947856cc75436a3fd8df98)): ?>
<?php $attributes = $__attributesOriginald67ae95db5947856cc75436a3fd8df98; ?>
<?php unset($__attributesOriginald67ae95db5947856cc75436a3fd8df98); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald67ae95db5947856cc75436a3fd8df98)): ?>
<?php $component = $__componentOriginald67ae95db5947856cc75436a3fd8df98; ?>
<?php unset($__componentOriginald67ae95db5947856cc75436a3fd8df98); ?>
<?php endif; ?>
        <div class="shade"></div>
        <div class="copy">
          <p class="eyebrow">Celebrate</p>
          <h3>Celebrate with us</h3>
          <ul>
            <li>Birthday parties</li><li>Engagements</li><li>Family functions</li><li>Get-togethers</li>
          </ul>
          <a class="btn btn-gold" href="<?php echo e(route('page.show', 'events')); ?>">View event packages</a>
        </div>
      </article>
    </div>
  </section>

  <section class="section home-places-band" id="nearby-places" aria-labelledby="nearby-places-heading">
    <div class="wrap">
      <?php
        $homePlaces = nearby_home_highlights(6);
        $homePlaceFilters = [
          'temple' => 'Temples',
          'hill' => 'Hills',
          'waterfall' => 'Waterfalls',
          'beach' => 'Beach',
          'heritage' => 'Heritage',
          'family' => 'Family',
        ];
        $homePlaceCats = collect($homePlaces)
          ->flatMap(fn (array $place) => preg_split('/\s+/', trim((string) ($place['cat'] ?? ''))) ?: [])
          ->filter()
          ->unique()
          ->all();
      ?>
      <div class="home-places-head">
        <div>
          <p class="eyebrow">Near the homestay</p>
          <h2 id="nearby-places-heading">Best places to visit near IXORA</h2>
          <p class="lede places-intro">A curated mix of temples, hills, waterfalls, beach and heritage — tap a tab to filter, then open Explore for the full list.</p>
        </div>
        <a class="btn btn-line" href="<?php echo e(route('page.show', 'explore')); ?>#places">View more</a>
      </div>

      <div class="filters places-filters home-places-filters" data-scope="#home-places" role="tablist" aria-label="Filter nearby places">
        <button class="on" data-filter="all" type="button" role="tab" aria-selected="true">All</button>
        <?php $__currentLoopData = $homePlaceFilters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filterKey => $filterLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php if(in_array($filterKey, $homePlaceCats, true)): ?>
            <button data-filter="<?php echo e($filterKey); ?>" type="button" role="tab" aria-selected="false"><?php echo e($filterLabel); ?></button>
          <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>

      <div class="places home-places" id="home-places">
        <?php $__currentLoopData = $homePlaces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $place): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <article class="place home-place" data-cat="<?php echo e($place['cat']); ?>">
            <div class="home-place-media">
              <img
                src="<?php echo e($place['image_url']); ?>"
                alt="<?php echo e($place['alt'] ?? $place['title']); ?>"
                width="640"
                height="420"
                loading="lazy"
                decoding="async"
              >
              <span class="home-place-distance">~<?php echo e($place['distance_km']); ?> km</span>
            </div>
            <div class="pad">
              <span class="place-type"><?php echo e($place['type']); ?></span>
              <h3><?php echo e($place['title']); ?></h3>
              <p class="muted"><?php echo e(\Illuminate\Support\Str::limit($place['blurb'], 90)); ?></p>
              <p class="place-meta muted"><?php echo e($place['direction']); ?> · ~<?php echo e($place['drive_mins']); ?> min</p>
              <a class="home-place-link" href="<?php echo e($place['directions_url']); ?>" target="_blank" rel="noopener">Directions →</a>
            </div>
          </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <p class="places-empty" data-filter-empty hidden>No places in this category here — try All, or view the full Explore list.</p>

      <div class="home-places-foot">
        <p class="muted">See every temple, hill, beach and day-trip idea with live directions.</p>
        <a class="btn btn-gold" href="<?php echo e(route('page.show', 'explore')); ?>#places">View more places</a>
      </div>
    </div>
  </section>

  <section class="section" style="padding-top:0">
    <div class="wrap">
      <div class="section-head">
        <div>
          <p class="eyebrow">Pricing</p>
          <h2>Simple, transparent packages</h2>
        </div>
        <p class="muted">Prices are confirmed on enquiry and may vary by date, guest count and event requirements.</p>
      </div>
      <div class="prices">
        <article class="price">
          <h3>Day Stay</h3>
          <div class="amount">On request</div>
          <ul>
            <li>Private venue access</li>
            <li>Living &amp; dining area</li>
            <li>Kitchen access</li>
            <li>Courtyard</li>
            <li>Games</li>
          </ul>
          <a class="btn btn-line" href="<?php echo e(route('page.show', 'booking')); ?>?type=homestay">Book day stay</a>
        </article>
        <article class="price featured">
          <span class="tag">Most popular</span>
          <h3>Overnight Stay</h3>
          <div class="amount">On request</div>
          <ul>
            <li>Complete 2 BHK</li>
            <li>Bedrooms</li>
            <li>Kitchen</li>
            <li>Living area &amp; dining</li>
            <li>Courtyard</li>
          </ul>
          <a class="btn btn-gold" href="<?php echo e(route('page.show', 'booking')); ?>?type=homestay">Book your stay</a>
        </article>
        <article class="price">
          <h3>Event Package</h3>
          <div class="amount">On request</div>
          <ul>
            <li>Venue</li>
            <li>Stage</li>
            <li>Event space</li>
            <li>Kitchen</li>
            <li>Photo point</li>
          </ul>
          <a class="btn btn-line" href="<?php echo e(route('page.show', 'booking')); ?>?type=custom">Plan your event</a>
        </article>
      </div>
      <p class="note">Stage, decoration, grill, campfire, games and the photo point can be added to any celebration.</p>
    </div>
  </section>

  <section class="section" style="padding-top:0">
    <div class="wrap">
      <div class="section-head">
        <div>
          <p class="eyebrow">Moments</p>
          <h2>Experience it in motion</h2>
        </div>
        <p class="muted">Campfire nights, sizzling BBQ, celebrations and Kerala’s natural beauty — tap a frame to see it larger.</p>
      </div>
      <div class="reels">
        <?php $__currentLoopData = site_image_group('home_reels'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <button class="reel" data-zoom="<?php echo e($reel['url']); ?>" data-caption="<?php echo e($reel['caption']); ?>">
            <img
              src="<?php echo e($reel['url']); ?>"
              <?php if(!empty($reel['srcset'])): ?> srcset="<?php echo e($reel['srcset']); ?>" sizes="(max-width:768px) 50vw, 280px" <?php endif; ?>
              alt="<?php echo e($reel['alt']); ?>"
              <?php if($reel['width']): ?> width="<?php echo e($reel['width']); ?>" <?php endif; ?>
              <?php if($reel['height']): ?> height="<?php echo e($reel['height']); ?>" <?php endif; ?>
              loading="lazy"
              decoding="async"
            >
            <span><small><?php echo e($reel['caption']); ?></small><strong><?php echo e($reel['caption']); ?></strong></span>
          </button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  </section>

  <section class="section" style="padding-top:0" aria-labelledby="why-ixora-heading">
    <div class="wrap" style="max-width:900px">
      <p class="eyebrow">Why IXORA</p>
      <h2 id="why-ixora-heading">Best family homestay in Kannur for a peaceful stay</h2>
      <p class="lede">IXORA is a <strong>Niduvaloor Homestay</strong> near  <strong>Thaliparamba</strong> — a private house for couples, families and friends, with on-site parking and a calm courtyard.</p>
      <p>Whether you need an <strong>affordable homestay in Kannur</strong>, a <strong>family homestay in Kannur</strong> <strong>homestay near Thaliparamba</strong>, or a quiet <strong>home stay in Kannur Kerala</strong> with kitchen access, IXORA keeps the stay simple and private.</p>
      <p>Guests searching for a <strong>homestay near Kannur</strong> city, <strong>homestay in Thaliparamba</strong> areas, or a celebration venue for birthdays and gatherings choose IXORA for space, privacy and warm host support — with easy day trips to beaches, forts and temples.</p>
      <p><a class="btn btn-dark" href="<?php echo e(route('page.show', 'booking')); ?>">Book Homestay in Kannur</a> <a class="btn btn-line" href="<?php echo e(route('page.show', 'explore')); ?>">Things to do in Kannur</a></p>
    </div>
  </section>

  <section class="section reviews-band" id="reviews" aria-labelledby="reviews-heading">
    <div class="wrap">
      <div class="section-head">
        <div>
          <p class="eyebrow">Guest stories</p>
          <h2 id="reviews-heading">What our guests say</h2>
        </div>
        <div class="reviews-head-actions">
          <div class="reviews-score" data-reviews-score <?php if(($reviewsCount ?? 0) < 1): ?> hidden <?php endif; ?>>
            <strong data-avg><?php echo e(number_format((float) ($reviewsAverage ?? 5), 1)); ?></strong>
            <span class="stars" aria-hidden="true">★★★★★</span>
            <span class="muted" data-count-label>
              <?php if(($reviewsCount ?? 0) > 0): ?>
                from <?php echo e($reviewsCount); ?> guest <?php echo e(\Illuminate\Support\Str::plural('review', $reviewsCount)); ?>

              <?php else: ?>
                from guest reviews
              <?php endif; ?>
            </span>
          </div>
          <a class="btn btn-line" href="<?php echo e(route('page.show', 'reviews')); ?>">All reviews</a>
        </div>
      </div>

      <div class="reviews-showcase" data-reviews-list data-reviews-limit="6">
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
          <p class="muted reviews-empty">Be the first to share your stay experience.</p>
        <?php endif; ?>
      </div>

      <div class="reviews-cta">
        <p class="muted">Had a wonderful stay or celebration at IXORA?</p>
        <a class="btn btn-gold" href="<?php echo e(route('page.show', 'reviews')); ?>#review-panel">Write a review</a>
      </div>
    </div>
  </section>

  <section class="section" style="padding-top:0">
    <div class="wrap">
      <div class="section-head">
        <div>
          <p class="eyebrow">Gallery</p>
          <h2>A look around the venue</h2>
        </div>
        <a class="btn btn-line" href="<?php echo e(route('page.show', 'gallery')); ?>">Open full gallery</a>
      </div>
      <div class="filters" data-scope="#home-gallery">
        <button class="on" data-filter="all" type="button">All</button>
        <button data-filter="homestay" type="button">Homestay</button>
        <button data-filter="bedrooms" type="button">Bedrooms</button>
        <button data-filter="living" type="button">Living area</button>
        <button data-filter="events" type="button">Events</button>
        <button data-filter="campfire" type="button">Campfire</button>
        <button data-filter="bbq" type="button">BBQ</button>
        <button data-filter="courtyard" type="button">Courtyard</button>
        <button data-filter="photo" type="button">Photo point</button>
      </div>
      <div class="gallery" id="home-gallery">
        <?php $__currentLoopData = site_image_group('home_gallery'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <button class="g-item" data-cat="<?php echo e($shot['category']); ?>" data-zoom="<?php echo e($shot['url']); ?>">
            <img
              src="<?php echo e($shot['url']); ?>"
              <?php if(!empty($shot['srcset'])): ?> srcset="<?php echo e($shot['srcset']); ?>" sizes="(max-width:768px) 50vw, 320px" <?php endif; ?>
              alt="<?php echo e($shot['alt']); ?>"
              <?php if($shot['width']): ?> width="<?php echo e($shot['width']); ?>" <?php endif; ?>
              <?php if($shot['height']): ?> height="<?php echo e($shot['height']); ?>" <?php endif; ?>
              loading="lazy"
              decoding="async"
            >
            <span class="cap"><?php echo e($shot['caption']); ?></span>
          </button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  </section>

  <section class="section" style="padding-top:0" id="faq" aria-labelledby="faq-heading">
    <div class="wrap">
      <div class="section-head">
        <div>
          <p class="eyebrow">Help</p>
          <h2 id="faq-heading">Frequently asked questions</h2>
        </div>
        <a class="btn btn-line" href="<?php echo e(route('page.show', 'faq')); ?>">View all FAQs</a>
      </div>
      <?php
        $faqPhone1 = setting('phone_primary', '89215 25086');
        $faqPhone2 = setting('phone_secondary', '80757 71824');
        $faqTel1 = preg_replace('/\s+/', '', setting('phone_primary', '+918921525086'));
        $faqTel2 = preg_replace('/\s+/', '', setting('phone_secondary', '+918075771824'));
        $faqWaUrl = whatsapp_url('Hi IXORA Homestay! I found your details on the website and I have a quick question.');
        $faqWaPhone = whatsapp_number();
        $faqWaText = whatsapp_message('Hi IXORA Homestay! I found your details on the website and I have a quick question.');
      ?>
      <div class="faq-home">
        <div class="faq-list" data-faq>
          <?php $__empty_1 = true; $__currentLoopData = ($faqs ?? collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <details class="faq-item" <?php if($index === 0): ?> open <?php endif; ?>>
              <summary><?php echo e($faq->question); ?></summary>
              <div class="faq-body"><p><?php echo $faq->answer; ?></p></div>
            </details>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="muted">FAQs will appear here once they are published in the admin.</p>
          <?php endif; ?>
        </div>
        <aside class="faq-aside">
          <div class="faq-aside-media">
            <?php if (isset($component)) { $__componentOriginald67ae95db5947856cc75436a3fd8df98 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald67ae95db5947856cc75436a3fd8df98 = $attributes; } ?>
<?php $component = App\View\Components\SiteImg::resolve(['slotKey' => 'home.faq_aside'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('site-img'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\SiteImg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['loading' => 'lazy']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald67ae95db5947856cc75436a3fd8df98)): ?>
<?php $attributes = $__attributesOriginald67ae95db5947856cc75436a3fd8df98; ?>
<?php unset($__attributesOriginald67ae95db5947856cc75436a3fd8df98); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald67ae95db5947856cc75436a3fd8df98)): ?>
<?php $component = $__componentOriginald67ae95db5947856cc75436a3fd8df98; ?>
<?php unset($__componentOriginald67ae95db5947856cc75436a3fd8df98); ?>
<?php endif; ?>
            <p class="faq-aside-caption">A stay to remember</p>
          </div>
          <div class="faq-aside-pad">
            <p class="eyebrow">Need more help?</p>
            <h3>Ask the hosts</h3>
            <p class="muted">Call or WhatsApp for availability, packages and cancellation details.</p>
            <ul class="faq-aside-list">
              <li>
                <a href="tel:<?php echo e($faqTel1); ?>">
                  <span class="faq-aside-ico is-forest" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.2 1.2.4 2.5.6 3.8.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.6 21 3 13.4 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.8.1.4 0 .8-.3 1.1L6.6 10.8z"/></svg>
                  </span>
                  <span class="faq-aside-copy">
                    <strong><?php echo e($faqPhone1); ?></strong>
                    <span>Primary phone</span>
                  </span>
                  <span class="faq-aside-arrow" aria-hidden="true">›</span>
                </a>
              </li>
              <li>
                <a href="tel:<?php echo e($faqTel2); ?>">
                  <span class="faq-aside-ico is-clay" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.2 1.2.4 2.5.6 3.8.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.6 21 3 13.4 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.8.1.4 0 .8-.3 1.1L6.6 10.8z"/></svg>
                  </span>
                  <span class="faq-aside-copy">
                    <strong><?php echo e($faqPhone2); ?></strong>
                    <span>Alternate phone</span>
                  </span>
                  <span class="faq-aside-arrow" aria-hidden="true">›</span>
                </a>
              </li>
              <li>
                <a href="<?php echo e($faqWaUrl); ?>" data-whatsapp-chat data-whatsapp-phone="<?php echo e($faqWaPhone); ?>" data-whatsapp-text="<?php echo e($faqWaText); ?>" target="_blank" rel="noopener">
                  <span class="faq-aside-ico is-wa" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M12 2a9.9 9.9 0 0 0-8.6 14.8L2 22l5.4-1.4A10 10 0 1 0 12 2zm5.7 14.1c-.2.7-1.3 1.2-2.1 1.4-.5.1-1.2.2-3.5-.7-2.9-1.3-4.7-4.4-4.9-4.6-.2-.2-1.5-2-1.5-3.8s1-2.7 1.3-3.1c.3-.3.7-.4 1-.4h.7c.2 0 .5 0 .7.6.3.7.9 2.3 1 2.4.1.2.1.4 0 .6-.1.2-.2.4-.4.6-.2.2-.4.4-.2.7.2.4.9 1.5 2 2.4 1.4 1.1 2.5 1.5 2.9 1.6.3.1.5.1.7-.1.2-.2.7-.8.9-1.1.2-.3.4-.2.7-.1.3.1 1.9.9 2.2 1.1.3.2.5.3.6.4.1.2.1.9-.1 1.6z"/></svg>
                  </span>
                  <span class="faq-aside-copy">
                    <strong>WhatsApp</strong>
                    <span>Usually fastest reply</span>
                  </span>
                  <span class="faq-aside-arrow" aria-hidden="true">›</span>
                </a>
              </li>
            </ul>
            <div class="faq-aside-actions">
              <a class="btn btn-gold" href="<?php echo e($faqWaUrl); ?>" data-whatsapp-chat data-whatsapp-phone="<?php echo e($faqWaPhone); ?>" data-whatsapp-text="<?php echo e($faqWaText); ?>" target="_blank" rel="noopener">Chat on WhatsApp</a>
              <a class="btn btn-line faq-aside-book" href="<?php echo e(route('page.show', 'booking')); ?>">Check availability</a>
            </div>
          </div>
        </aside>
      </div>
    </div>
  </section>
<?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/frontend/templates/home.blade.php ENDPATH**/ ?>