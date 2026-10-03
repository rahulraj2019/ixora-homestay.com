@php
  $places = nearby_sacred_places();
@endphp
@if(count($places))
<section class="section" id="sacred-places" aria-labelledby="sacred-places-heading">
  <div class="wrap">
    <div class="section-head">
      <div>
        <p class="eyebrow">{{ $eyebrow ?? 'Faith & culture' }}</p>
        <h2 id="sacred-places-heading">{{ $heading ?? 'Temples & sacred places near IXORA' }}</h2>
      </div>
      @if(! empty($showExploreLink))
        <a class="btn btn-line" href="{{ route('page.show', 'explore') }}#places">All attractions</a>
      @endif
    </div>
    <p class="lede places-intro">{{ $lede ?? 'Nearest temples and pilgrimage centres from Niduvaloor Gate — same photo-card style as our travel guide.' }}</p>

    <div class="places">
      @foreach($places as $place)
        <article class="place">
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
  </div>
</section>
@endif
