<header class="header">
    <a class="brand" href="{{ route('home') }}">
        <img src="{{ setting('logo') ? asset('storage/'.setting('logo')) : asset('assets/images/ixora-homestay-logo.webp') }}" alt="{{ setting('business_name', 'IXORA Homestay') }} logo — Niduvaloor Kannur" width="84" height="84" decoding="async">
        <div>
            <strong>{{ setting('brand_name', 'IXORA') }}</strong>
            <span>{{ setting('tagline', 'A lush homestay retreat') }}</span>
        </div>
    </a>
    @include('partials.navigation')
    <div class="header-end">
        <button class="nav-toggle" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="site-nav">
            <span></span>
        </button>
        <a class="btn btn-clay" href="{{ route('page.show', 'booking') }}">Book Now</a>
    </div>
</header>
<div class="nav-backdrop" hidden></div>
