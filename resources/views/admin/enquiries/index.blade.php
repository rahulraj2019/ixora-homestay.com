@extends('admin.layouts.app')
@section('title', 'Enquiries')
@section('content')

@php
    $enquiryStatusTones = [
        'new' => 'info',
        'pending' => 'warn',
        'contacted' => 'neutral',
        'closed' => 'ok',
    ];
@endphp
<div class="cards cards--stats" aria-label="Filter by status">
    <a class="card card--link card--neutral{{ ($status ?? '') === '' ? ' is-active' : '' }}" href="{{ route('admin.enquiries.index') }}#enquiries-list">
        <span class="card__label">All</span>
        <strong class="card__value">{{ $statusCounts['all'] ?? 0 }}</strong>
    </a>
    @foreach($statuses as $key => $label)
        <a
            class="card card--link card--{{ $enquiryStatusTones[$key] ?? 'neutral' }}{{ ($status ?? '') === $key ? ' is-active' : '' }}"
            href="{{ route('admin.enquiries.index', ['status' => $key]) }}#enquiries-list"
        >
            <span class="card__label">{{ $label }}</span>
            <strong class="card__value">{{ $statusCounts[$key] ?? 0 }}</strong>
        </a>
    @endforeach
</div>

<div class="panel" id="enquiries-list">
    <div class="panel__head">
        <h2>
            @if(($status ?? '') !== '' && isset($statuses[$status]))
                {{ $statuses[$status] }}
            @else
                All enquiries
            @endif
        </h2>
        <span class="muted">{{ $enquiries->total() }} result{{ $enquiries->total() === 1 ? '' : 's' }}</span>
    </div>
    <div class="admin-list">
        @forelse($enquiries as $e)
            <article class="admin-list__item">
                <div>
                    <h3 class="admin-list__title">{{ $e->name }}</h3>
                    <p class="admin-list__meta">{{ $e->email }}@if($e->phone) · {{ $e->phone }}@endif</p>
                </div>
                <div class="admin-list__facts">
                    <div class="admin-list__fact">
                        <span>Subject</span>
                        <strong>{{ $e->subject ?: '—' }}</strong>
                    </div>
                    <div class="admin-list__fact">
                        <span>Status</span>
                        <strong><span class="badge">{{ $e->status }}</span></strong>
                    </div>
                </div>
                <div class="admin-list__actions">
                    <a class="btn" href="{{ route('admin.enquiries.show', $e) }}">Open</a>
                </div>
            </article>
        @empty
            <div class="admin-list__item is-empty">No enquiries found.</div>
        @endforelse
    </div>
    {{ $enquiries->links() }}
</div>
@endsection
