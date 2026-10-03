<section class="page-hero">
    <div class="wrap">
      <p class="eyebrow">Family Homestay in Kannur</p>
      <h1>Private rooms &amp; full house for family stays</h1>
      <p class="lede">Affordable family homestay near Irikkur &amp; Thaliparamba — two bedrooms, kitchen, dining, living area, courtyard and parking at Niduvaloor Gate, Kannur Kerala.</p>
      <div class="hero-actions">
        <a class="btn btn-dark" href="{{ route('page.show', 'booking') }}?type=homestay">Check availability</a>
        <a class="btn btn-line" href="{{ route('page.show', 'gallery') }}">View gallery</a>
      </div>
      <div class="stats">
        <div class="stat"><strong>2</strong><span>Bedrooms</span></div>
        <div class="stat"><strong>1</strong><span>Living &amp; dining</span></div>
        <div class="stat"><strong>1</strong><span>Kitchen</span></div>
        <div class="stat"><strong>Full</strong><span>Private courtyard</span></div>
      </div>
    </div>
  </section>

  <section class="section" style="padding-top:20px">
    <div class="wrap">
      <div class="section-head">
        <div>
          <p class="eyebrow">Property overview</p>
          <h2>Everything your group needs</h2>
        </div>
        <p class="muted">Games and parking are included, so the house works for a quiet night in or a full family weekend.</p>
      </div>
      <div class="amenity-grid wide">
        <div class="amenity"><i></i> 2 Bedrooms</div>
        <div class="amenity"><i></i> 1 Living area</div>
        <div class="amenity"><i></i> 1 Dining room</div>
        <div class="amenity"><i></i> Kitchen</div>
        <div class="amenity"><i></i> Private courtyard</div>
        <div class="amenity"><i></i> Games</div>
        <div class="amenity"><i></i> Parking</div>
        <div class="amenity"><i></i> Photo point</div>
      </div>
    </div>
  </section>

  <section class="section" style="padding-top:0">
    <div class="wrap">
      <div class="section-head">
        <div>
          <p class="eyebrow">Rooms &amp; spaces</p>
          <h2>Inside the homestay</h2>
        </div>
      </div>
      <div class="rooms">
        <article class="room">
          <x-site-img slot-key="stay.room_1" loading="lazy" />
          <div class="pad"><h3>Bedroom 1</h3><p class="muted">A restful bedroom with comfortable bedding.</p></div>
        </article>
        <article class="room">
          <x-site-img slot-key="stay.room_2" loading="lazy" />
          <div class="pad"><h3>Bedroom 2</h3><p class="muted">A second bedroom ideal for families or groups.</p></div>
        </article>
        <article class="room">
          <x-site-img slot-key="stay.living" loading="lazy" />
          <div class="pad"><h3>Living room</h3><p class="muted">A spacious living and dining area to gather.</p></div>
        </article>
        <article class="room">
          <x-site-img slot-key="stay.kitchen" loading="lazy" />
          <div class="pad"><h3>Kitchen</h3><p class="muted">A functional kitchen for home-style cooking.</p></div>
        </article>
        <article class="room">
          <x-site-img slot-key="stay.courtyard" loading="lazy" />
          <div class="pad"><h3>Courtyard</h3><p class="muted">The open courtyard at the heart of the property.</p></div>
        </article>
        <article class="room">
          <x-site-img slot-key="stay.photo_point" loading="lazy" />
          <div class="pad"><h3>Photo point</h3><p class="muted">A flower-decked swing for portraits in the garden.</p></div>
        </article>
      </div>
    </div>
  </section>

  <section class="section" style="padding-top:0">
    <div class="wrap split">
      @php
        $tourVideoRel = 'assets/videos/ixora-homestay-property-tour.mp4';
        $tourPosterRel = 'assets/images/ixora-homestay-tour-poster.jpg';
        $tourVideoPath = public_path($tourVideoRel);
        $tourPosterPath = public_path($tourPosterRel);
        $hasTourVideo = is_file($tourVideoPath) && filesize($tourVideoPath) > 0 && filesize($tourVideoPath) < 80 * 1024 * 1024;
        $tourVersion = $hasTourVideo ? (string) filemtime($tourVideoPath) : (string) time();
        $posterVersion = is_file($tourPosterPath) ? (string) filemtime($tourPosterPath) : $tourVersion;
        $tourPosterUrl = asset($tourPosterRel).'?v='.$posterVersion;
        $tourVideoUrl = asset($tourVideoRel).'?v='.$tourVersion;
      @endphp
      <div class="wide-media wide-media-video" style="height:100%; min-height:360px">
        @if($hasTourVideo)
          <video
            controls
            playsinline
            preload="none"
            poster="{{ $tourPosterUrl }}"
            width="1280"
            height="720"
            title="IXORA Homestay property tour — Niduvaloor Kannur"
          >
            <source src="{{ $tourVideoUrl }}" type="video/mp4">
          </video>
        @else
          <img src="{{ $tourPosterUrl }}" alt="{{ site_image('stay.wide')['alt'] ?? 'IXORA Homestay property tour' }}" loading="lazy" width="1280" height="720">
        @endif
      </div>
      <div>
        <p class="eyebrow">Property tour</p>
        <h2>Walk through the homestay</h2>
        <p class="lede">Take in the 2 BHK — the bedrooms, living and dining area, kitchen and the courtyard at the heart of it all.</p>
        <p class="muted">Check-in is 12:00 PM and check-out is 11:00 AM. Extra guest charges apply beyond the base occupancy. Cancellation policy is available on request.</p>
        <a class="btn btn-dark" href="{{ route('page.show', 'gallery') }}">See every room</a>
      </div>
    </div>
  </section>

  <section class="section" style="padding-top:0">
    <div class="wrap">
      <div class="section-head">
        <div>
          <p class="eyebrow">Stay pricing</p>
          <h2>Rates &amp; details</h2>
        </div>
      </div>
      <div class="prices">
        <article class="price"><h3>Weekday stay</h3><div class="amount">On request</div><p>A quieter midweek night in the full house.</p><a class="btn btn-line" href="{{ route('page.show', 'booking') }}?type=homestay">Check dates</a></article>
        <article class="price featured"><span class="tag">Weekend</span><h3>Weekend stay</h3><div class="amount">On request</div><p>Friday to Sunday, when the courtyard comes alive.</p><a class="btn btn-gold" href="{{ route('page.show', 'booking') }}?type=homestay">Book your stay</a></article>
        <article class="price"><h3>Group stay</h3><div class="amount">Custom</div><p>Larger families and friend groups, priced to the plan.</p><a class="btn btn-line" href="{{ route('page.show', 'booking') }}?type=friends">Ask for a quote</a></article>
      </div>
    </div>
  </section>

  <section class="section" style="padding-top:0">
    <div class="wrap">
      <div class="section-head">
        <div>
          <p class="eyebrow">Add-on experiences</p>
          <h2>Make it memorable</h2>
        </div>
      </div>
      <div class="addons">
        <div class="addon"><div><strong>Campfire setup</strong><span class="muted">From enquiry</span></div><a class="btn btn-line" href="{{ route('page.show', 'booking') }}?addon=Campfire%20setup">Add</a></div>
        <div class="addon"><div><strong>BBQ / grill setup</strong><span class="muted">From enquiry</span></div><a class="btn btn-line" href="{{ route('page.show', 'booking') }}?addon=BBQ%20grill%20setup">Add</a></div>
        <div class="addon"><div><strong>Birthday decoration</strong><span class="muted">From enquiry</span></div><a class="btn btn-line" href="{{ route('page.show', 'booking') }}?addon=Birthday%20decoration">Add</a></div>
        <div class="addon"><div><strong>Professional photography</strong><span class="muted">From enquiry</span></div><a class="btn btn-line" href="{{ route('page.show', 'booking') }}?addon=Professional%20photography">Add</a></div>
        <div class="addon"><div><strong>Food arrangement</strong><span class="muted">From enquiry</span></div><a class="btn btn-line" href="{{ route('page.show', 'booking') }}?addon=Food%20arrangement">Add</a></div>
        <div class="addon"><div><strong>Local travel assistance</strong><span class="muted">From enquiry</span></div><a class="btn btn-line" href="{{ route('page.show', 'booking') }}?addon=Local%20travel%20assistance">Add</a></div>
      </div>
      <p style="margin-top:22px"><a class="btn btn-dark" href="{{ route('page.show', 'booking') }}">Continue to booking</a></p>
    </div>
  </section>
