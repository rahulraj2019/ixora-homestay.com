@php
    $type = $type ?? 'success';
    $eyebrow = $eyebrow ?? ($type === 'success' ? 'All set' : 'Please check');
    $title = $title ?? ($type === 'success' ? 'Thank you!' : 'Something needs attention');
    $message = $message ?? '';
@endphp
<div class="flash-card flash-{{ $type }}" id="{{ $id ?? '' }}" role="{{ $type === 'success' ? 'status' : 'alert' }}">
    <div class="flash-icon" aria-hidden="true">
        @if($type === 'success')
            ✓
        @else
            !
        @endif
    </div>
    <div class="flash-body">
        <p class="flash-eyebrow">{{ $eyebrow }}</p>
        <h2 class="flash-title">{{ $title }}</h2>
        @if($message)
            <p class="flash-text">{{ $message }}</p>
        @endif
        @isset($reference)
            <p class="flash-ref"><strong>Reference:</strong> <span>{{ $reference }}</span></p>
        @endisset
        @isset($actions)
            <div class="flash-actions">
                {!! $actions !!}
            </div>
        @endisset
    </div>
</div>
