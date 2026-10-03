<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.seo')
    <link rel="icon" href="{{ setting('favicon') ? asset('storage/'.setting('favicon')) : asset('assets/images/ixora-homestay-logo.webp') }}" type="image/webp">
    <link rel="preload" href="{{ asset('assets/fonts/gf-18.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('assets/fonts/gf-5.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset_versioned('assets/css/fonts.css') }}" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="{{ asset_versioned('assets/css/fonts.css') }}"></noscript>
    {{-- Critical header layout (mobile-safe) --}}
    <style>
      .header{position:fixed;top:16px;left:50%;transform:translateX(-50%);z-index:40;height:68px;display:grid;grid-template-columns:auto minmax(0,1fr) auto;align-items:center;column-gap:12px;padding:0 14px 0 18px;width:min(1240px,calc(100% - 32px));max-width:calc(100% - 32px);box-sizing:border-box}
      .header-end{display:flex;align-items:center;justify-content:flex-end;gap:8px;justify-self:end;flex-shrink:0}
      .nav{display:flex;align-items:center;justify-content:center;justify-self:center;min-width:0}
      .nav-toggle{display:none}
      .wa{position:fixed;right:18px;bottom:22px;z-index:80;width:58px;height:58px;border-radius:50%;background:#25d366;display:grid;place-items:center}
      @media (max-width:860px){
        .nav{display:flex;flex-direction:column;opacity:0;visibility:hidden;pointer-events:none;position:absolute;top:calc(100% + 12px);left:0;right:0}
        .nav.open{opacity:1;visibility:visible;pointer-events:auto}
        .nav-toggle{display:grid;place-items:center}
        .header-end .btn-clay{display:none}
        .nav-mobile-head,.nav-mobile-cta{display:none}
        .wa{right:14px;bottom:calc(86px + env(safe-area-inset-bottom, 0px));width:52px;height:52px;z-index:80}
        .mobile-bar-call{display:grid;place-items:center;position:fixed;left:14px;bottom:calc(86px + env(safe-area-inset-bottom, 0px));z-index:80;width:46px;height:46px;border-radius:50%;background:var(--clay,#c45d3a);color:#fff}
      }
      .section{content-visibility:auto;contain-intrinsic-size:1px 720px}
      .hero,.header{content-visibility:visible}
    </style>
    <link rel="stylesheet" href="{{ asset_versioned('assets/css/style.min.css') }}">
    @stack('head')
    @stack('styles')
    @include('partials.schema')
</head>
<body class="@yield('body_class')">
    <a class="skip-link" href="#main-content">Skip to content</a>
    @include('partials.header')

    <main id="main-content">
        @if(session('success') && ! session('booking_reference') && ! session('contact_success'))
            <div class="wrap" style="padding-top:1rem">
                @include('partials.flash-card', [
                    'type' => 'success',
                    'eyebrow' => 'Done',
                    'title' => 'Thank you',
                    'message' => session('success'),
                ])
            </div>
        @endif
        @if(session('error'))
            <div class="wrap" style="padding-top:1rem">
                @include('partials.flash-card', [
                    'type' => 'error',
                    'eyebrow' => 'Error',
                    'title' => 'Something went wrong',
                    'message' => session('error'),
                ])
            </div>
        @endif

        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.whatsapp')
    @include('partials.mobile-bar')

    <div class="lightbox" hidden>
      <button type="button" aria-label="Close">✕</button>
      <div class="lightbox-stage">
        <img alt="" width="1200" height="800" decoding="async" hidden>
        <video class="lightbox-video" controls playsinline preload="none" hidden></video>
      </div>
    </div>
    <script>
        window.IXORA = {
            routes: {
                booking: @json(route('booking.store')),
                reviews: @json(route('reviews.index')),
                reviewsStore: @json(route('reviews.store')),
                bookingPage: @json(route('page.show', 'booking')),
            },
            csrf: @json(csrf_token()),
            whatsapp: @json(whatsapp_number()),
            whatsappMessage: @json(whatsapp_message()),
            whatsappUrl: @json(whatsapp_url()),
        };
    </script>
    <script src="{{ asset_versioned('assets/js/main.min.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
