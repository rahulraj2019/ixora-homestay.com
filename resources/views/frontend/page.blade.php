@extends('layouts.app')

@section('body_class', ($page->slug ?? '') === 'home' ? 'home' : '')

@section('content')
    @php
        $template = $page->template ?: $page->slug;
        $view = 'frontend.templates.'.$template;
        $hasTemplate = view()->exists($view);
        $blocks = $page->activeBlocks;
    @endphp

    @if($hasTemplate)
        @include($view)
    @else
        <section class="page-hero">
            <div class="wrap">
                <p class="eyebrow">{{ $page->slug }}</p>
                <h1>{{ $page->title }}</h1>
                @if($page->meta_description)
                    <p class="lede">{{ $page->meta_description }}</p>
                @endif
            </div>
        </section>
    @endif

    @foreach($blocks as $block)
        @includeFirst([
            'frontend.blocks.'.$block->block_type,
            'frontend.blocks.generic',
        ], ['block' => $block])
    @endforeach
@endsection
