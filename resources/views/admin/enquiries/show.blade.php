@extends('admin.layouts.app')
@section('title', 'Enquiry')
@section('content')
<div class="toolbar">
    <a class="btn line" href="{{ route('admin.enquiries.index') }}">← All enquiries</a>
</div>

<div class="panel">
    <h2>{{ $enquiry->name }}</h2>
    <dl class="detail-list">
        <div><dt>Email</dt><dd><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></dd></div>
        <div><dt>Phone</dt><dd>{{ $enquiry->phone ? $enquiry->phone : '—' }}</dd></div>
        <div><dt>Subject</dt><dd>{{ $enquiry->subject ?: '—' }}</dd></div>
        <div><dt>Status</dt><dd><span class="badge">{{ $enquiry->status }}</span></dd></div>
    </dl>
    <p style="margin-top:1rem"><strong>Message</strong></p>
    <p class="note-box">{{ $enquiry->message }}</p>
</div>

<form method="POST" action="{{ route('admin.enquiries.update', $enquiry) }}" class="panel form-grid">
    @csrf @method('PUT')
    <div>
        <label>Status</label>
        <select name="status">
            @foreach(['new','pending','contacted','closed'] as $s)
                <option value="{{ $s }}" @selected($enquiry->status===$s)>{{ $s }}</option>
            @endforeach
        </select>
    </div>
    <div class="full">
        <label>Admin notes</label>
        <textarea name="admin_notes" rows="5">{{ $enquiry->admin_notes }}</textarea>
    </div>
    <div class="full form-actions">
        <button class="btn" type="submit">Save enquiry</button>
    </div>
</form>
@endsection
