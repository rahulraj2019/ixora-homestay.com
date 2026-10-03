@extends('admin.layouts.app')
@section('title', 'Site Images')
@section('content')
<div class="panel site-images-intro">
    <p>
        1) Upload photos in <a href="{{ route('admin.media.index') }}">Media Library</a>.
        2) Choose a photo for each card below.
        3) Save — the public site updates right away (blank = default asset).
    </p>
</div>

<form method="POST" action="{{ route('admin.site-images.update') }}" class="site-images-form">
    @csrf @method('PUT')

    <div class="site-images-sticky">
        <button class="btn" type="submit">Save all assignments</button>
        <a class="btn line" href="{{ route('admin.media.index') }}">Open Media Library</a>
    </div>

    @foreach($slots as $group => $groupSlots)
        <section class="panel site-images-section">
            <header class="site-images-section__head">
                <h2>{{ str_replace('_', ' ', $group) }}</h2>
                <span class="badge">{{ $groupSlots->count() }} slots</span>
            </header>

            <div class="site-image-grid">
                @foreach($groupSlots as $slot)
                    <article class="site-image-card{{ ! empty($slot['is_custom']) ? ' is-custom' : '' }}">
                        <div class="site-image-card__preview">
                            <img src="{{ $slot['url'] }}" alt="{{ $slot['alt'] }}" loading="lazy">
                            <span class="site-image-card__badge">
                                {{ ! empty($slot['is_custom']) ? 'Media Library' : 'Default' }}
                            </span>
                        </div>
                        <div class="site-image-card__body">
                            <h3>{{ $slot['label'] }}</h3>
                            <p class="site-image-card__key"><code>{{ $slot['key'] }}</code></p>
                            <label class="site-image-card__label" for="slot-{{ md5($slot['key']) }}">Choose image</label>
                            <select id="slot-{{ md5($slot['key']) }}" name="assignments[{{ $slot['key'] }}]">
                                <option value="">— Default asset —</option>
                                @foreach($mediaOptions as $medium)
                                    <option value="{{ $medium->id }}" @selected(($slot['media_id'] ?? null) == $medium->id)>
                                        #{{ $medium->id }} — {{ \Illuminate\Support\Str::limit($medium->title ?: $medium->filename, 36) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endforeach

    <div class="site-images-sticky is-bottom">
        <button class="btn" type="submit">Save all assignments</button>
    </div>
</form>
@endsection
