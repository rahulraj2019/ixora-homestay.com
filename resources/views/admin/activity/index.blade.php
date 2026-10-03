@extends('admin.layouts.app')
@section('title', 'Activity log')
@section('content')
<div class="panel">
    <div class="admin-list">
        @forelse($logs as $log)
            <article class="admin-list__item">
                <div>
                    <h3 class="admin-list__title">{{ $log->action }}</h3>
                    <p class="admin-list__meta">{{ $log->created_at }}</p>
                </div>
                <div class="admin-list__facts">
                    <div class="admin-list__fact">
                        <span>User</span>
                        <strong>{{ $log->user?->name ?? '—' }}</strong>
                    </div>
                    <div class="admin-list__fact">
                        <span>IP</span>
                        <strong>{{ $log->ip_address ?: '—' }}</strong>
                    </div>
                </div>
            </article>
        @empty
            <div class="admin-list__item is-empty">No activity yet.</div>
        @endforelse
    </div>
    {{ $logs->links() }}
</div>
@endsection
