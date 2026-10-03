@extends('admin.layout')
@section('title', 'Edit page')
@section('content')
<h1>Edit: {{ $page->title }}</h1>
<form method="post" action="{{ route('admin.pages.update', $page) }}">
    @csrf @method('PUT')
    <p><label>Title <input name="title" value="{{ old('title', $page->title) }}" required></label></p>
    <p><label>Slug <input name="slug" value="{{ old('slug', $page->slug) }}"></label></p>
    <p><label>Status
        <select name="status">
            <option value="draft" @selected($page->status==='draft')>Draft</option>
            <option value="published" @selected($page->status==='published')>Published</option>
        </select>
    </label></p>
    <p><label>Template <input name="template" value="{{ old('template', $page->template) }}"></label></p>
    <p><label>Meta title <input name="meta_title" value="{{ old('meta_title', $page->meta_title) }}"></label></p>
    <p><label>Meta description <textarea name="meta_description">{{ old('meta_description', $page->meta_description) }}</textarea></label></p>
    <p><label>Sort order <input type="number" name="sort_order" value="{{ old('sort_order', $page->sort_order) }}"></label></p>
    <button class="btn" type="submit">Update</button>
</form>
<form method="post" action="{{ route('admin.pages.destroy', $page) }}" onsubmit="return confirm('Delete?')" style="margin-top:1rem">
    @csrf @method('DELETE')
    <button type="submit">Delete page</button>
</form>
@endsection
