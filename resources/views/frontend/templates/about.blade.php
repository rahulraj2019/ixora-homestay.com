<section class="page-hero">
    <div class="wrap" style="max-width:760px">
        <p class="eyebrow">About IXORA Homestay Kannur...</p>
        <h1>{{ $page->title }}</h1>
        @if($page->meta_description)
            <p class="lede">{{ $page->meta_description }}</p>
        @endif
        <p><a class="btn btn-dark" href="{{ route('page.show', 'stay') }}">See family rooms</a> <a class="btn btn-line" href="{{ route('page.show', 'booking') }}">Book Homestay in Kannur</a></p>
    </div>
</section>
