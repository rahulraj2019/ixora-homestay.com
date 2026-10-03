@extends('admin.layouts.app')
@section('title', 'Reviews')
@section('subtitle', 'Approve guest feedback before it appears on the website')
@section('content')

@php
    $reviewStatusTones = [
        'pending' => 'warn',
        'approved' => 'ok',
        'rejected' => 'danger',
    ];
@endphp
<div class="cards cards--stats" aria-label="Filter by status">
    <a class="card card--link card--neutral{{ ($status ?? '') === '' ? ' is-active' : '' }}" href="{{ route('admin.reviews.index') }}#reviews-list">
        <span class="card__label">All</span>
        <strong class="card__value">{{ $statusCounts['all'] ?? 0 }}</strong>
    </a>
    @foreach(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $key => $label)
        <a
            class="card card--link card--{{ $reviewStatusTones[$key] ?? 'neutral' }}{{ ($status ?? '') === $key ? ' is-active' : '' }}"
            href="{{ route('admin.reviews.index', ['status' => $key]) }}#reviews-list"
        >
            <span class="card__label">{{ $label }}</span>
            <strong class="card__value">{{ $statusCounts[$key] ?? 0 }}</strong>
        </a>
    @endforeach
</div>

<div class="panel" id="reviews-list">
    <div class="panel__head">
        <h2>
            @if(($status ?? '') !== '')
                {{ ucfirst($status) }} reviews
            @else
                All reviews
            @endif
        </h2>
        <span class="muted">{{ $reviews->total() }} result{{ $reviews->total() === 1 ? '' : 's' }}</span>
    </div>
    <div class="admin-list">
        @forelse($reviews as $review)
            <article class="admin-list__item">
                <div>
                    <h3 class="admin-list__title">{{ $review->name }}</h3>
                    <p class="admin-list__meta">{{ $review->location ?: 'Guest' }} · {{ $review->rating }}/5</p>
                    <p class="admin-list__body" style="margin-top:.55rem">{{ Str::limit($review->message, 160) }}</p>
                </div>
                <div class="admin-list__facts">
                    <div class="admin-list__fact">
                        <span>Rating</span>
                        <strong>{{ $review->rating }}/5</strong>
                    </div>
                    <div class="admin-list__fact">
                        <span>Status</span>
                        <strong>
                            <form method="POST" action="{{ route('admin.reviews.update', $review) }}">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()">
                                    @foreach(['pending', 'approved', 'rejected'] as $s)
                                        <option value="{{ $s }}" @selected($review->status === $s)>{{ $s }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </strong>
                    </div>
                </div>
                <div class="admin-list__actions">
                    <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" onsubmit="return confirm('Delete this review?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn danger" type="submit">Delete</button>
                    </form>
                </div>
            </article>
        @empty
            <div class="admin-list__item is-empty">No reviews found for this filter.</div>
        @endforelse
    </div>
    {{ $reviews->links() }}
</div>
@endsection
