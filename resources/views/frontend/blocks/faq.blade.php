<section class="section cms-block cms-block-faq">
    <div class="wrap">
        @if($block->activeItems->isNotEmpty())
            <div class="section-head">
                <div>
                    @if($block->subtitle)
                        <p class="eyebrow">{{ $block->subtitle }}</p>
                    @endif
                    @if($block->title)
                        <h2>{{ $block->title }}</h2>
                    @endif
                </div>
            </div>
            <div class="faq-list" data-faq>
                @foreach($block->activeItems as $index => $item)
                    <details class="faq-item" @if($index === 0) open @endif>
                        <summary>{{ $item->title }}</summary>
                        <div class="faq-body">
                            <p>{{ $item->description ?: $item->subtitle }}</p>
                        </div>
                    </details>
                @endforeach
            </div>
        @elseif($block->title || $block->content)
            <div class="faq-list" data-faq>
                <details class="faq-item" open>
                    <summary>{{ $block->title ?: 'Details' }}</summary>
                    @if($block->content)
                        <div class="faq-body">
                            <p>{!! nl2br(e($block->content)) !!}</p>
                        </div>
                    @endif
                </details>
            </div>
        @endif
    </div>
</section>
