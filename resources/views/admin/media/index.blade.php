@extends('admin.layouts.app')
@section('title', 'Media Library')
@section('content')
<p class="section-note">Uploaded files are stored for reuse. Assign them to page placements under <a href="{{ route('admin.site-images.index') }}">Site Images</a>.</p>

<form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" class="panel">
    @csrf
    <div class="form-grid">
        <div class="full"><label>Upload images</label><input type="file" name="files[]" multiple accept="image/*" required></div>
        <div><label>Alt text</label><input name="alt"></div>
        <div><label>Title</label><input name="title"></div>
    </div>
    <div class="form-actions">
        <button class="btn" type="submit">Upload</button>
    </div>
</form>

<form method="GET" class="toolbar">
    <div><label>Search</label><input name="q" value="{{ request('q') }}" placeholder="Filename, alt, title"></div>
    <button class="btn" type="submit">Search</button>
</form>

<div class="media-grid">
@forelse($media as $item)
    <figure>
        <img src="{{ $item->url() }}" alt="{{ $item->alt }}">
        <figcaption>
            <strong style="display:block;overflow-wrap:anywhere">{{ $item->filename }}</strong>
            <small>{{ $item->width }}×{{ $item->height }} · {{ number_format($item->size/1024,1) }} KB</small>
            <form method="POST" action="{{ route('admin.media.update', $item) }}" class="media-card-actions">
                @csrf @method('PUT')
                <input name="alt" value="{{ $item->alt }}" placeholder="Alt">
                <input name="title" value="{{ $item->title }}" placeholder="Title">
                <button class="btn line" type="submit">Save</button>
            </form>
            <form method="POST" action="{{ route('admin.media.destroy', $item) }}" class="media-card-actions" onsubmit="return confirm('Soft-delete this media record?')">
                @csrf @method('DELETE')
                <button class="btn danger" type="submit">Delete</button>
            </form>
            <small style="display:block;margin-top:.35rem;overflow-wrap:anywhere">{{ $item->path }}</small>
        </figcaption>
    </figure>
@empty
    <div class="admin-list__item is-empty" style="grid-column:1/-1">No media uploaded yet.</div>
@endforelse
</div>
{{ $media->links() }}
@endsection
