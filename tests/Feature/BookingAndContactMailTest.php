<?php

namespace Tests\Feature;

use App\Mail\BookingCustomerConfirmationMail;
use App\Mail\ContactCustomerConfirmationMail;
use App\Mail\NewBookingAdminMail;
use App\Mail\NewContactEnquiryMail;
use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class BookingAndContactMailTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Setting::query()->insert([
            [
                'group' => 'email',
                'key' => 'booking_email_primary',
                'value' => 'admin@ixora.test',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'email',
                'key' => 'booking_customer_confirmation',
                'value' => '1',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'email',
                'key' => 'mail_from_address',
                'value' => 'noreply@ixora.test',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'email',
                'key' => 'mail_from_name',
                'value' => 'IXORA Homestay',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        app(SettingsService::class)->forget();
    }

    public function test_booking_sends_admin_and_customer_mail(): void
    {
        Mail::fake();

        $this->post(route('booking.store'), [
            'name' => 'Guest User',
            'email' => 'guest@example.com',
            'phone' => '9876543210',
            'booking_type' => 'homestay',
            'check_in' => now()->addDays(7)->toDateString(),
            'check_out' => now()->addDays(8)->toDateString(),
            'adults' => 2,
            'children' => 0,
            'message' => 'Looking forward to the stay.',
        ])->assertRedirect();

        Mail::assertSent(NewBookingAdminMail::class, function (NewBookingAdminMail $mail) {
            return $mail->hasTo('admin@ixora.test')
                && collect($mail->from)->contains(fn ($address) => ($address['address'] ?? null) === 'noreply@ixora.test');
        });

        Mail::assertSent(BookingCustomerConfirmationMail::class, function (BookingCustomerConfirmationMail $mail) {
            return $mail->hasTo('guest@example.com');
        });
    }

    public function test_contact_sends_admin_and_customer_mail(): void
    {
        Mail::fake();

        $this->from('/contact')
            ->post(route('contact.store'), [
                'name' => 'Visitor',
                'email' => 'visitor@example.com',
                'phone' => '9876543210',
                'subject' => 'Availability',
                'message' => 'Do you have dates open next month?',
            ])
            ->assertRedirect();

        Mail::assertSent(NewContactEnquiryMail::class, function (NewContactEnquiryMail $mail) {
            return $mail->hasTo('admin@ixora.test');
        });

        Mail::assertSent(ContactCustomerConfirmationMail::class, function (ContactCustomerConfirmationMail $mail) {
            return $mail->hasTo('visitor@example.com');
        });
    }

    public function test_booking_skips_customer_mail_when_disabled(): void
    {
        Setting::query()->where('key', 'booking_customer_confirmation')->update(['value' => '0']);
        app(SettingsService::class)->forget();

        Mail::fake();

        $this->post(route('booking.store'), [
            'name' => 'Guest User',
            'email' => 'guest@example.com',
            'phone' => '9876543210',
            'booking_type' => 'homestay',
            'check_in' => now()->addDays(7)->toDateString(),
            'adults' => 2,
            'children' => 0,
        ])->assertRedirect();

        Mail::assertSent(NewBookingAdminMail::class);
        Mail::assertNotSent(BookingCustomerConfirmationMail::class);
    }
}
