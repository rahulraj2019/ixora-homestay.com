@php
    $detailCell = 'padding:10px 0;border-bottom:1px solid #efe8dc;font-size:14px;line-height:1.5;color:#31463c;';
    $labelCell = $detailCell.'width:38%;color:#6b7c72;font-weight:600;';
@endphp

<x-emails.branded
    title="New booking request"
    eyebrow="Admin alert"
    preheader="New booking {{ $booking->booking_reference }} from {{ $booking->name }}"
>
    <p style="margin:0 0 18px;">A new booking enquiry just arrived. Review the details below and respond from the admin panel.</p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 22px;background-color:#faf7f1;border:1px solid #efe8dc;border-radius:12px;">
        <tr>
            <td style="padding:16px 18px;">
                <p style="margin:0 0 4px;font-size:12px;letter-spacing:0.12em;text-transform:uppercase;color:#9a7b45;font-weight:700;">Reference</p>
                <p style="margin:0;font-size:20px;font-family:Georgia,'Times New Roman',serif;color:#173126;font-weight:600;">{{ $booking->booking_reference }}</p>
            </td>
        </tr>
    </table>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 22px;">
        <tr>
            <td style="{{ $labelCell }}">Guest</td>
            <td style="{{ $detailCell }}">{{ $booking->name }}</td>
        </tr>
        <tr>
            <td style="{{ $labelCell }}">Email</td>
            <td style="{{ $detailCell }}">{{ $booking->email ?: '—' }}</td>
        </tr>
        <tr>
            <td style="{{ $labelCell }}">Phone</td>
            <td style="{{ $detailCell }}">{{ $booking->phone }}</td>
        </tr>
        <tr>
            <td style="{{ $labelCell }}">WhatsApp</td>
            <td style="{{ $detailCell }}">{{ $booking->whatsapp ?: '—' }}</td>
        </tr>
        <tr>
            <td style="{{ $labelCell }}">Type</td>
            <td style="{{ $detailCell }}">{{ $booking->booking_type }}</td>
        </tr>
        <tr>
            <td style="{{ $labelCell }}">Check-in</td>
            <td style="{{ $detailCell }}">{{ optional($booking->check_in)->format('d M Y') ?: '—' }}</td>
        </tr>
        <tr>
            <td style="{{ $labelCell }}">Check-out</td>
            <td style="{{ $detailCell }}">{{ optional($booking->check_out)->format('d M Y') ?: '—' }}</td>
        </tr>
        <tr>
            <td style="{{ $labelCell }}">Guests</td>
            <td style="{{ $detailCell }}">
                {{ $booking->guest_count ?: (($booking->adults ?? 0) + ($booking->children ?? 0)) }}
                ({{ $booking->adults ?? 0 }} adults, {{ $booking->children ?? 0 }} kids)
                <br><span style="font-size:12px;color:#6b7c72;">Children are under 10. Guests aged 10+ are counted as adults.</span>
            </td>
        </tr>
        @if($booking->event_type)
        <tr>
            <td style="{{ $labelCell }}">Event type</td>
            <td style="{{ $detailCell }}">{{ $booking->event_type }}</td>
        </tr>
        @endif
        <tr>
            <td style="{{ $labelCell }}border-bottom:0;">Message</td>
            <td style="{{ $detailCell }}border-bottom:0;">{{ $booking->message ?: '—' }}</td>
        </tr>
    </table>

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin:8px 0 0;">
        <tr>
            <td align="center" bgcolor="#173126" style="border-radius:999px;background-color:#173126;">
                <a href="{{ url('/admin/bookings/'.$booking->id) }}" style="display:inline-block;padding:14px 28px;font-size:14px;font-weight:700;color:#e8d3a4;text-decoration:none;">
                    View booking in admin
                </a>
            </td>
        </tr>
    </table>
</x-emails.branded>
