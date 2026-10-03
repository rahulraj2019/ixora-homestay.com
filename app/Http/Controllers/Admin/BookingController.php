<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookingController extends Controller
{
    public function index(Request $request): View
    {
        $query = Booking::query()->latest();

        if ($search = $request->string('q')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('booking_reference', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        if ($payment = $request->string('payment_status')->toString()) {
            $query->where('payment_status', $payment);
        }

        if ($type = $request->string('booking_type')->toString()) {
            $query->where('booking_type', $type);
        }

        if ($from = $request->string('from')->toString()) {
            $query->whereDate('check_in', '>=', $from);
        }

        if ($to = $request->string('to')->toString()) {
            $query->whereDate('check_in', '<=', $to);
        }

        $bookings = $query->paginate(20)->withQueryString();
        $statusCounts = Booking::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.bookings.index', compact('bookings', 'statusCounts'));
    }

    public function show(Booking $booking): View
    {
        return view('admin.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking): View
    {
        return view('admin.bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking, ActivityLogger $logger): RedirectResponse
    {
        $data = $request->validate($this->rules());

        $old = $booking->only(['status', 'payment_status']);
        if (($data['status'] ?? null) === 'confirmed' && ! $booking->confirmed_at) {
            $data['confirmed_at'] = now();
        }

        $booking->update($data);
        $logger->log('booking.updated', $booking, [
            'old' => $old,
            'new' => $booking->only(['status', 'payment_status']),
        ]);

        return redirect()->route('admin.bookings.show', $booking)->with('success', 'Booking updated successfully.');
    }

    public function quickUpdate(Request $request, Booking $booking, ActivityLogger $logger): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['nullable', 'in:'.implode(',', array_keys(Booking::statuses()))],
            'payment_status' => ['nullable', 'in:'.implode(',', array_keys(Booking::paymentStatuses()))],
            'amount_total' => ['nullable', 'numeric', 'min:0'],
            'amount_paid' => ['nullable', 'numeric', 'min:0'],
            'payment_method' => ['nullable', 'string', 'max:80'],
            'payment_notes' => ['nullable', 'string', 'max:2000'],
            'admin_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $payload = array_filter($data, fn ($v) => $v !== null && $v !== '');

        if (($payload['status'] ?? null) === 'confirmed' && ! $booking->confirmed_at) {
            $payload['confirmed_at'] = now();
        }

        $booking->update($payload);
        $logger->log('booking.quick_updated', $booking, $payload);

        return back()->with('success', 'Booking details saved.');
    }

    public function destroy(Booking $booking, ActivityLogger $logger): RedirectResponse
    {
        $logger->log('booking.archived', $booking);
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking archived.');
    }

    public function export(Request $request): StreamedResponse
    {
        $filename = 'bookings-'.now()->format('Y-m-d').'.csv';

        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, [
                'Reference', 'Name', 'Email', 'Phone', 'Type', 'Check-in', 'Check-out',
                'Guests', 'Status', 'Payment status', 'Amount total', 'Amount paid', 'Created',
            ]);

            Booking::query()->latest()->chunk(200, function ($rows) use ($out) {
                foreach ($rows as $b) {
                    fputcsv($out, [
                        $b->booking_reference, $b->name, $b->email, $b->phone, $b->booking_type,
                        optional($b->check_in)->format('Y-m-d'), optional($b->check_out)->format('Y-m-d'),
                        $b->guest_count, $b->status, $b->payment_status, $b->amount_total, $b->amount_paid, $b->created_at,
                    ]);
                }
            });
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['required', 'string', 'max:30'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'booking_type' => ['required', 'string', 'max:80'],
            'check_in' => ['nullable', 'date'],
            'check_out' => ['nullable', 'date'],
            'adults' => ['nullable', 'integer', 'min:0'],
            'children' => ['nullable', 'integer', 'min:0'],
            'rooms' => ['nullable', 'integer', 'min:1'],
            'guest_count' => ['nullable', 'integer', 'min:1'],
            'message' => ['nullable', 'string'],
            'status' => ['required', 'in:'.implode(',', array_keys(Booking::statuses()))],
            'payment_status' => ['required', 'in:'.implode(',', array_keys(Booking::paymentStatuses()))],
            'amount_total' => ['nullable', 'numeric', 'min:0'],
            'amount_paid' => ['nullable', 'numeric', 'min:0'],
            'payment_method' => ['nullable', 'string', 'max:80'],
            'payment_notes' => ['nullable', 'string'],
            'admin_notes' => ['nullable', 'string'],
        ];
    }
}
