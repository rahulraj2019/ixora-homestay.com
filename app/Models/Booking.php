<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'booking_reference', 'name', 'email', 'phone', 'whatsapp', 'booking_type',
        'check_in', 'check_out', 'adults', 'children', 'rooms', 'event_type',
        'guest_count', 'message', 'status', 'payment_status', 'amount_total',
        'amount_paid', 'payment_method', 'payment_notes', 'confirmed_at',
        'admin_notes', 'source', 'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'check_in' => 'date',
            'check_out' => 'date',
            'confirmed_at' => 'datetime',
            'amount_total' => 'decimal:2',
            'amount_paid' => 'decimal:2',
        ];
    }

    public static function statuses(): array
    {
        return [
            'new' => 'New',
            'pending' => 'Pending',
            'contacted' => 'Contacted',
            'confirmed' => 'Confirmed',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            'rejected' => 'Rejected',
        ];
    }

    public static function paymentStatuses(): array
    {
        return [
            'unpaid' => 'Unpaid',
            'partial' => 'Partially paid',
            'paid' => 'Paid',
            'refunded' => 'Refunded',
        ];
    }

    public function statusLabel(): string
    {
        return self::statuses()[$this->status] ?? ucfirst((string) $this->status);
    }

    public function paymentStatusLabel(): string
    {
        return self::paymentStatuses()[$this->payment_status] ?? ucfirst((string) $this->payment_status);
    }

    public function balanceDue(): ?float
    {
        if ($this->amount_total === null) {
            return null;
        }

        return max(0, (float) $this->amount_total - (float) ($this->amount_paid ?? 0));
    }
}
