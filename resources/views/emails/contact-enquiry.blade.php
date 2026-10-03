@php
    $detailCell = 'padding:10px 0;border-bottom:1px solid #efe8dc;font-size:14px;line-height:1.5;color:#31463c;';
    $labelCell = $detailCell.'width:38%;color:#6b7c72;font-weight:600;';
@endphp

<x-emails.branded
    title="New contact enquiry"
    eyebrow="Admin alert"
    preheader="New message from {{ $enquiry->name }}"
>
    <p style="margin:0 0 18px;">Someone reached out through the website contact form. Details below:</p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 22px;">
        <tr>
            <td style="{{ $labelCell }}">Name</td>
            <td style="{{ $detailCell }}">{{ $enquiry->name }}</td>
        </tr>
        <tr>
            <td style="{{ $labelCell }}">Email</td>
            <td style="{{ $detailCell }}"><a href="mailto:{{ $enquiry->email }}" style="color:#173126;text-decoration:underline;">{{ $enquiry->email }}</a></td>
        </tr>
        <tr>
            <td style="{{ $labelCell }}">Phone</td>
            <td style="{{ $detailCell }}">{{ $enquiry->phone ?: '—' }}</td>
        </tr>
        <tr>
            <td style="{{ $labelCell }}">Subject</td>
            <td style="{{ $detailCell }}">{{ $enquiry->subject ?: '—' }}</td>
        </tr>
        <tr>
            <td style="{{ $labelCell }}border-bottom:0;">Message</td>
            <td style="{{ $detailCell }}border-bottom:0;white-space:pre-line;">{{ $enquiry->message }}</td>
        </tr>
    </table>

    <table role="presentation" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center" bgcolor="#173126" style="border-radius:999px;background-color:#173126;">
                <a href="{{ url('/admin/enquiries') }}" style="display:inline-block;padding:14px 28px;font-size:14px;font-weight:700;color:#e8d3a4;text-decoration:none;">
                    Open enquiries
                </a>
            </td>
        </tr>
    </table>
</x-emails.branded>
