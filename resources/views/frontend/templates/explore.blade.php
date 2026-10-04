@php
  $heroImage = app(\App\Services\SiteImageService::class)->get('explore.hero');
@endphp
@push('head')
  @if($heroImage)
    <link
      rel="preload"
      as="image"
      href="{{ $heroImage['url'] }}"
      @if(!empty($heroImage['srcset'])) imagesrcset="{{ $heroImage['srcset'] }}" @endif
      @if(!empty($heroImage['sizes'])) imagesizes="{{ $heroImage['sizes'] }}" @endif
      fetchpriority="high"
      @if(str_ends_with($heroImage['url'], '.webp')) type="image/webp" @endif
    >
  @endif
@endpush

<section class="hero" style="min-height:72vh">
    <x-site-img slot-key="explore.hero" class="hero-bg" fetchpriority="high" />
    <div class="hero-shade"></div>
    <div class="wrap hero-content">
      <p class="eyebrow">Kannur Travel Guide</p>
      <h1>{{ $page->title }}</h1>
      <p class="lede">{{ $page->meta_description }}</p>
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
        @foreach(nearby_attractions() as $place)
          <article class="place" data-cat="{{ $place['cat'] }}">
            <img
              src="{{ $place['image_url'] }}"
              alt="{{ $place['alt'] ?? $place['title'] }}"
              width="640"
              height="420"
              loading="lazy"
              decoding="async"
            >
            <div class="pad">
              <span class="place-type">{{ $place['type'] }}</span>
              <h3>{{ $place['title'] }}</h3>
              <p class="muted">{{ $place['blurb'] }}</p>
              <p class="place-meta muted">~{{ $place['distance_km'] }} km · {{ $place['direction'] }} · ~{{ $place['drive_mins'] }} min</p>
              <a href="{{ $place['directions_url'] }}" target="_blank" rel="noopener">Directions →</a>
            </div>
          </article>
        @endforeach
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
          <x-site-img slot-key="explore.trip_1" loading="lazy" />
          <div class="pad">
            <h3>Hill sunset</h3>
            <ol><li>Breakfast at the homestay</li><li>Palakkayam Thattu for mist and views</li><li>Return before the campfire</li></ol>
            <p><a class="btn btn-gold" href="{{ route('page.show', 'booking') }}?addon=Palakkayam%20Thattu%20hill%20trip">Plan this trip</a></p>
          </div>
        </article>
        <article class="trip">
          <x-site-img slot-key="explore.trip_2" loading="lazy" />
          <div class="pad">
            <h3>Waterfall day</h3>
            <ol><li>Drive toward Paithalmala</li><li>Ezharakund’s seven-tier falls</li><li>Forest views, then back for dinner</li></ol>
            <p><a class="btn btn-gold" href="{{ route('page.show', 'booking') }}?addon=Ezharakund%20waterfall%20trip">Plan this trip</a></p>
          </div>
        </article>
        <article class="trip">
          <x-site-img slot-key="explore.trip_3" loading="lazy" />
          <div class="pad">
            <h3>Kannur coast</h3>
            <ol><li>St. Angelo Fort by the sea</li><li>Drive along Muzhappilangad Beach</li><li>Evening return to IXORA</li></ol>
            <p><a class="btn btn-gold" href="{{ route('page.show', 'booking') }}?addon=Kannur%20coast%20trip">Plan this trip</a></p>
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
      @php
        $mapsLink = homestay_maps_link();
        $mapsEmbed = homestay_maps_embed();
        $mapPlaces = array_slice(nearby_attractions(), 0, 8);
      @endphp

      <div class="explore-map-head">
        <div>
          <p class="eyebrow">Map</p>
          <h2 id="explore-map-heading">Where we are</h2>
          <p class="lede">IXORA at Niduvaloor Gate — open the pin, then pick a day trip with live directions.</p>
        </div>
        <a class="btn btn-line" href="{{ $mapsLink }}" target="_blank" rel="noopener">Open homestay pin ↗</a>
      </div>

      <div class="explore-map-stage">
        <div class="explore-map-canvas">
          <div class="map-facade" data-map-src="{{ $mapsEmbed }}" data-map-title="Google Map — IXORA Homestay, Niduvaloor Gate">
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
            @foreach($mapPlaces as $place)
              <a class="explore-map-item" href="{{ $place['directions_url'] }}" target="_blank" rel="noopener">
                <span class="explore-map-item-text">
                  <strong>{{ $place['title'] }}</strong>
                  <small>{{ $place['type'] }} · {{ $place['direction'] }}</small>
                </span>
                <span class="explore-map-km">~{{ $place['distance_km'] }} km</span>
              </a>
            @endforeach
          </div>

          <div class="explore-map-panel-foot">
            <a class="btn btn-gold" href="{{ $mapsLink }}" target="_blank" rel="noopener">Open map pin</a>
            <a class="btn btn-line" href="{{ route('page.show', 'contact') }}#contact-visit-heading">Contact &amp; arrival</a>
          </div>
        </aside>
      </div>
    </div>
  </section>
