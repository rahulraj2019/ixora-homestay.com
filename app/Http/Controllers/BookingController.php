<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;

class BookingController extends Controller
{
    public function store(StoreBookingRequest $request, BookingService $bookings): RedirectResponse
    {
        $data = $request->validated();
        $adults = max(1, (int) ($data['adults'] ?? 1));
        $children = max(0, (int) ($data['children'] ?? 0));
        $guestCount = $adults + $children;

        $booking = $bookings->create([
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'],
            'whatsapp' => $data['whatsapp'] ?? $data['phone'],
            'booking_type' => $data['booking_type'],
            'check_in' => $data['check_in'] ?? null,
            'check_out' => $data['check_out'] ?? null,
            'adults' => $adults,
            'children' => $children,
            'rooms' => $data['rooms'] ?? 1,
            'event_type' => $data['event_type'] ?? null,
            'guest_count' => $guestCount,
            'message' => $data['message'] ?? null,
            'status' => 'new',
            'payment_status' => 'unpaid',
            'source' => 'website',
            'ip_address' => $request->ip(),
        ]);

        return redirect()
            ->to(route('page.show', 'booking').'#booking-success')
            ->with('success', 'We received your request and will confirm availability shortly.')
            ->with('booking_reference', $booking->booking_reference);
    }
}
