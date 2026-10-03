<section class="page-hero">
    <div class="wrap" style="max-width:760px">
      <p class="eyebrow">Help</p>
      <h1>Frequently asked questions</h1>
      <p class="lede">Everything you need to know before booking a stay or celebration at IXORA, Niduvaloor Gate.</p>
    </div>
  </section>

  <?php if(($faqs ?? collect())->isNotEmpty()): ?>
    <?php
      $faqSchema = [
          '@context' => 'https://schema.org',
          '@type' => 'FAQPage',
          'mainEntity' => ($faqs ?? collect())->map(fn ($faq) => [
              '@type' => 'Question',
              'name' => $faq->question,
              'acceptedAnswer' => [
                  '@type' => 'Answer',
                  'text' => trim(strip_tags($faq->answer)),
              ],
          ])->values()->all(),
      ];
    ?>
    <script type="application/ld+json"><?php echo json_encode($faqSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE); ?></script>
  <?php endif; ?>

  <section class="section" style="padding-top:10px" id="faq">
    <div class="wrap faq-wrap">
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

      <?php
        $faqPhone1 = setting('phone_primary', '89215 25086');
        $faqPhone2 = setting('phone_secondary', '80757 71824');
        $faqTel1 = preg_replace('/\s+/', '', setting('phone_primary', '+918921525086'));
        $faqTel2 = preg_replace('/\s+/', '', setting('phone_secondary', '+918075771824'));
        $faqWaUrl = whatsapp_url('Hi IXORA Homestay! I found your details on the website and I have a quick question.');
        $faqWaPhone = whatsapp_number();
        $faqWaText = whatsapp_message('Hi IXORA Homestay! I found your details on the website and I have a quick question.');
      ?>
      <aside class="faq-aside">
        <div class="faq-aside-media">
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
          <p class="faq-aside-caption">A stay to remember</p>
        </div>
        <div class="faq-aside-pad">
          <p class="eyebrow">Still unsure?</p>
          <h2>Talk to the hosts</h2>
          <p class="muted">We are happy to help you pick dates, packages and add-ons for your stay or celebration.</p>
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
  </section>
<?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/frontend/templates/faq.blade.php ENDPATH**/ ?>