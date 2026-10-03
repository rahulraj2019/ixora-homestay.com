@extends('admin.layouts.app')
@section('title', 'Booking '.$booking->booking_reference)
@section('content')

<div class="booking-hero panel">
    <div>
        <p class="muted" style="margin:0">Booking reference</p>
        <h2 style="margin:.2rem 0 .6rem">{{ $booking->booking_reference }}</h2>
        <div style="display:flex;gap:.5rem;flex-wrap:wrap">
            <span class="badge badge-{{ $booking->status }}">{{ $booking->statusLabel() }}</span>
            <span class="badge badge-pay-{{ $booking->payment_status }}">{{ $booking->paymentStatusLabel() }}</span>
            <span class="badge">{{ $booking->booking_type }}</span>
        </div>
    </div>
    <div class="booking-actions">
        <a class="btn line" href="{{ route('admin.bookings.index') }}">← All bookings</a>
        <a class="btn secondary" href="{{ route('admin.bookings.edit', $booking) }}">Full edit</a>
        <button class="btn" type="button" onclick="window.print()">Print</button>
        @if($booking->whatsapp || $booking->phone)
            <a class="btn" target="_blank" rel="noopener"
               href="https://wa.me/{{ preg_replace('/\D+/', '', $booking->whatsapp ?: $booking->phone) }}?text={{ rawurlencode('Hello '.$booking->name.', regarding your IXORA booking '.$booking->booking_reference) }}">
                WhatsApp guest
            </a>
        @endif
    </div>
</div>

<div class="booking-grid">
    <div class="panel">
        <h3>Guest details</h3>
        <dl class="detail-list">
            <div><dt>Name</dt><dd>{{ $booking->name }}</dd></div>
            <div><dt>Phone</dt><dd><a href="tel:{{ preg_replace('/\s+/', '', $booking->phone) }}">{{ $booking->phone }}</a></dd></div>
            <div><dt>WhatsApp</dt><dd>{{ $booking->whatsapp ?: '—' }}</dd></div>
            <div><dt>Email</dt><dd>{{ $booking->email ? $booking->email : '—' }}</dd></div>
            <div><dt>Source</dt><dd>{{ $booking->source ?: 'website' }}</dd></div>
            <div><dt>Submitted</dt><dd>{{ $booking->created_at?->format('d M Y, h:i A') }}</dd></div>
        </dl>
    </div>

    <div class="panel">
        <h3>Stay / event</h3>
        <dl class="detail-list">
            <div><dt>Type</dt><dd>{{ $booking->booking_type }}</dd></div>
            <div><dt>Check-in</dt><dd>{{ optional($booking->check_in)->format('d M Y') ?: '—' }}</dd></div>
            <div><dt>Check-out</dt><dd>{{ optional($booking->check_out)->format('d M Y') ?: '—' }}</dd></div>
            <div><dt>Guests</dt><dd>{{ $booking->guest_count ?: ($booking->adults + $booking->children) }} ({{ $booking->adults }} adults, {{ $booking->children }} children — under 10 = children)</dd></div>
            <div><dt>Rooms</dt><dd>{{ $booking->rooms }}</dd></div>
            <div><dt>Confirmed at</dt><dd>{{ optional($booking->confirmed_at)->format('d M Y, h:i A') ?: 'Not confirmed yet' }}</dd></div>
        </dl>
        <p style="margin-top:1rem"><strong>Guest message</strong></p>
        <p class="note-box">{{ $booking->message ?: 'No message provided.' }}</p>
    </div>
</div>

<div class="booking-grid">
    <form method="POST" action="{{ route('admin.bookings.quick', $booking) }}" class="panel">
        @csrf
        @method('PATCH')
        <h3>Update status</h3>
        <p class="muted">Change booking progress in one click, then save.</p>
        <div class="chip-row">
            @foreach(\App\Models\Booking::statuses() as $key => $label)
                <label class="chip {{ $booking->status === $key ? 'on' : '' }}">
                    <input type="radio" name="status" value="{{ $key }}" @checked($booking->status === $key)>
                    {{ $label }}
                </label>
            @endforeach
        </div>
        <div class="field" style="margin-top:1rem">
            <label>Internal admin notes</label>
            <textarea name="admin_notes" rows="4" placeholder="Call notes, follow-up reminders, special arrangements…">{{ old('admin_notes', $booking->admin_notes) }}</textarea>
        </div>
        <div class="form-actions">
            <button class="btn" type="submit">Save status & notes</button>
        </div>
    </form>

    <form method="POST" action="{{ route('admin.bookings.quick', $booking) }}" class="panel">
        @csrf
        @method('PATCH')
        <h3>Payment</h3>
        <div class="chip-row">
            @foreach(\App\Models\Booking::paymentStatuses() as $key => $label)
                <label class="chip {{ ($booking->payment_status ?: 'unpaid') === $key ? 'on' : '' }}">
                    <input type="radio" name="payment_status" value="{{ $key }}" @checked(($booking->payment_status ?: 'unpaid') === $key)>
                    {{ $label }}
                </label>
            @endforeach
        </div>
        <div class="form-grid" style="margin-top:1rem">
            <div>
                <label>Total amount (₹)</label>
                <input type="number" step="0.01" min="0" name="amount_total" value="{{ old('amount_total', $booking->amount_total) }}" placeholder="0.00">
            </div>
            <div>
                <label>Amount paid (₹)</label>
                <input type="number" step="0.01" min="0" name="amount_paid" value="{{ old('amount_paid', $booking->amount_paid) }}" placeholder="0.00">
            </div>
            <div>
                <label>Payment method</label>
                <select name="payment_method">
                    @php $methods = ['' => 'Select', 'upi' => 'UPI', 'bank_transfer' => 'Bank transfer', 'cash' => 'Cash', 'card' => 'Card', 'other' => 'Other']; @endphp
                    @foreach($methods as $value => $label)
                        <option value="{{ $value }}" @selected(old('payment_method', $booking->payment_method) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Balance due</label>
                <input type="text" readonly value="{{ $booking->balanceDue() === null ? '—' : '₹'.number_format($booking->balanceDue(), 2) }}">
            </div>
            <div class="full">
                <label>Payment notes</label>
                <textarea name="payment_notes" rows="3" placeholder="Advance received, UPI ref, refund details…">{{ old('payment_notes', $booking->payment_notes) }}</textarea>
            </div>
        </div>
        <div class="form-actions">
            <button class="btn" type="submit">Save payment</button>
        </div>
    </form>
</div>

<form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}" class="panel" onsubmit="return confirm('Archive this booking? It can be restored from soft deletes if needed.')">
    @csrf
    @method('DELETE')
    <button class="btn danger" type="submit">Archive booking</button>
</form>
@endsection
