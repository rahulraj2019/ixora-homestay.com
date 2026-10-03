@extends('admin.layout')
@section('title', 'Create page')
@section('content')
<h1>Create page</h1>
<form method="post" action="{{ route('admin.pages.store') }}">
    @csrf
    <p><label>Title <input name="title" value="{{ old('title') }}" required></label></p>
    <p><label>Slug <input name="slug" value="{{ old('slug') }}"></label></p>
    <p><label>Status
        <select name="status">
            <option value="draft">Draft</option>
            <option value="published">Published</option>
        </select>
    </label></p>
    <p><label>Template <input name="template" value="{{ old('template') }}"></label></p>
    <button class="btn" type="submit">Save</button>
</form>
@endsection
