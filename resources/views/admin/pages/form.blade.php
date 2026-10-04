@extends('admin.layouts.app')
@section('title', $page->exists ? 'Edit page' : 'Create page')
@section('content')
<form method="POST" action="{{ $page->exists ? route('admin.pages.update', $page) : route('admin.pages.store') }}" class="panel">
    @csrf
    @if($page->exists) @method('PUT') @endif
    <div class="form-grid">
        <div><label>Title</label><input name="title" value="{{ old('title', $page->title) }}" required></div>
        <div><label>Slug</label><input name="slug" value="{{ old('slug', $page->slug) }}"></div>
        <div>
            <label>Status</label>
            <select name="status">
                @foreach(['published','draft'] as $s)
                    <option value="{{ $s }}" @selected(old('status', $page->status ?: 'draft') === $s)>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        <div><label>Template</label><input name="template" value="{{ old('template', $page->template) }}" placeholder="home, stay, booking…"></div>
        <div class="full"><label>Meta title</label><input name="meta_title" value="{{ old('meta_title', $page->meta_title) }}"></div>
        <div class="full"><label>Meta description</label><textarea name="meta_description">{{ old('meta_description', $page->meta_description) }}</textarea></div>
        <div><label>Canonical URL</label><input name="canonical_url" value="{{ old('canonical_url', $page->canonical_url) }}"></div>
        <div><label>Robots</label><input name="robots" value="{{ old('robots', $page->robots ?: 'index, follow') }}"></div>
        <div><label>OG title</label><input name="og_title" value="{{ old('og_title', $page->og_title) }}"></div>
        <div><label>OG image path</label><input name="og_image" value="{{ old('og_image', $page->og_image) }}"></div>
        <div class="full"><label>OG description</label><textarea name="og_description">{{ old('og_description', $page->og_description) }}</textarea></div>
        <div><label>Twitter title</label><input name="twitter_title" value="{{ old('twitter_title', $page->twitter_title) }}"></div>
        <div><label>Twitter image</label><input name="twitter_image" value="{{ old('twitter_image', $page->twitter_image) }}"></div>
        <div class="full"><label>Twitter description</label><textarea name="twitter_description">{{ old('twitter_description', $page->twitter_description) }}</textarea></div>
    </div>
    <div class="form-actions form-actions--sticky">
        <button class="btn" type="submit">Save page</button>
    </div>
</form>

@if($page->exists)
<div class="panel">
    <h2>Content blocks</h2>
    <p style="color:#5c6b62">Active blocks appear after the page template. Add a text block to publish editable content on this page.</p>
    <form method="POST" action="{{ route('admin.pages.blocks.store', $page) }}" class="toolbar">
        @csrf
        <div><label>Type</label>
            <select name="block_type">
                @foreach(['hero','text','image_text','gallery','features','amenities','cta','testimonials','faq','attractions','rooms','events','stats','contact','map','video','html'] as $t)
                    <option value="{{ $t }}">{{ $t }}</option>
                @endforeach
            </select>
        </div>
        <div><label>Title</label><input name="title"></div>
        <div><label>Subtitle</label><input name="subtitle"></div>
        <div class="full"><label>Content</label><textarea name="content"></textarea></div>
        <div><label>Status</label><select name="status"><option value="active">active</option><option value="inactive">inactive</option></select></div>
        <button class="btn" type="submit">Add block</button>
    </form>

    @foreach($page->blocks as $block)
        <div class="panel" style="background:#faf8f4">
            <form method="POST" action="{{ route('admin.blocks.update', $block) }}">
                @csrf @method('PUT')
                <div class="form-grid">
                    <div><label>Block #{{ $block->id }} ({{ $block->block_type }})</label><input name="title" value="{{ $block->title }}"></div>
                    <div><label>Subtitle</label><input name="subtitle" value="{{ $block->subtitle }}"></div>
                    <div class="full"><label>Content</label><textarea name="content">{{ $block->content }}</textarea></div>
                    <div><label>Sort</label><input type="number" name="sort_order" value="{{ $block->sort_order }}"></div>
                    <div><label>Status</label><select name="status"><option value="active" @selected($block->status==='active')>active</option><option value="inactive" @selected($block->status==='inactive')>inactive</option></select></div>
                </div>
                <p style="margin-top:.7rem">
                    <button class="btn" type="submit">Update block</button>
                </p>
            </form>
            <form method="POST" action="{{ route('admin.blocks.destroy', $block) }}" onsubmit="return confirm('Delete block?')">
                @csrf @method('DELETE')
                <button class="btn danger" type="submit">Delete block</button>
            </form>

            <h3>Items</h3>
            @foreach($block->items as $item)
                <form method="POST" action="{{ route('admin.block-items.update', $item) }}" class="panel">
                    @csrf @method('PUT')
                    <div class="form-grid">
                        <div><label>Title</label><input name="title" value="{{ $item->title }}"></div>
                        <div><label>Subtitle</label><input name="subtitle" value="{{ $item->subtitle }}"></div>
                        <div class="full"><label>Description</label><textarea name="description">{{ $item->description }}</textarea></div>
                        <div><label>Image path</label><input name="image" value="{{ $item->image }}"></div>
                        <div><label>Link</label><input name="link" value="{{ $item->link }}"></div>
                        <div><label>Button label</label><input name="button_label" value="{{ $item->button_label }}"></div>
                        <div><label>Button URL</label><input name="button_url" value="{{ $item->button_url }}"></div>
                        <div><label>Sort</label><input type="number" name="sort_order" value="{{ $item->sort_order }}"></div>
                        <div><label>Status</label><select name="status"><option value="active" @selected($item->status==='active')>active</option><option value="inactive" @selected($item->status==='inactive')>inactive</option></select></div>
                    </div>
                    <p><button class="btn" type="submit">Save item</button></p>
                </form>
                <div class="row-actions" style="margin:.5rem 0 1rem">
                    <form method="POST" action="{{ route('admin.block-items.duplicate', $item) }}">@csrf<button class="btn line btn-sm" type="submit">Duplicate</button></form>
                    <form method="POST" action="{{ route('admin.block-items.destroy', $item) }}" onsubmit="return confirm('Delete item?')">@csrf @method('DELETE')<button class="btn danger btn-sm" type="submit">Delete</button></form>
                </div>
            @endforeach

            <form method="POST" action="{{ route('admin.block-items.store', $block) }}" class="toolbar">
                @csrf
                <div><label>New item title</label><input name="title" required></div>
                <div><label>Image</label><input name="image" placeholder="assets/images/..."></div>
                <input type="hidden" name="status" value="active">
                <button class="btn secondary" type="submit">Add item</button>
            </form>
        </div>
    @endforeach
</div>

<form method="POST" action="{{ route('admin.pages.destroy', $page) }}" onsubmit="return confirm('Delete this page?')" class="panel">
    @csrf @method('DELETE')
    <button class="btn danger" type="submit">Delete page</button>
</form>
@endif
@endsection
