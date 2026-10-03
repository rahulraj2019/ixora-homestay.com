<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function __construct(protected MailNotificationService $mail) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Booking
    {
        $booking = DB::transaction(function () use ($data) {
            $reference = $this->generateReference();

            return Booking::query()->create(array_merge($data, [
                'booking_reference' => $reference,
                'status' => $data['status'] ?? 'new',
            ]));
        });

        $this->mail->sendBookingNotifications($booking);

        return $booking;
    }

    protected function generateReference(): string
    {
        $year = now()->format('Y');
        $prefix = "IXR-{$year}-";

        $latest = Booking::query()
            ->withTrashed()
            ->where('booking_reference', 'like', $prefix.'%')
            ->lockForUpdate()
            ->orderByDesc('booking_reference')
            ->value('booking_reference');

        $next = 1;

        if ($latest && preg_match('/(\d+)$/', $latest, $matches)) {
            $next = (int) $matches[1] + 1;
        }

        return $prefix.str_pad((string) $next, 5, '0', STR_PAD_LEFT);
    }
}
