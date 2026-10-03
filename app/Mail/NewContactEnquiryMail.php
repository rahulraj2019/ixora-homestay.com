<?php

namespace App\Mail;

use App\Models\ContactEnquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewContactEnquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactEnquiry $enquiry) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Contact Enquiry - '.($this->enquiry->subject ?: $this->enquiry->name),
        );
    }

    public function content(): Content
    {
        return new Content(
            html: 'emails.contact-enquiry',
            with: ['enquiry' => $this->enquiry],
        );
    }
}
