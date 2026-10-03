<x-emails.branded
    title="Thanks for contacting IXORA"
    eyebrow="Message received"
    preheader="Hi {{ $enquiry->name }}, we received your message"
>
    <p style="margin:0 0 16px;">Hi {{ $enquiry->name }},</p>
    <p style="margin:0 0 18px;">
        Thank you for writing to <strong>{{ $brandName }}</strong>.
        We received your message
        @if($enquiry->subject)
            about <strong>{{ $enquiry->subject }}</strong>
        @endif
        and will reply soon by phone, email, or WhatsApp.
    </p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 22px;background-color:#faf7f1;border:1px solid #efe8dc;border-radius:12px;">
        <tr>
            <td style="padding:16px 18px;">
                <p style="margin:0 0 8px;font-size:12px;letter-spacing:0.12em;text-transform:uppercase;color:#9a7b45;font-weight:700;">Your message</p>
                <p style="margin:0;font-size:14px;line-height:1.65;color:#31463c;white-space:pre-line;">{{ $enquiry->message }}</p>
            </td>
        </tr>
    </table>

    <p style="margin:0 0 20px;">
        Meanwhile, you can browse stays, explore nearby places, or message us on WhatsApp for a faster reply.
    </p>

    <table role="presentation" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center" bgcolor="#173126" style="border-radius:999px;background-color:#173126;">
                <a href="{{ $whatsappUrl ?: $contactUrl }}" style="display:inline-block;padding:14px 28px;font-size:14px;font-weight:700;color:#e8d3a4;text-decoration:none;">
                    WhatsApp us
                </a>
            </td>
            <td width="12">&nbsp;</td>
            <td align="center" style="border-radius:999px;border:1px solid #c6a36a;">
                <a href="{{ $bookingUrl }}" style="display:inline-block;padding:13px 24px;font-size:14px;font-weight:700;color:#173126;text-decoration:none;">
                    Book a stay
                </a>
            </td>
        </tr>
    </table>
</x-emails.branded>
