@extends('admin.layouts.app')
@section('title', 'Bookings')
@section('content')

@php
    $bookingStatusTones = [
        'new' => 'info',
        'pending' => 'warn',
        'contacted' => 'neutral',
        'confirmed' => 'ok',
        'completed' => 'ok',
        'cancelled' => 'danger',
        'rejected' => 'danger',
    ];
@endphp
<div class="cards cards--stats" aria-label="Filter by status">
    @foreach(\App\Models\Booking::statuses() as $key => $label)
        <a
            class="card card--link card--{{ $bookingStatusTones[$key] ?? 'neutral' }}{{ request('status') === $key ? ' is-active' : '' }}"
            href="{{ route('admin.bookings.index', array_filter(['status' => $key, 'q' => request('q'), 'payment_status' => request('payment_status'), 'from' => request('from'), 'to' => request('to')])) }}#bookings-list"
        >
            <span class="card__label">{{ $label }}</span>
            <strong class="card__value">{{ $statusCounts[$key] ?? 0 }}</strong>
        </a>
    @endforeach
</div>

<form class="toolbar" method="GET" action="{{ route('admin.bookings.index') }}#bookings-list">
    <div><label>Search</label><input name="q" value="{{ request('q') }}" placeholder="Name, phone, reference"></div>
    <div><label>Status</label>
        <select name="status">
            <option value="">All statuses</option>
            @foreach(\App\Models\Booking::statuses() as $key => $label)
                <option value="{{ $key }}" @selected(request('status')===$key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div><label>Payment</label>
        <select name="payment_status">
            <option value="">All payments</option>
            @foreach(\App\Models\Booking::paymentStatuses() as $key => $label)
                <option value="{{ $key }}" @selected(request('payment_status')===$key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div><label>From</label><input type="date" name="from" value="{{ request('from') }}"></div>
    <div><label>To</label><input type="date" name="to" value="{{ request('to') }}"></div>
    <button class="btn" type="submit">Filter</button>
    <a class="btn line" href="{{ route('admin.bookings.index') }}#bookings-list">Reset</a>
    <a class="btn secondary" href="{{ route('admin.bookings.export', request()->query()) }}">Export CSV</a>
</form>

<div class="panel" id="bookings-list">
    <div class="panel__head">
        <h2>
            @if(request('status') && isset(\App\Models\Booking::statuses()[request('status')]))
                {{ \App\Models\Booking::statuses()[request('status')] }}
            @else
                All bookings
            @endif
        </h2>
        <span class="muted">{{ $bookings->total() }} result{{ $bookings->total() === 1 ? '' : 's' }}</span>
    </div>

    <div class="admin-list admin-list--bookings">
        @forelse($bookings as $b)
            <article class="booking-card">
                <header class="booking-card__head">
                    <div>
                        <a class="booking-card__ref" href="{{ route('admin.bookings.show', $b) }}">{{ $b->booking_reference }}</a>
                        <p class="booking-card__when">{{ $b->created_at?->format('d M Y, h:i A') }}</p>
                    </div>
                    <div class="booking-card__badges">
                        <span class="badge badge-{{ $b->status }}">{{ $b->statusLabel() }}</span>
                        <span class="badge badge-pay-{{ $b->payment_status }}">{{ $b->paymentStatusLabel() }}</span>
                    </div>
                </header>

                <div class="booking-card__guest">
                    <strong>{{ $b->name }}</strong>
                    <span>{{ $b->phone }}</span>
                    @if($b->email)<span>{{ $b->email }}</span>@endif
                </div>

                <div class="booking-card__grid">
                    <div>
                        <span>Stay / Event</span>
                        <strong>{{ $b->booking_type }}</strong>
                        <small>{{ $b->guest_count ?: ($b->adults + $b->children) }} guests</small>
                    </div>
                    <div>
                        <span>Dates</span>
                        <strong>{{ optional($b->check_in)->format('d M Y') ?: '—' }}</strong>
                        @if($b->check_out)
                            <small>to {{ $b->check_out->format('d M Y') }}</small>
                        @endif
                    </div>
                    @if($b->amount_total)
                        <div>
                            <span>Amount</span>
                            <strong>₹{{ number_format((float) $b->amount_total, 0) }}</strong>
                        </div>
                    @endif
                </div>

                <a class="btn booking-card__btn" href="{{ route('admin.bookings.show', $b) }}">Manage booking</a>
            </article>
        @empty
            <div class="admin-list__item is-empty">No bookings found.</div>
        @endforelse
    </div>

    {{ $bookings->links() }}
</div>
@endsection
