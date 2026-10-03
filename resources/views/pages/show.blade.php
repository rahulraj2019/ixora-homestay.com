@extends('layouts.app')

@section('content')
<section class="page-hero">
    <div class="wrap">
        <h1>{{ $page->title }}</h1>
        @if($page->meta_description)
            <p class="lede">{{ $page->meta_description }}</p>
        @endif
    </div>
</section>
@endsection
