@extends('admin.layouts.app')
@section('title', 'Pages')
@section('content')
<div class="toolbar">
    <a class="btn" href="{{ route('admin.pages.create') }}">Create page</a>
</div>
<div class="panel">
    <div class="admin-list">
        @forelse($pages as $page)
            <article class="admin-list__item">
                <div>
                    <h3 class="admin-list__title">{{ $page->title }}</h3>
                    <p class="admin-list__meta">/{{ $page->slug }} · template: {{ $page->template ?: '—' }}</p>
                </div>
                <div class="admin-list__facts">
                    <div class="admin-list__fact">
                        <span>Status</span>
                        <strong><span class="badge">{{ $page->status }}</span></strong>
                    </div>
                    <div class="admin-list__fact">
                        <span>Template</span>
                        <strong>{{ $page->template ?: '—' }}</strong>
                    </div>
                </div>
                <div class="admin-list__actions">
                    <a class="btn" href="{{ route('admin.pages.edit', $page) }}">Edit</a>
                    @if($page->status === 'published' && $page->slug !== 'home')
                        <a class="btn line" href="{{ route('page.show', $page->slug) }}" target="_blank">View</a>
                    @elseif($page->slug === 'home')
                        <a class="btn line" href="{{ route('home') }}" target="_blank">View</a>
                    @endif
                </div>
            </article>
        @empty
            <div class="admin-list__item is-empty">No pages yet.</div>
        @endforelse
    </div>
    {{ $pages->links() }}
</div>
@endsection
