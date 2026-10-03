<?php
  $phonePrimary = setting('phone_primary', '89215 25086');
  $phoneSecondary = setting('phone_secondary', '80757 71824');
  $phonePrimaryTel = preg_replace('/\s+/', '', setting('phone_primary', '+918921525086'));
  $phoneSecondaryTel = preg_replace('/\s+/', '', setting('phone_secondary', '+918075771824'));
  $waUrl = whatsapp_url();
  $waPhone = whatsapp_number();
  $waText = whatsapp_message();
  $mapsLink = homestay_maps_link();
  $mapsEmbed = homestay_maps_embed();
  $address = setting('address', "Building No. 7-334, Ixora Homestay,\nNiduvaloor Gate, Niduvaloor, 670142");
?>

<section class="page-hero contact-hero">
    <div class="wrap">
      <p class="eyebrow">Contact</p>
      <h1>Talk to us</h1>
    <p class="lede">Call, message on WhatsApp, or send your dates. We confirm availability for stays and celebrations at Niduvaloor Gate.</p>

    <div class="contact-quick">
      <a class="contact-chip" href="tel:<?php echo e($phonePrimaryTel); ?>">
        <span class="contact-chip-icon is-forest" aria-hidden="true">
          <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.2 1.2.4 2.5.6 3.8.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.6 21 3 13.4 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.8.1.4 0 .8-.3 1.1L6.6 10.8z"/></svg>
        </span>
        <span class="contact-chip-body">
          <strong><?php echo e($phonePrimary); ?></strong>
          <span>Primary phone</span>
        </span>
      </a>
      <a class="contact-chip" href="tel:<?php echo e($phoneSecondaryTel); ?>">
        <span class="contact-chip-icon is-clay" aria-hidden="true">
          <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.2 1.2.4 2.5.6 3.8.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.6 21 3 13.4 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.8.1.4 0 .8-.3 1.1L6.6 10.8z"/></svg>
        </span>
        <span class="contact-chip-body">
          <strong><?php echo e($phoneSecondary); ?></strong>
          <span>Alternate phone</span>
        </span>
      </a>
      <a class="contact-chip contact-chip-wa" href="<?php echo e($waUrl); ?>" data-whatsapp-chat data-whatsapp-phone="<?php echo e($waPhone); ?>" data-whatsapp-text="<?php echo e($waText); ?>" target="_blank" rel="noopener">
        <span class="contact-chip-icon is-wa" aria-hidden="true">
          <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M12 2a9.9 9.9 0 0 0-8.6 14.8L2 22l5.4-1.4A10 10 0 1 0 12 2zm5.7 14.1c-.2.7-1.3 1.2-2.1 1.4-.5.1-1.2.2-3.5-.7-2.9-1.3-4.7-4.4-4.9-4.6-.2-.2-1.5-2-1.5-3.8s1-2.7 1.3-3.1c.3-.3.7-.4 1-.4h.7c.2 0 .5 0 .7.6.3.7.9 2.3 1 2.4.1.2.1.4 0 .6-.1.2-.2.4-.4.6-.2.2-.4.4-.2.7.2.4.9 1.5 2 2.4 1.4 1.1 2.5 1.5 2.9 1.6.3.1.5.1.7-.1.2-.2.7-.8.9-1.1.2-.3.4-.2.7-.1.3.1 1.9.9 2.2 1.1.3.2.5.3.6.4.1.2.1.9-.1 1.6z"/></svg>
        </span>
        <span class="contact-chip-body">
          <strong>WhatsApp</strong>
          <span>Usually fastest reply</span>
        </span>
      </a>
      <a class="contact-chip" href="<?php echo e($mapsLink); ?>" target="_blank" rel="noopener">
        <span class="contact-chip-icon is-gold" aria-hidden="true">
          <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M12 2C8.1 2 5 5.1 5 9c0 5.2 7 13 7 13s7-7.8 7-13c0-3.9-3.1-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5z"/></svg>
        </span>
        <span class="contact-chip-body">
          <strong>Find us</strong>
          <span>Building No. 7-334, Niduvaloor</span>
        </span>
      </a>
    </div>
  </div>
</section>

