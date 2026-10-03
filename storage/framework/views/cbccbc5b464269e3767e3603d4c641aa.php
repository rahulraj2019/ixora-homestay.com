<?php
  $heroImage = app(\App\Services\SiteImageService::class)->get('explore.hero');
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

<section class="hero" style="min-height:72vh">
    <?php if (isset($component)) { $__componentOriginald67ae95db5947856cc75436a3fd8df98 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald67ae95db5947856cc75436a3fd8df98 = $attributes; } ?>
<?php $component = App\View\Components\SiteImg::resolve(['slotKey' => 'explore.hero'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
      <p class="eyebrow">Kannur Travel Guide</p>
      <h1>Best places to visit<br><em>in &amp; near Kannur</em></h1>
      <p class="lede">Things to do in Kannur from IXORA Homestay — beaches, forts, temples, hills and waterfalls for a perfect weekend getaway.</p>
    </div>
  </section>

  <section class="section" style="padding-bottom:0">
    <div class="wrap" style="max-width:860px">
      <p class="eyebrow">From our Niduvaloor Homestay</p>
      <h2>Homestay near Kannur tourist places</h2>
      <p class="lede">Stay at IXORA and day-trip to <strong>Muzhappilangad Drive-in Beach</strong>, Payyambalam Beach, <strong>St. Angelo Fort Kannur</strong>, <strong>Parassinikadavu Muthappan Temple</strong>, Paithalmala and Palakkayam Thattu — a practical base for Kannur accommodation near city and countryside attractions.</p>
    </div>
  </section>

  <section class="section" id="places">
    <div class="wrap">
      <div class="section-head">
        <div>
          <p class="eyebrow">Tourist attractions</p>
          <h2>Kannur tourist places near IXORA</h2>
        </div>
      </div>
      <p class="lede places-intro">Hills, beaches, forts and temples — listed nearest to farthest from our Niduvaloor Gate homestay.</p>
      <div class="filters places-filters" data-scope="#places-grid">
        <button class="on" data-filter="all" type="button">All</button>
        <button data-filter="temple" type="button">Temples</button>
        <button data-filter="hill" type="button">Hills</button>
        <button data-filter="waterfall" type="button">Waterfalls</button>
        <button data-filter="beach" type="button">Beach</button>
        <button data-filter="heritage" type="button">Heritage</button>
        <button data-filter="family" type="button">Family</button>
      </div>
      <div class="places" id="places-grid">
        <?php $__currentLoopData = nearby_attractions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $place): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <article class="place" data-cat="<?php echo e($place['cat']); ?>">
            <img
              src="<?php echo e($place['image_url']); ?>"
              alt="<?php echo e($place['alt'] ?? $place['title']); ?>"
              width="640"
              height="420"
              loading="lazy"
              decoding="async"
            >
            <div class="pad">
              <span class="place-type"><?php echo e($place['type']); ?></span>
              <h3><?php echo e($place['title']); ?></h3>
              <p class="muted"><?php echo e($place['blurb']); ?></p>
              <p class="place-meta muted">~<?php echo e($place['distance_km']); ?> km · <?php echo e($place['direction']); ?> · ~<?php echo e($place['drive_mins']); ?> min</p>
              <a href="<?php echo e($place['directions_url']); ?>" target="_blank" rel="noopener">Directions →</a>
            </div>
          </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <p class="note">Distances are approximate road times from IXORA. Ask us when you book and we will suggest a realistic day plan.</p>
    </div>
  </section>

  <section class="section" style="padding-top:0">
    <div class="wrap">
      <div class="section-head">
        <div>
          <p class="eyebrow">Featured day trips</p>
          <h2>Ready-made itineraries</h2>
        </div>
      </div>
      <div class="trips">
        <article class="trip">
          <?php if (isset($component)) { $__componentOriginald67ae95db5947856cc75436a3fd8df98 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald67ae95db5947856cc75436a3fd8df98 = $attributes; } ?>
<?php $component = App\View\Components\SiteImg::resolve(['slotKey' => 'explore.trip_1'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
          <div class="pad">
            <h3>Hill sunset</h3>
            <ol><li>Breakfast at the homestay</li><li>Palakkayam Thattu for mist and views</li><li>Return before the campfire</li></ol>
            <p><a class="btn btn-gold" href="<?php echo e(route('page.show', 'booking')); ?>?addon=Palakkayam%20Thattu%20hill%20trip">Plan this trip</a></p>
          </div>
        </article>
        <article class="trip">
          <?php if (isset($component)) { $__componentOriginald67ae95db5947856cc75436a3fd8df98 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald67ae95db5947856cc75436a3fd8df98 = $attributes; } ?>
<?php $component = App\View\Components\SiteImg::resolve(['slotKey' => 'explore.trip_2'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
          <div class="pad">
            <h3>Waterfall day</h3>
            <ol><li>Drive toward Paithalmala</li><li>Ezharakund’s seven-tier falls</li><li>Forest views, then back for dinner</li></ol>
            <p><a class="btn btn-gold" href="<?php echo e(route('page.show', 'booking')); ?>?addon=Ezharakund%20waterfall%20trip">Plan this trip</a></p>
          </div>
        </article>
        <article class="trip">
          <?php if (isset($component)) { $__componentOriginald67ae95db5947856cc75436a3fd8df98 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald67ae95db5947856cc75436a3fd8df98 = $attributes; } ?>
<?php $component = App\View\Components\SiteImg::resolve(['slotKey' => 'explore.trip_3'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
          <div class="pad">
            <h3>Kannur coast</h3>
            <ol><li>St. Angelo Fort by the sea</li><li>Drive along Muzhappilangad Beach</li><li>Evening return to IXORA</li></ol>
            <p><a class="btn btn-gold" href="<?php echo e(route('page.show', 'booking')); ?>?addon=Kannur%20coast%20trip">Plan this trip</a></p>
          </div>
        </article>
      </div>
    </div>
  </section>

  <section class="section" style="padding-top:0">
    <div class="wrap">
      <div class="section-head">
        <div>
          <p class="eyebrow">Local experiences</p>
          <h2>Things to do around you</h2>
        </div>
        <p class="muted">From village walks to hill viewpoints, Kerala is close enough to fold into a single stay.</p>
      </div>
      <div class="addons">
        <div class="addon"><div><strong>Kerala food experiences</strong><span class="muted">Traditional meals and local flavours</span></div></div>
        <div class="addon"><div><strong>Village walks</strong><span class="muted">Stroll through villages and plantations</span></div></div>
        <div class="addon"><div><strong>Nature photography</strong><span class="muted">Landscapes and golden-hour light</span></div></div>
        <div class="addon"><div><strong>Local culture</strong><span class="muted">Traditions, art and daily life</span></div></div>
        <div class="addon"><div><strong>Family day trips</strong><span class="muted">Outings the whole family enjoys</span></div></div>
        <div class="addon"><div><strong>Adventure activities</strong><span class="muted">Trekking and outdoor exploration</span></div></div>
      </div>
    </div>
  </section>

  <section class="section explore-map" id="explore-map" aria-labelledby="explore-map-heading">
    <div class="wrap">
      <?php
        $mapsLink = homestay_maps_link();
        $mapsEmbed = homestay_maps_embed();
        $mapPlaces = array_slice(nearby_attractions(), 0, 8);
      ?>

      <div class="explore-map-head">
        <div>
          <p class="eyebrow">Map</p>
          <h2 id="explore-map-heading">Where we are</h2>
          <p class="lede">IXORA at Niduvaloor Gate — open the pin, then pick a day trip with live directions.</p>
        </div>
        <a class="btn btn-line" href="<?php echo e($mapsLink); ?>" target="_blank" rel="noopener">Open homestay pin ↗</a>
      </div>

      <div class="explore-map-stage">
        <div class="explore-map-canvas">
          <div class="map-facade" data-map-src="<?php echo e($mapsEmbed); ?>" data-map-title="Google Map — IXORA Homestay, Niduvaloor Gate">
            <button type="button" class="map-facade-btn">
              <span>Load interactive map</span>
              <small>Exact Irikkur pin · click to open</small>
            </button>
          </div>
        </div>

        <aside class="explore-map-panel">
          <div class="explore-map-panel-top">
            <p class="explore-map-kicker">Visit from here</p>
            <h3>Day trips from the gate</h3>
            <p class="muted">Nearest first — tap any place for Google Maps directions.</p>
          </div>

          <div class="explore-map-list">
            <?php $__currentLoopData = $mapPlaces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $place): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <a class="explore-map-item" href="<?php echo e($place['directions_url']); ?>" target="_blank" rel="noopener">
                <span class="explore-map-item-text">
                  <strong><?php echo e($place['title']); ?></strong>
                  <small><?php echo e($place['type']); ?> · <?php echo e($place['direction']); ?></small>
                </span>
                <span class="explore-map-km">~<?php echo e($place['distance_km']); ?> km</span>
              </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>

          <div class="explore-map-panel-foot">
            <a class="btn btn-gold" href="<?php echo e($mapsLink); ?>" target="_blank" rel="noopener">Open map pin</a>
            <a class="btn btn-line" href="<?php echo e(route('page.show', 'contact')); ?>#contact-visit-heading">Contact &amp; arrival</a>
          </div>
        </aside>
      </div>
    </div>
  </section>
<?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/frontend/templates/explore.blade.php ENDPATH**/ ?>