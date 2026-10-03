<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\ContactEnquiry;
use App\Services\MailNotificationService;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function store(
        StoreContactRequest $request,
        MailNotificationService $mail,
    ): RedirectResponse {
        $enquiry = ContactEnquiry::query()->create([
            ...$request->validated(),
            'ip_address' => $request->ip(),
            'status' => 'new',
        ]);

        $mail->sendContactNotifications($enquiry);

        return back()
            ->withFragment('contact-success')
            ->with('success', 'Our hosts will get back to you shortly by phone, email, or WhatsApp.')
            ->with('contact_success', true);
    }
}
