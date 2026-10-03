@extends('admin.layouts.app')
@section('title', 'FAQs')
@section('content')
<div class="toolbar toolbar--split">
    <a class="btn" href="{{ route('admin.faqs.create') }}">Add FAQ</a>
    <p class="toolbar__hint">Home page shows the first 8 active FAQs by sort order.</p>
</div>
<div class="panel">
    <div class="admin-list">
        @forelse($faqs as $faq)
            <article class="admin-list__item">
                <div>
                    <h3 class="admin-list__title">{{ $faq->question }}</h3>
                    <p class="admin-list__meta">Sort order {{ $faq->sort_order }}</p>
                </div>
                <div class="admin-list__facts">
                    <div class="admin-list__fact">
                        <span>Order</span>
                        <strong>{{ $faq->sort_order }}</strong>
                    </div>
                    <div class="admin-list__fact">
                        <span>Status</span>
                        <strong><span class="badge">{{ $faq->status }}</span></strong>
                    </div>
                </div>
                <div class="admin-list__actions">
                    <a class="btn" href="{{ route('admin.faqs.edit', $faq) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" onsubmit="return confirm('Delete this FAQ?')">
                        @csrf @method('DELETE')
                        <button class="btn danger" type="submit">Delete</button>
                    </form>
                </div>
            </article>
        @empty
            <div class="admin-list__item is-empty">No FAQs yet. <a href="{{ route('admin.faqs.create') }}">Add the first one</a>.</div>
        @endforelse
    </div>
    {{ $faqs->links() }}
</div>
@endsection
