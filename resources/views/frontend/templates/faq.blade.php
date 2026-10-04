<section class="page-hero">
    <div class="wrap" style="max-width:760px">
      <p class="eyebrow">Help</p>
      <h1>{{ $page->title }}</h1>
      <p class="lede">{{ $page->meta_description }}</p>
    </div>
  </section>

  @if(($faqs ?? collect())->isNotEmpty())
    @php
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
    @endphp
    <script type="application/ld+json">{!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
  @endif

  <section class="section" style="padding-top:10px" id="faq">
    <div class="wrap faq-wrap">
      <div class="faq-list" data-faq>
        @forelse(($faqs ?? collect()) as $index => $faq)
          <details class="faq-item" @if($index === 0) open @endif>
            <summary>{{ $faq->question }}</summary>
            <div class="faq-body"><p>{!! $faq->answer !!}</p></div>
          </details>
        @empty
          <p class="muted">FAQs will appear here once they are published in the admin.</p>
        @endforelse
      </div>

      @php
        $faqPhone1 = setting('phone_primary', '89215 25086');
        $faqPhone2 = setting('phone_secondary', '80757 71824');
        $faqTel1 = preg_replace('/\s+/', '', setting('phone_primary', '+918921525086'));
        $faqTel2 = preg_replace('/\s+/', '', setting('phone_secondary', '+918075771824'));
        $faqWaUrl = whatsapp_url('Hi IXORA Homestay! I found your details on the website and I have a quick question.');
        $faqWaPhone = whatsapp_number();
        $faqWaText = whatsapp_message('Hi IXORA Homestay! I found your details on the website and I have a quick question.');
      @endphp
      <aside class="faq-aside">
        <div class="faq-aside-media">
          <x-site-img slot-key="shared.evening_aside" loading="lazy" />
          <p class="faq-aside-caption">A stay to remember</p>
        </div>
        <div class="faq-aside-pad">
          <p class="eyebrow">Still unsure?</p>
          <h2>Talk to the hosts</h2>
          <p class="muted">We are happy to help you pick dates, packages and add-ons for your stay or celebration.</p>
          <ul class="faq-aside-list">
            <li>
              <a href="tel:{{ $faqTel1 }}">
                <span class="faq-aside-ico is-forest" aria-hidden="true">
                  <svg viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.2 1.2.4 2.5.6 3.8.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.6 21 3 13.4 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.8.1.4 0 .8-.3 1.1L6.6 10.8z"/></svg>
                </span>
                <span class="faq-aside-copy">
                  <strong>{{ $faqPhone1 }}</strong>
                  <span>Primary phone</span>
                </span>
                <span class="faq-aside-arrow" aria-hidden="true">›</span>
              </a>
            </li>
            <li>
              <a href="tel:{{ $faqTel2 }}">
                <span class="faq-aside-ico is-clay" aria-hidden="true">
                  <svg viewBox="0 0 24 24" width="16" height="16"><path fill="currentColor" d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1.1-.2 1.2.4 2.5.6 3.8.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.6 21 3 13.4 3 4c0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.6.6 3.8.1.4 0 .8-.3 1.1L6.6 10.8z"/></svg>
                </span>
                <span class="faq-aside-copy">
                  <strong>{{ $faqPhone2 }}</strong>
                  <span>Alternate phone</span>
                </span>
                <span class="faq-aside-arrow" aria-hidden="true">›</span>
              </a>
            </li>
            <li>
              <a href="{{ $faqWaUrl }}" data-whatsapp-chat data-whatsapp-phone="{{ $faqWaPhone }}" data-whatsapp-text="{{ $faqWaText }}" target="_blank" rel="noopener">
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
            <a class="btn btn-gold" href="{{ $faqWaUrl }}" data-whatsapp-chat data-whatsapp-phone="{{ $faqWaPhone }}" data-whatsapp-text="{{ $faqWaText }}" target="_blank" rel="noopener">Chat on WhatsApp</a>
            <a class="btn btn-line faq-aside-book" href="{{ route('page.show', 'booking') }}">Check availability</a>
          </div>
        </div>
      </aside>
    </div>
  </section>
