@php
    $isHtml = ($block->block_type ?? '') === 'html';
    $items = $block->relationLoaded('activeItems') ? $block->activeItems : $block->activeItems()->get();
@endphp
<section class="section cms-block cms-block-{{ $block->block_type }}">
    <div class="wrap">
        @if($block->subtitle)
            <p class="eyebrow">{{ $block->subtitle }}</p>
        @endif
        @if($block->title)
            <h2>{{ $block->title }}</h2>
        @endif
        @if($block->content)
            <div class="lede cms-block-content">
                @if($isHtml)
                    {!! $block->content !!}
                @else
                    {!! nl2br(e($block->content)) !!}
                @endif
            </div>
        @endif
        @if($items->isNotEmpty())
            <div class="places" style="margin-top:22px">
                @foreach($items as $item)
                    <article class="place">
                        @if($item->image)
                            <img src="{{ media_url($item->image) }}" alt="{{ $item->title }}" loading="lazy">
                        @endif
                        <div class="pad">
                            @if($item->subtitle)<span class="place-type">{{ $item->subtitle }}</span>@endif
                            @if($item->title)<h3>{{ $item->title }}</h3>@endif
                            @if($item->description)<p class="muted">{{ $item->description }}</p>@endif
                            @if($item->button_url)
                                <a href="{{ $item->button_url }}">{{ $item->button_label ?: 'Learn more →' }}</a>
                            @elseif($item->link)
                                <a href="{{ $item->link }}">{{ $item->button_label ?: 'Learn more →' }}</a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>
