@extends('admin.layouts.app')
@section('title', 'My account')
@section('subtitle', 'Update your login email and password')
@section('content')

<form method="POST" action="{{ route('admin.profile.update') }}" class="panel form-grid">
    @csrf
    @method('PUT')

    <div>
        <label for="name">Name</label>
        <input id="name" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name">
    </div>

    <div>
        <label for="email">Email (login)</label>
        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
    </div>

    <div class="full">
        <label for="current_password">Current password</label>
        <input id="current_password" type="password" name="current_password" required autocomplete="current-password">
        <p class="muted" style="margin:.35rem 0 0;font-size:.85rem">Required to save any changes.</p>
    </div>

    <div>
        <label for="password">New password</label>
        <input id="password" type="password" name="password" autocomplete="new-password" placeholder="Leave blank to keep current">
    </div>

    <div>
        <label for="password_confirmation">Confirm new password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password">
    </div>

    <div class="full form-actions">
        <button class="btn" type="submit">Save account</button>
        <a class="btn line" href="{{ route('admin.dashboard') }}">Cancel</a>
    </div>
</form>

@endsection
