@extends('admin.layout')
@section('title', 'Redirects')
@section('content')
<h1>SEO Redirects</h1>
<form method="post" action="{{ route('admin.redirects.store') }}">
    @csrf
    <p><input name="old_url" placeholder="Old URL" required> <input name="new_url" placeholder="New URL" required>
    <select name="type"><option value="301">301</option><option value="302">302</option></select>
    <button class="btn" type="submit">Add</button></p>
</form>
<table>
    <thead><tr><th>From</th><th>To</th><th>Type</th><th>Active</th><th></th></tr></thead>
    <tbody>
    @foreach($redirects as $redirect)
        <tr>
            <td>{{ $redirect->old_url }}</td>
            <td>{{ $redirect->new_url }}</td>
            <td>{{ $redirect->type }}</td>
            <td>{{ $redirect->is_active ? 'Yes' : 'No' }}</td>
            <td>
                <form method="post" action="{{ route('admin.redirects.destroy', $redirect) }}">@csrf @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $redirects->links() }}
@endsection
