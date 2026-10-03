@extends('admin.layouts.app')
@section('title', 'SEO Redirects')
@section('content')
<form method="POST" action="{{ route('admin.seo.redirects.store') }}" class="panel form-grid">
    @csrf
    <div><label>Old URL</label><input name="old_url" placeholder="/old-page" required></div>
    <div><label>New URL</label><input name="new_url" placeholder="/new-page" required></div>
    <div>
        <label>Type</label>
        <select name="type">
            <option value="301">301</option>
            <option value="302">302</option>
        </select>
    </div>
    <div>
        <label class="chip" style="margin-top:1.55rem">
            <input type="checkbox" name="is_active" value="1" checked> Active
        </label>
    </div>
    <div class="full form-actions">
        <button class="btn" type="submit">Add redirect</button>
    </div>
</form>
<div class="panel">
    <div class="admin-list">
        @forelse($redirects as $r)
            <article class="admin-list__item">
                <div>
                    <h3 class="admin-list__title">{{ $r->old_url }}</h3>
                    <p class="admin-list__meta">→ {{ $r->new_url }}</p>
                </div>
                <div class="admin-list__facts">
                    <div class="admin-list__fact">
                        <span>Type</span>
                        <strong>{{ $r->type }}</strong>
                    </div>
                    <div class="admin-list__fact">
                        <span>Active</span>
                        <strong>{{ $r->is_active ? 'Yes' : 'No' }}</strong>
                    </div>
                </div>
                <div class="admin-list__actions">
                    <form method="POST" action="{{ route('admin.seo.redirects.destroy', $r) }}" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="btn danger" type="submit">Delete</button>
                    </form>
                </div>
            </article>
        @empty
            <div class="admin-list__item is-empty">No redirects yet.</div>
        @endforelse
    </div>
    {{ $redirects->links() }}
</div>
@endsection
