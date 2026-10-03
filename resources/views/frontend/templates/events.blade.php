<section class="hero" style="min-height:78vh">
    <x-site-img slot-key="events.hero" class="hero-bg" />
    <div class="hero-shade"></div>
    <div class="wrap hero-content">
      <p class="eyebrow">Event venue &amp; Kannur homestay</p>
      <h1>Celebrate at your<br><em>private Kannur stay.</em></h1>
      <p class="lede">Host birthdays, engagements and family functions at IXORA — a peaceful Niduvaloor homestay venue with courtyard, stage options, photo point, campfire and grill.</p>
      <div class="hero-actions">
        <a class="btn btn-gold" href="#packages">Explore packages</a>
        <a class="btn btn-ghost" href="{{ route('page.show', 'booking') }}?type=birthday">Plan my event</a>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="wrap">
      <div class="section-head">
        <div>
          <p class="eyebrow">Event types</p>
          <h2>What you can celebrate here</h2>
        </div>
      </div>
      <div class="rooms">
        <article class="room">
          <x-site-img slot-key="events.card_1" loading="lazy" />
          <div class="pad"><h3>Birthday parties</h3><p class="muted">Cake, decorations, stage and games for memorable birthdays.</p><a href="{{ route('page.show', 'booking') }}?type=birthday">Plan a birthday →</a></div>
        </article>
        <article class="room">
          <x-site-img slot-key="events.card_2" loading="lazy" />
          <div class="pad"><h3>Engagement functions</h3><p class="muted">An intimate, photo-friendly setting for your engagement ceremony.</p><a href="{{ route('page.show', 'booking') }}?type=engagement">Plan an engagement →</a></div>
        </article>
        <article class="room">
          <x-site-img slot-key="events.card_3" loading="lazy" />
          <div class="pad"><h3>Family gatherings</h3><p class="muted">Bring the whole family together in a private, relaxed space.</p><a href="{{ route('page.show', 'booking') }}?type=family">Plan a gathering →</a></div>
        </article>
        <article class="room">
          <x-site-img slot-key="events.card_4" loading="lazy" />
          <div class="pad"><h3>Friends get-together</h3><p class="muted">Campfire, grill and games for an unforgettable weekend with friends.</p><a href="{{ route('page.show', 'booking') }}?type=friends">Plan a weekend →</a></div>
        </article>
        <article class="room">
          <x-site-img slot-key="events.card_5" loading="lazy" />
          <div class="pad"><h3>Campfire nights</h3><p class="muted">An open courtyard, warm light and room to linger after dinner.</p><a href="{{ route('page.show', 'booking') }}?addon=Campfire">Add a campfire →</a></div>
        </article>
        <article class="room">
          <x-site-img slot-key="events.card_6" loading="lazy" />
          <div class="pad"><h3>Photo point</h3><p class="muted">A flower-decked swing made for portraits and family pictures.</p><a href="{{ route('page.show', 'gallery') }}">See the setup →</a></div>
        </article>
      </div>
    </div>
  </section>

  <section class="section" id="packages" style="padding-top:0">
    <div class="wrap">
      <div class="section-head">
        <div>
          <p class="eyebrow">Packages</p>
          <h2>Event package pricing</h2>
        </div>
        <p class="muted">Prices may vary based on date, guest count and event requirements.</p>
      </div>
      <div class="prices">
        <article class="price">
          <h3>Essential</h3>
          <div class="amount">On request</div>
          <ul><li>Venue</li><li>Basic setup</li><li>Kitchen access</li></ul>
          <a class="btn btn-line" href="{{ route('page.show', 'booking') }}?type=custom&addon=Essential%20package">Book Essential</a>
        </article>
        <article class="price featured">
          <span class="tag">Celebration</span>
          <h3>Celebration</h3>
          <div class="amount">On request</div>
          <ul><li>Venue</li><li>Stage</li><li>Decoration space</li><li>Photo point</li><li>Campfire</li></ul>
          <a class="btn btn-gold" href="{{ route('page.show', 'booking') }}?type=birthday&addon=Celebration%20package">Book Celebration</a>
        </article>
        <article class="price">
          <h3>Custom event</h3>
          <div class="amount">Let’s plan</div>
          <ul><li>Custom decoration</li><li>Food</li><li>Photography</li><li>Entertainment</li><li>Personalized setup</li></ul>
          <a class="btn btn-line" href="{{ route('page.show', 'booking') }}?type=custom">Get a custom quote</a>
        </article>
      </div>
    </div>
  </section>
