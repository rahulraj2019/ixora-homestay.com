<section class="page-hero">
    <div class="wrap">
      <p class="eyebrow">Gallery</p>
      <h1>A look around the venue</h1>
      <p class="lede">The house, the courtyard, the stage and the evenings in between. Tap any photo to open it.</p>
    </div>
  </section>

  <section class="section" style="padding-top:10px">
    <div class="wrap">
      <div class="filters" data-scope="#gallery">
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
      <div class="gallery" id="gallery">
        <?php $__currentLoopData = site_image_group('gallery'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <button class="g-item" data-cat="<?php echo e($shot['category']); ?>" data-zoom="<?php echo e($shot['url']); ?>">
            <img src="<?php echo e($shot['url']); ?>" alt="<?php echo e($shot['alt']); ?>" <?php if($shot['width']): ?> width="<?php echo e($shot['width']); ?>" <?php endif; ?> <?php if($shot['height']): ?> height="<?php echo e($shot['height']); ?>" <?php endif; ?> loading="lazy" decoding="async">
            <span class="cap"><?php echo e($shot['caption']); ?></span>
          </button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  </section>
<?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/frontend/templates/gallery.blade.php ENDPATH**/ ?>