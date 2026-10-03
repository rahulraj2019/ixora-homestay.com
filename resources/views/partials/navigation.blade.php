@php
    $current = $page->slug ?? request()->path();
    $nav = [
        ['slug' => 'home', 'label' => 'Home', 'url' => route('home')],
        ['slug' => 'about', 'label' => 'About', 'url' => route('page.show', 'about')],
        ['slug' => 'events', 'label' => 'Events', 'url' => route('page.show', 'events')],
        ['slug' => 'explore', 'label' => 'Explore', 'url' => route('page.show', 'explore')],
        ['slug' => 'gallery', 'label' => 'Gallery', 'url' => route('page.show', 'gallery')],
        ['slug' => 'contact', 'label' => 'Contact', 'url' => route('page.show', 'contact')],
    ];
    $phoneTel = preg_replace('/\s+/', '', setting('phone_primary', '+918921525086'));
@endphp
<nav class="nav" id="site-nav" aria-label="Primary">
    <div class="nav-mobile-head">
        <p class="nav-mobile-kicker">{{ setting('brand_name', 'IXORA') }}</p>
        <p class="nav-mobile-title">Where would you like to go?</p>
    </div>

    <div class="nav-links">
        @foreach($nav as $item)
            <a
                class="nav-link{{ ($current === $item['slug'] || ($item['slug'] === 'home' && request()->routeIs('home'))) ? ' is-active' : '' }}"
                href="{{ $item['url'] }}"
                @if($current === $item['slug'] || ($item['slug'] === 'home' && request()->routeIs('home'))) aria-current="page" @endif
            >
                <span>{{ $item['label'] }}</span>
                <span class="nav-link-arrow" aria-hidden="true">›</span>
            </a>
        @endforeach
    </div>

    <div class="nav-mobile-cta">
        <a class="btn btn-clay nav-mobile-book" href="{{ route('page.show', 'booking') }}">Book Now</a>
        <a class="btn btn-line nav-mobile-call" href="tel:{{ $phoneTel }}">Call hosts</a>
    </div>
</nav>
