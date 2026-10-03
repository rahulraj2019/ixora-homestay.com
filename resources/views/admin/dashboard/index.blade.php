@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Overview of bookings, enquiries, and site content')

@section('content')
<div class="dash-intro">
    <div>
        <p class="dash-intro__eyebrow">Welcome back{{ auth()->user()?->name ? ', '.auth()->user()->name : '' }}</p>
        <p class="dash-intro__text">Tap any card below to open that section. Focus on new bookings and pending reviews first.</p>
    </div>
    <div class="dash-intro__actions">
        <a class="btn" href="{{ route('admin.bookings.index', ['status' => 'new']) }}">New bookings</a>
        <a class="btn line" href="{{ route('home') }}" target="_blank" rel="noopener">View website</a>
    </div>
</div>

<div class="cards cards--stats" aria-label="Quick stats">
    @foreach($statCards as $card)
        <a class="card card--link card--{{ $card['tone'] ?? 'neutral' }}" href="{{ $card['url'] }}">
            <span class="card__label">{{ $card['label'] }}</span>
            <strong class="card__value">{{ $card['value'] }}</strong>
        </a>
    @endforeach
</div>

<div class="dash-grid">
    <div class="panel">
        <div class="panel__head">
            <h2>Recent bookings</h2>
            <a class="btn line btn-sm" href="{{ route('admin.bookings.index') }}">View all</a>
        </div>
        <div class="admin-list">
            @forelse($recentBookings as $b)
                <article class="admin-list__item">
                    <div>
                        <h3 class="admin-list__title">
                            <a href="{{ route('admin.bookings.show', $b) }}">{{ $b->booking_reference }}</a>
                        </h3>
                        <p class="admin-list__meta">{{ $b->name }} · {{ $b->booking_type }}</p>
                    </div>
                    <div class="admin-list__facts">
                        <div class="admin-list__fact">
                            <span>Date</span>
                            <strong>{{ optional($b->check_in)->format('d M Y') ?: '—' }}</strong>
                        </div>
                        <div class="admin-list__fact">
                            <span>Status</span>
                            <strong><span class="badge badge-{{ $b->status }}">{{ $b->statusLabel() }}</span></strong>
                        </div>
                    </div>
                </article>
            @empty
                <div class="admin-list__item is-empty">No bookings yet.</div>
            @endforelse
        </div>
    </div>

    <div class="panel">
        <div class="panel__head">
            <h2>Recent enquiries</h2>
            <a class="btn line btn-sm" href="{{ route('admin.enquiries.index') }}">View all</a>
        </div>
        <div class="admin-list">
            @forelse($recentEnquiries as $enquiry)
                <article class="admin-list__item">
                    <div>
                        <h3 class="admin-list__title">
                            <a href="{{ route('admin.enquiries.show', $enquiry) }}">{{ $enquiry->name }}</a>
                        </h3>
                        <p class="admin-list__meta">{{ $enquiry->email }}</p>
                    </div>
                    <div class="admin-list__facts">
                        <div class="admin-list__fact">
                            <span>Subject</span>
                            <strong>{{ \Illuminate\Support\Str::limit($enquiry->subject ?: $enquiry->message, 48) }}</strong>
                        </div>
                        <div class="admin-list__fact">
                            <span>Status</span>
                            <strong><span class="badge">{{ $enquiry->status }}</span></strong>
                        </div>
                    </div>
                </article>
            @empty
                <div class="admin-list__item is-empty">No enquiries yet.</div>
            @endforelse
        </div>
    </div>
</div>

<div class="dash-grid">
    <div class="panel">
        <div class="panel__head">
            <h2>Recent reviews</h2>
            <a class="btn line btn-sm" href="{{ route('admin.reviews.index') }}">Manage reviews</a>
        </div>
        <div class="admin-list">
            @forelse($recentReviews as $review)
                <article class="admin-list__item">
                    <div>
                        <h3 class="admin-list__title">{{ $review->name }}</h3>
                        <p class="admin-list__meta">{{ $review->location ?: '—' }} · {{ $review->rating }}/5 · {{ $review->created_at?->format('d M Y') }}</p>
                        <p class="admin-list__body" style="margin-top:.45rem">{{ \Illuminate\Support\Str::limit($review->message, 100) }}</p>
                    </div>
                    <div class="admin-list__facts">
                        <div class="admin-list__fact">
                            <span>Status</span>
                            <strong><span class="badge">{{ $review->status }}</span></strong>
                        </div>
                    </div>
                </article>
            @empty
                <div class="admin-list__item is-empty">No reviews yet.</div>
            @endforelse
        </div>
    </div>

    <div class="panel">
        <div class="panel__head">
            <h2>Recent activity</h2>
            <a class="btn line btn-sm" href="{{ route('admin.activity.index') }}">Full log</a>
        </div>
        <div class="admin-list">
            @forelse($activity as $log)
                <article class="admin-list__item">
                    <div>
                        <h3 class="admin-list__title">{{ $log->action }}</h3>
                        <p class="admin-list__meta">{{ $log->created_at?->format('d M Y H:i') }} · {{ $log->user?->name ?? 'System' }}</p>
                    </div>
                </article>
            @empty
                <div class="admin-list__item is-empty">No activity yet.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
