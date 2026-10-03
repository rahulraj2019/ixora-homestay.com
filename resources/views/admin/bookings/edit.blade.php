@extends('admin.layouts.app')
@section('title', 'Edit booking '.$booking->booking_reference)
@section('content')
<form method="POST" action="{{ route('admin.bookings.update', $booking) }}" class="panel">
    @csrf @method('PUT')
    <h3>Guest & contact</h3>
    <div class="form-grid">
        <div><label>Name</label><input name="name" value="{{ old('name', $booking->name) }}" required></div>
        <div><label>Email</label><input name="email" type="email" value="{{ old('email', $booking->email) }}"></div>
        <div><label>Phone</label><input name="phone" value="{{ old('phone', $booking->phone) }}" required></div>
        <div><label>WhatsApp</label><input name="whatsapp" value="{{ old('whatsapp', $booking->whatsapp) }}"></div>
    </div>

    <h3 style="margin-top:1.2rem">Stay details</h3>
    <div class="form-grid">
        <div><label>Booking type</label><input name="booking_type" value="{{ old('booking_type', $booking->booking_type) }}" required></div>
        <div>
            <label>Status</label>
            <select name="status">
                @foreach(\App\Models\Booking::statuses() as $key => $label)
                    <option value="{{ $key }}" @selected(old('status', $booking->status)===$key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div><label>Check-in</label><input type="date" name="check_in" value="{{ old('check_in', optional($booking->check_in)->format('Y-m-d')) }}"></div>
        <div><label>Check-out</label><input type="date" name="check_out" value="{{ old('check_out', optional($booking->check_out)->format('Y-m-d')) }}"></div>
        <div><label>Adults</label><input type="number" name="adults" min="1" value="{{ old('adults', $booking->adults) }}"></div>
        <div><label>Children (under 10)</label><input type="number" name="children" min="0" value="{{ old('children', $booking->children) }}"></div>
        <div><label>Rooms</label><input type="number" name="rooms" min="1" value="{{ old('rooms', $booking->rooms) }}"></div>
        <div><label>Guest count</label><input type="number" name="guest_count" min="1" value="{{ old('guest_count', $booking->guest_count) }}"></div>
        <div class="full"><label>Guest message</label><textarea name="message">{{ old('message', $booking->message) }}</textarea></div>
        <div class="full"><label>Admin notes</label><textarea name="admin_notes">{{ old('admin_notes', $booking->admin_notes) }}</textarea></div>
    </div>

    <h3 style="margin-top:1.2rem">Payment</h3>
    <div class="form-grid">
        <div>
            <label>Payment status</label>
            <select name="payment_status">
                @foreach(\App\Models\Booking::paymentStatuses() as $key => $label)
                    <option value="{{ $key }}" @selected(old('payment_status', $booking->payment_status ?: 'unpaid')===$key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Payment method</label>
            <select name="payment_method">
                @foreach(['' => 'Select', 'upi' => 'UPI', 'bank_transfer' => 'Bank transfer', 'cash' => 'Cash', 'card' => 'Card', 'other' => 'Other'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('payment_method', $booking->payment_method)===$value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div><label>Total amount (₹)</label><input type="number" step="0.01" min="0" name="amount_total" value="{{ old('amount_total', $booking->amount_total) }}"></div>
        <div><label>Amount paid (₹)</label><input type="number" step="0.01" min="0" name="amount_paid" value="{{ old('amount_paid', $booking->amount_paid) }}"></div>
        <div class="full"><label>Payment notes</label><textarea name="payment_notes">{{ old('payment_notes', $booking->payment_notes) }}</textarea></div>
    </div>

    <div class="form-actions form-actions--sticky">
        <button class="btn" type="submit">Save all changes</button>
        <a class="btn line" href="{{ route('admin.bookings.show', $booking) }}">Cancel</a>
    </div>
</form>
@endsection