<section class="section contact-section" id="contact-form-section">
  <div class="wrap booking-layout contact-layout">
    <?php if(session('contact_success')): ?>
      <?php echo $__env->make('partials.flash-card', [
        'id' => 'contact-success',
        'type' => 'success',
        'eyebrow' => 'Message sent',
        'title' => 'Thanks — we got your message',
        'message' => session('success') ?: 'Our hosts will get back to you shortly.',
        'actions' => '<a class="btn btn-gold" href="'.e(whatsapp_url('Hi IXORA Homestay! I just sent a message from your website contact form.')).'" data-whatsapp-chat data-whatsapp-phone="'.e(whatsapp_number()).'" data-whatsapp-text="'.e(whatsapp_message('Hi IXORA Homestay! I just sent a message from your website contact form.')).'" target="_blank" rel="noopener">Chat on WhatsApp</a>
          <a class="btn btn-line" href="'.route('home').'">Back to home</a>
          <a class="btn btn-dark" href="'.route('page.show', 'booking').'">Book stay / event</a>',
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

    <?php if (! (session('contact_success'))): ?>
      <form class="form-card form-readable contact-form-card" method="POST" action="<?php echo e(route('contact.store')); ?>" id="contact-form">
        <?php echo csrf_field(); ?>
        <svg class="contact-form-leaf" viewBox="0 0 180 160" aria-hidden="true">
          <path fill="#2f5d45" opacity=".12" d="M160 20c-50 14-92 50-120 92 36-8 78 0 112 22-28-36-28-78 8-114z"/>
          <path fill="#173126" opacity=".1" d="M150 34c-36 14-64 42-84 78 28 0 64 8 92 22-28-36-28-78-8-100z"/>
          <path fill="#3d7a58" opacity=".1" d="M142 58c-28 8-64 28-86 56 36-6 72 0 100 14-28-22-28-50-14-70z"/>
        </svg>

        <div class="contact-form-head">
          <p class="eyebrow">Write to us</p>
          <h2>Send a message</h2>
          <p class="muted">Share your dates, guest count, or questions — we reply by phone, email, or WhatsApp.</p>
        </div>

        <div class="form-grid">
          <div class="field">
            <label for="c-name">Name</label>
            <div class="field-control">
              <span class="field-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M12 12a4.5 4.5 0 1 0-4.5-4.5A4.5 4.5 0 0 0 12 12zm0 2.2c-4 0-7.5 2-7.5 4.5V20h15v-1.3c0-2.5-3.5-4.5-7.5-4.5z"/></svg>
              </span>
              <input id="c-name" name="name" type="text" required placeholder="Your full name" value="<?php echo e(old('name')); ?>" autocomplete="name">
            </div>
          </div>
          <div class="field">
            <label for="c-email">Email</label>
            <div class="field-control">
              <span class="field-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 4-8 5L4 8V6l8 5 8-5z"/></svg>
              </span>
              <input id="c-email" name="email" type="email" required placeholder="you@email.com" value="<?php echo e(old('email')); ?>" autocomplete="email">
            </div>
          </div>
          <div class="field">
            <label for="c-phone">Phone</label>
            <div class="field-control">
              <span class="field-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.2 1.2.4 2.5.6 3.8.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.6 21 3 13.4 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.8.1.4 0 .8-.3 1.1L6.6 10.8z"/></svg>
              </span>
              <input id="c-phone" name="phone" type="tel" placeholder="10-digit mobile" value="<?php echo e(old('phone')); ?>" autocomplete="tel">
            </div>
          </div>
          <div class="field">
            <label for="c-subject">Subject</label>
            <div class="field-control">
              <span class="field-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M4 4h16v2H4zm0 4h10v2H4zm0 4h16v2H4zm0 4h10v2H4z"/></svg>
              </span>
              <input id="c-subject" name="subject" type="text" placeholder="How can we help?" value="<?php echo e(old('subject')); ?>">
            </div>
          </div>
          <div class="field full">
            <label for="c-message">Message</label>
            <div class="field-control is-textarea">
              <span class="field-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M4 4h16a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H9l-5 4v-4H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/></svg>
              </span>
              <textarea id="c-message" name="message" required placeholder="Tell us about your dates, guests, or questions"><?php echo e(old('message')); ?></textarea>
            </div>
          </div>
        </div>

        <div class="contact-form-foot">
          <button class="btn btn-clay contact-submit" type="submit">
            Send message
            <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="currentColor" d="M5 12h12.2l-4.6-4.6L14 6l7 7-7 7-1.4-1.4L17.2 13H5z"/></svg>
          </button>
          <p class="contact-trust">
            <span class="contact-trust-icon" aria-hidden="true">
              <svg viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M12 2 4 5v6c0 5 3.4 9.4 8 11 4.6-1.6 8-6 8-11V5l-8-3zm-1.2 13.2-3.5-3.5 1.4-1.4 2.1 2.1 4.5-4.5 1.4 1.4-5.9 5.9z"/></svg>
            </span>
            We typically respond the same day during host hours.
          </p>
        </div>
      </form>
    <?php endif; ?>

    <aside class="side-card contact-side">
      <div class="contact-side-media">
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
        <p class="contact-side-caption">A stay to remember</p>
      </div>
      <div class="pad">
        <p class="eyebrow">Reach hosts</p>
        <h3>Prefer a quick reply?</h3>
        <p class="muted contact-side-lead">WhatsApp is usually fastest. Calls are welcome too.</p>

        <ul class="contact-side-list">
          <li>
            <a href="tel:<?php echo e($phonePrimaryTel); ?>">
              <span class="contact-side-ico is-forest" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.2 1.2.4 2.5.6 3.8.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.6 21 3 13.4 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.8.1.4 0 .8-.3 1.1L6.6 10.8z"/></svg>
              </span>
              <span class="contact-side-copy">
                <strong><?php echo e($phonePrimary); ?></strong>
                <span>Primary phone</span>
              </span>
              <span class="contact-side-arrow" aria-hidden="true">›</span>
            </a>
          </li>
          <li>
            <a href="tel:<?php echo e($phoneSecondaryTel); ?>">
              <span class="contact-side-ico is-clay" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.2 1.2.4 2.5.6 3.8.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.6 21 3 13.4 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.8.1.4 0 .8-.3 1.1L6.6 10.8z"/></svg>
              </span>
              <span class="contact-side-copy">
                <strong><?php echo e($phoneSecondary); ?></strong>
                <span>Alternate phone</span>
              </span>
              <span class="contact-side-arrow" aria-hidden="true">›</span>
            </a>
          </li>
          <li>
            <a href="<?php echo e($mapsLink); ?>" target="_blank" rel="noopener">
              <span class="contact-side-ico is-gold" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M12 2C8.1 2 5 5.1 5 9c0 5.2 7 13 7 13s7-7.8 7-13c0-3.9-3.1-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5z"/></svg>
              </span>
              <span class="contact-side-copy">
                <strong>Building No. 7-334, Niduvaloor</strong>
                <span>Open map</span>
              </span>
              <span class="contact-side-arrow" aria-hidden="true">›</span>
            </a>
          </li>
        </ul>

        <div class="contact-side-actions">
          <a class="btn btn-gold contact-side-wa" href="<?php echo e($waUrl); ?>" data-whatsapp-chat data-whatsapp-phone="<?php echo e($waPhone); ?>" data-whatsapp-text="<?php echo e($waText); ?>" target="_blank" rel="noopener">
            <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="currentColor" d="M12 2a9.9 9.9 0 0 0-8.6 14.8L2 22l5.4-1.4A10 10 0 1 0 12 2zm5.7 14.1c-.2.7-1.3 1.2-2.1 1.4-.5.1-1.2.2-3.5-.7-2.9-1.3-4.7-4.4-4.9-4.6-.2-.2-1.5-2-1.5-3.8s1-2.7 1.3-3.1c.3-.3.7-.4 1-.4h.7c.2 0 .5 0 .7.6.3.7.9 2.3 1 2.4.1.2.1.4 0 .6-.1.2-.2.4-.4.6-.2.2-.4.4-.2.7.2.4.9 1.5 2 2.4 1.4 1.1 2.5 1.5 2.9 1.6.3.1.5.1.7-.1.2-.2.7-.8.9-1.1.2-.3.4-.2.7-.1.3.1 1.9.9 2.2 1.1.3.2.5.3.6.4.1.2.1.9-.1 1.6z"/></svg>
            Chat on WhatsApp
            <span aria-hidden="true">→</span>
          </a>
          <a class="btn btn-line contact-side-book" href="<?php echo e(route('page.show', 'booking')); ?>">
            <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="currentColor" d="M7 2h2v2h6V2h2v2h3v18H4V4h3V2zm13 8H6v10h14V10zm-2 2v2H8v-2h10z"/></svg>
            Send booking dates
            <span aria-hidden="true">→</span>
          </a>
        </div>
      </div>
    </aside>
  </div>
</section>

<section class="section contact-visit" aria-labelledby="contact-visit-heading">
  <div class="wrap contact-visit-wrap">
    <div class="contact-visit-stage">
      <div class="contact-visit-map">
        <div class="map-facade" data-map-src="<?php echo e($mapsEmbed); ?>" data-map-title="Google Map — IXORA Homestay at Niduvaloor Gate, Kannur">
          <button type="button" class="map-facade-btn">
            <span>Load interactive map</span>
            <small>Opens the exact IXORA Homestay pin</small>
          </button>
        </div>
      </div>

      <div class="contact-visit-card">
        <p class="eyebrow">Location</p>
        <h2 id="contact-visit-heading">Visit from here</h2>
        <p class="contact-visit-lead">IXORA Homestay is at Building No. 7-334, Niduvaloor Gate, Kannur (PIN 670142) — an affordable family homestay near Irikkur &amp; Thaliparamba with easy road access and on-site parking.</p>

        <div class="contact-visit-meta">
          <div class="contact-visit-meta-item">
            <span class="contact-visit-ico" aria-hidden="true">
              <svg viewBox="0 0 24 24" width="18" height="18"><path fill="currentColor" d="M12 2C8.1 2 5 5.1 5 9c0 5.2 7 13 7 13s7-7.8 7-13c0-3.9-3.1-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5z"/></svg>
            </span>
            <div>
              <strong>Address</strong>
              <span><?php echo nl2br(e($address)); ?></span>
            </div>
          </div>
        </div>

        <div class="contact-visit-actions">
          <a class="btn btn-gold" href="<?php echo e($mapsLink); ?>" target="_blank" rel="noopener">Open in Google Maps</a>
          <a class="btn btn-line" href="<?php echo e($waUrl); ?>" data-whatsapp-chat data-whatsapp-phone="<?php echo e($waPhone); ?>" data-whatsapp-text="<?php echo e($waText); ?>" target="_blank" rel="noopener">WhatsApp directions</a>
          <a class="btn btn-dark" href="<?php echo e(route('page.show', 'booking')); ?>">Check availability</a>
        </div>
      </div>
      </div>
    </div>
  </section><?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/frontend/templates/contact.blade.php ENDPATH**/ ?>