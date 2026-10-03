<?php
  $phonePrimary = setting('phone_primary', '89215 25086');
  $phoneSecondary = setting('phone_secondary', '80757 71824');
  $phonePrimaryTel = preg_replace('/\s+/', '', setting('phone_primary', '+918921525086'));
  $phoneSecondaryTel = preg_replace('/\s+/', '', setting('phone_secondary', '+918075771824'));
  $waUrl = whatsapp_url();
  $waPhone = whatsapp_number();
  $waText = whatsapp_message();
  $mapsLink = homestay_maps_link();
?>

<section class="page-hero">
  <div class="wrap">
    <p class="eyebrow">Kannur Homestay Booking</p>
    <h1>Book your Kannur family stay</h1>
    <p class="lede">Check dates for IXORA — an affordable private homestay in Niduvaloor, Kannur. We confirm availability and pricing for weekday, weekend and event stays.</p>
  </div>
</section>

<section class="section booking-section" id="booking-form-section">
  <div class="wrap booking-layout booking-blocks">
    <?php if(session('success') || session('booking_reference')): ?>
      <?php echo $__env->make('partials.flash-card', [
        'id' => 'booking-success',
        'type' => 'success',
        'eyebrow' => 'Request received',
        'title' => 'Thank you — your enquiry is with us',
        'message' => session('success') ?: 'We will contact you shortly to confirm availability and pricing.',
        'reference' => session('booking_reference'),
        'actions' => '<a class="btn btn-gold" href="'.e(whatsapp_url('Hi IXORA Homestay! I found you on the website and just submitted a booking request'.(session('booking_reference') ? ' ('.session('booking_reference').')' : '').'. Please confirm availability.')).'" data-whatsapp-chat data-whatsapp-phone="'.e(whatsapp_number()).'" data-whatsapp-text="'.e(whatsapp_message('Hi IXORA Homestay! I found you on the website and just submitted a booking request'.(session('booking_reference') ? ' ('.session('booking_reference').')' : '').'. Please confirm availability.')).'" target="_blank" rel="noopener">Continue on WhatsApp</a>
          <a class="btn btn-line" href="'.route('home').'">Back to home</a>',
      ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    <?php if($errors->any()): ?>
      <div class="flash-card flash-error" role="alert" style="grid-column:1/-1">
        <div class="flash-icon" aria-hidden="true">!</div>
        <div class="flash-body">
          <p class="flash-eyebrow">Please fix the form</p>
          <h2 class="flash-title">Some details need attention</h2>
          <ul class="flash-list">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
      </div>
    <?php endif; ?>

    <?php if (! (session('booking_reference'))): ?>
    <form class="form-card form-readable booking-form-card" id="booking-form" method="POST" action="<?php echo e(route('booking.store')); ?>">
      <?php echo csrf_field(); ?>
      <div class="booking-form-head">
        <p class="eyebrow">Enquiry</p>
        <h2>Send your dates</h2>
        <p class="muted">Share check-in, guests and booking type — we confirm availability and quote weekday or weekend rates.</p>
      </div>
      <div class="form-grid">
        <div class="field">
          <label for="name">Name</label>
          <input id="name" name="name" type="text" required placeholder="Your name" value="<?php echo e(old('name')); ?>" autocomplete="name">
        </div>
        <div class="field">
          <label for="email">Email</label>
          <input id="email" name="email" type="email" placeholder="you@email.com" value="<?php echo e(old('email')); ?>" autocomplete="email">
        </div>
        <div class="field">
          <label for="phone">Phone</label>
          <input id="phone" name="phone" type="tel" required placeholder="10-digit mobile" value="<?php echo e(old('phone')); ?>" autocomplete="tel">
        </div>
        <div class="field">
          <label for="whatsapp">WhatsApp (optional)</label>
          <input id="whatsapp" name="whatsapp" type="tel" placeholder="Same as phone if blank" value="<?php echo e(old('whatsapp')); ?>">
        </div>
        <div class="field">
          <label for="check_in">Check-in</label>
          <input id="check_in" name="check_in" type="date" required value="<?php echo e(old('check_in')); ?>">
        </div>
        <div class="field">
          <label for="check_out">Check-out</label>
          <input id="check_out" name="check_out" type="date" value="<?php echo e(old('check_out')); ?>">
        </div>
        <div class="field field-guests">
          <label>Guests</label>
          <div class="guest-pair" role="group" aria-label="Guest counts">
            <div class="guest-pair-item">
              <div class="stepper guest-stepper" data-step data-min="1" data-max="30" data-target="#adults">
                <button type="button" data-step="minus" aria-label="Fewer adults">−</button>
                <div class="guest-stepper-meta">
                  <span class="guest-pair-label">Adults</span>
                  <strong data-count><?php echo e(old('adults', 2)); ?></strong>
                </div>
                <button type="button" data-step="plus" aria-label="More adults">+</button>
              </div>
              <input id="adults" name="adults" type="hidden" value="<?php echo e(old('adults', 2)); ?>">
            </div>
            <div class="guest-pair-item">
              <div class="stepper guest-stepper" data-step data-min="0" data-max="30" data-target="#children">
                <button type="button" data-step="minus" aria-label="Fewer children">−</button>
                <div class="guest-stepper-meta">
                  <span class="guest-pair-label">Children</span>
                  <strong data-count><?php echo e(old('children', 0)); ?></strong>
                </div>
                <button type="button" data-step="plus" aria-label="More children">+</button>
              </div>
              <input id="children" name="children" type="hidden" value="<?php echo e(old('children', 0)); ?>">
            </div>
          </div>
          <p class="guest-note">Children under 10 · Age 10+ count as adults</p>
        </div>
        <div class="field">
          <label for="booking_type">Booking type</label>
          <select id="booking_type" name="booking_type">
            <?php $__currentLoopData = ['Homestay','Birthday Party','Engagement','Family Gathering','Friends Get-together','Custom Event']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($type); ?>" <?php if(old('booking_type') === $type): echo 'selected'; endif; ?>><?php echo e($type); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
        <div class="field full">
          <label for="message">Notes</label>
          <textarea id="message" name="message" placeholder="Add-ons, decoration ideas, food, or questions"><?php echo e(old('message')); ?></textarea>
        </div>
      </div>
      <div class="booking-form-foot">
        <button class="btn btn-clay" type="submit">Submit booking</button>
        <p class="note">Check-in 12:00 PM · Check-out 11:00 AM. Extra guest charges apply beyond base occupancy.</p>
      </div>
    </form>
    <?php endif; ?>

    <aside class="side-card booking-side">
      <div class="booking-side-media">
        <?php if (isset($component)) { $__componentOriginald67ae95db5947856cc75436a3fd8df98 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald67ae95db5947856cc75436a3fd8df98 = $attributes; } ?>
<?php $component = App\View\Components\SiteImg::resolve(['slotKey' => 'shared.evening_aside'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
        <p class="booking-side-caption">A stay to remember</p>
      </div>
      <div class="pad">
        <p class="eyebrow">Reach hosts</p>
        <h3>Talk to us directly</h3>
        <p class="muted booking-side-lead">Day stay, overnight and event packages are quoted after we see your dates and guest count.</p>

        <ul class="booking-side-list">
          <li>
            <a href="tel:<?php echo e($phonePrimaryTel); ?>">
              <span class="booking-side-ico is-forest" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.2 1.2.4 2.5.6 3.8.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.6 21 3 13.4 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.8.1.4 0 .8-.3 1.1L6.6 10.8z"/></svg>
              </span>
              <span class="booking-side-copy">
                <strong><?php echo e($phonePrimary); ?></strong>
                <span>Primary phone</span>
              </span>
              <span class="booking-side-arrow" aria-hidden="true">›</span>
            </a>
          </li>
          <li>
            <a href="tel:<?php echo e($phoneSecondaryTel); ?>">
              <span class="booking-side-ico is-clay" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.2 1.2.4 2.5.6 3.8.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.6 21 3 13.4 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.8.1.4 0 .8-.3 1.1L6.6 10.8z"/></svg>
              </span>
              <span class="booking-side-copy">
                <strong><?php echo e($phoneSecondary); ?></strong>
                <span>Alternate phone</span>
              </span>
              <span class="booking-side-arrow" aria-hidden="true">›</span>
            </a>
          </li>
          <li>
            <a href="<?php echo e($mapsLink); ?>" target="_blank" rel="noopener">
              <span class="booking-side-ico is-gold" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M12 2C8.1 2 5 5.1 5 9c0 5.2 7 13 7 13s7-7.8 7-13c0-3.9-3.1-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5z"/></svg>
              </span>
              <span class="booking-side-copy">
                <strong>Building No. 7-334, Niduvaloor</strong>
                <span>Open map</span>
              </span>
              <span class="booking-side-arrow" aria-hidden="true">›</span>
            </a>
          </li>
        </ul>

        <div class="booking-side-actions">
          <a class="btn btn-gold" href="<?php echo e($waUrl); ?>" data-whatsapp-chat data-whatsapp-phone="<?php echo e($waPhone); ?>" data-whatsapp-text="<?php echo e($waText); ?>" target="_blank" rel="noopener">Chat on WhatsApp</a>
          <a class="btn btn-line booking-side-contact" href="<?php echo e(route('page.show', 'contact')); ?>">Contact form</a>
        </div>
      </div>
    </aside>
  </div>
</section>
<?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/frontend/templates/booking.blade.php ENDPATH**/ ?>