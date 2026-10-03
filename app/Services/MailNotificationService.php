<?php

namespace App\Services;

use App\Mail\BookingCustomerConfirmationMail;
use App\Mail\ContactCustomerConfirmationMail;
use App\Mail\NewBookingAdminMail;
use App\Mail\NewContactEnquiryMail;
use App\Models\Booking;
use App\Models\ContactEnquiry;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class MailNotificationService
{
    public function __construct(protected SettingsService $settings) {}

    public function sendBookingNotifications(Booking $booking): void
    {
        $this->sendToAdmins(new NewBookingAdminMail($booking), 'booking admin');

        $customerEnabled = (string) $this->settings->get('booking_customer_confirmation', '1') === '1';

        if ($customerEnabled && filled($booking->email)) {
            $this->sendTo($booking->email, new BookingCustomerConfirmationMail($booking), 'booking customer');
        }
    }

    public function sendContactNotifications(ContactEnquiry $enquiry): void
    {
        $this->sendToAdmins(new NewContactEnquiryMail($enquiry), 'contact admin');

        if (filled($enquiry->email)) {
            $this->sendTo($enquiry->email, new ContactCustomerConfirmationMail($enquiry), 'contact customer');
        }
    }

    /**
     * @return list<string>
     */
    public function adminRecipients(): array
    {
        $primary = trim((string) $this->settings->get('booking_email_primary', ''));
        $additional = array_filter(array_map(
            'trim',
            explode(',', (string) $this->settings->get('booking_email_additional', ''))
        ));

        $fallback = array_filter([
            trim((string) $this->settings->get('admin_email', '')),
            trim((string) $this->settings->get('email', '')),
            trim((string) config('mail.from.address', '')),
        ], fn (string $email) => $email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL));

        $recipients = array_values(array_unique(array_filter(
            array_merge([$primary], $additional, $fallback),
            fn (string $email) => $email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)
        )));

        return $recipients;
    }

    protected function sendToAdmins(Mailable $mailable, string $label): void
    {
        $recipients = $this->adminRecipients();

        if ($recipients === []) {
            Log::warning("Skipped {$label} mail: no valid admin recipients configured.");

            return;
        }

        $this->sendTo($recipients, $mailable, $label);
    }

    /**
     * @param  string|list<string>  $recipients
     */
    protected function sendTo(string|array $recipients, Mailable $mailable, string $label): void
    {
        try {
            Mail::to($recipients)->send($this->withIdentity($mailable));
        } catch (Throwable $e) {
            Log::error("Failed to send {$label} mail", [
                'error' => $e->getMessage(),
                'mailer' => config('mail.default'),
            ]);
        }
    }

    protected function withIdentity(Mailable $mailable): Mailable
    {
        $fromAddress = trim((string) $this->settings->get('mail_from_address', ''));
        $fromName = trim((string) $this->settings->get('mail_from_name', ''));
        $replyTo = trim((string) $this->settings->get('mail_reply_to', ''));

        if ($fromAddress !== '' && filter_var($fromAddress, FILTER_VALIDATE_EMAIL)) {
            $mailable->from($fromAddress, $fromName !== '' ? $fromName : null);
        }

        if ($replyTo !== '' && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
            $mailable->replyTo($replyTo, $fromName !== '' ? $fromName : null);
        }

        return $mailable;
    }
}
