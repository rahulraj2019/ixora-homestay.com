@if($image)
<img
    src="{{ $image['url'] }}"
    @if(!empty($image['srcset'])) srcset="{{ $image['srcset'] }}" @endif
    @if(!empty($image['sizes'])) sizes="{{ $image['sizes'] }}" @endif
    alt="{{ $image['alt'] }}"
    @if($image['width']) width="{{ $image['width'] }}" @endif
    @if($image['height']) height="{{ $image['height'] }}" @endif
    {{ $attributes->merge(['decoding' => 'async']) }}
>
@endif
