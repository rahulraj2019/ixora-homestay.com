@extends('admin.layouts.app')
@section('title', $faq->exists ? 'Edit FAQ' : 'Add FAQ')
@section('content')
<form method="POST" action="{{ $faq->exists ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}" class="panel form-grid">
    @csrf
    @if($faq->exists) @method('PUT') @endif
    <div class="full">
        <label>Question</label>
        <input name="question" value="{{ old('question', $faq->question) }}" required maxlength="255">
    </div>
    <div class="full">
        <label>Answer</label>
        <textarea name="answer" rows="8" required>{{ old('answer', $faq->answer) }}</textarea>
        <small style="color:#5c6b62">HTML allowed (e.g. &lt;strong&gt;, &lt;a href=""&gt;).</small>
    </div>
    <div>
        <label>Sort order</label>
        <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $faq->sort_order ?? 0) }}">
    </div>
    <div>
        <label>Status</label>
        <select name="status">
            @foreach(['active', 'inactive'] as $status)
                <option value="{{ $status }}" @selected(old('status', $faq->status ?: 'active') === $status)>{{ $status }}</option>
            @endforeach
        </select>
    </div>
    <div class="full">
        <small style="color:#5c6b62">Home page FAQ block lists the first <strong>8 active</strong> FAQs by sort order (lowest first). The full FAQ page shows all active items.</small>
    </div>
    <div class="full form-actions form-actions--sticky">
        <button class="btn" type="submit">{{ $faq->exists ? 'Update FAQ' : 'Create FAQ' }}</button>
        <a class="btn line" href="{{ route('admin.faqs.index') }}">Cancel</a>
    </div>
</form>
@endsection
