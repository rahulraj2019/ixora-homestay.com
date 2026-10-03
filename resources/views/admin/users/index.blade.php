@extends('admin.layouts.app')
@section('title', 'Users')
@section('content')
<form method="POST" action="{{ route('admin.users.store') }}" class="panel form-grid">
    @csrf
    <div><label>Name</label><input name="name" required autocomplete="name"></div>
    <div><label>Email</label><input type="email" name="email" required autocomplete="email"></div>
    <div><label>Password</label><input type="password" name="password" required autocomplete="new-password"></div>
    <div>
        <label>Role</label>
        <select name="role">
            <option value="admin">admin</option>
            <option value="super_admin">super_admin</option>
        </select>
    </div>
    <div class="full form-actions">
        <button class="btn" type="submit">Create user</button>
    </div>
</form>
<div class="panel">
    <div class="admin-list">
        @forelse($users as $user)
            <article class="admin-list__item">
                <div>
                    <h3 class="admin-list__title">{{ $user->name }}</h3>
                    <p class="admin-list__meta">{{ $user->email }}</p>
                </div>
                <div class="admin-list__facts">
                    <div class="admin-list__fact">
                        <span>Role</span>
                        <strong><span class="badge">{{ $user->role }}</span></strong>
                    </div>
                </div>
                <div class="admin-list__actions">
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete user?')">
                        @csrf @method('DELETE')
                        <button class="btn danger" type="submit">Delete</button>
                    </form>
                </div>
            </article>
        @empty
            <div class="admin-list__item is-empty">No users found.</div>
        @endforelse
    </div>
    {{ $users->links() }}
</div>
@endsection
