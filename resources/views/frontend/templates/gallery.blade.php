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
        @foreach(site_image_group('gallery') as $shot)
          <button class="g-item" data-cat="{{ $shot['category'] }}" data-zoom="{{ $shot['url'] }}">
            <img src="{{ $shot['url'] }}" alt="{{ $shot['alt'] }}" @if($shot['width']) width="{{ $shot['width'] }}" @endif @if($shot['height']) height="{{ $shot['height'] }}" @endif loading="lazy" decoding="async">
            <span class="cap">{{ $shot['caption'] }}</span>
          </button>
        @endforeach
      </div>
    </div>
  </section>
