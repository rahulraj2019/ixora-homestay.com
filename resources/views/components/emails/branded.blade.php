@props([
    'title',
    'eyebrow' => null,
    'preheader' => null,
])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $preheader ?? $title }}</title>
</head>
<body style="margin:0;padding:0;background-color:#f3efe7;font-family:'Segoe UI',Roboto,Helvetica,Arial,sans-serif;color:#1a2e24;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;">
@if($preheader)
<div style="display:none;font-size:1px;line-height:1px;max-height:0;max-width:0;opacity:0;overflow:hidden;mso-hide:all;">
    {{ $preheader }}
</div>
@endif

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f3efe7;margin:0;padding:0;width:100%;">
    <tr>
        <td align="center" style="padding:28px 12px;">
            <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;background-color:#ffffff;border-radius:18px;overflow:hidden;border:1px solid #e5ddd0;">

                <tr>
                    <td align="center" style="background-color:#173126;padding:28px 28px 22px;">
                        <a href="{{ $siteUrl }}" style="text-decoration:none;display:inline-block;">
                            <img
                                src="{{ $logoUrl }}"
                                alt="{{ $brandName }} Homestay"
                                width="168"
                                style="display:block;width:168px;max-width:70%;height:auto;border:0;outline:none;text-decoration:none;background-color:transparent;"
                            >
                        </a>
                        <p style="margin:14px 0 0;font-size:12px;letter-spacing:0.18em;text-transform:uppercase;color:#e8d3a4;font-weight:600;">
                            {{ $tagline }}
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="height:4px;line-height:4px;font-size:0;background-color:#c6a36a;">&nbsp;</td>
                </tr>

                @if($eyebrow)
                <tr>
                    <td style="padding:26px 32px 0;background-color:#ffffff;">
                        <p style="margin:0;font-size:12px;letter-spacing:0.14em;text-transform:uppercase;color:#9a7b45;font-weight:700;">
                            {{ $eyebrow }}
                        </p>
                    </td>
                </tr>
                @endif

                <tr>
                    <td style="padding:{{ $eyebrow ? '10px' : '28px' }} 32px 8px;background-color:#ffffff;">
                        <h1 style="margin:0;font-family:Georgia,'Times New Roman',serif;font-size:28px;line-height:1.25;color:#173126;font-weight:600;">
                            {{ $title }}
                        </h1>
                    </td>
                </tr>

                <tr>
                    <td style="padding:12px 32px 28px;background-color:#ffffff;font-size:15px;line-height:1.65;color:#31463c;">
                        {{ $slot }}
                    </td>
                </tr>

                <tr>
                    <td style="background-color:#12261d;padding:28px 28px 18px;color:#f7f3ec;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td style="padding-bottom:16px;border-bottom:1px solid #3a5044;">
                                    <p style="margin:0 0 4px;font-family:Georgia,'Times New Roman',serif;font-size:22px;color:#e8d3a4;letter-spacing:0.08em;">
                                        {{ $brandName }}
                                    </p>
                                    <p style="margin:0;font-size:13px;color:#c9d5ce;font-style:italic;">
                                        {{ $script }}
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top:18px;font-size:13px;line-height:1.7;color:#d7e0db;">
                                    <p style="margin:0 0 10px;white-space:pre-line;">{{ $address }}</p>

                                    <p style="margin:0 0 4px;">
                                        <a href="tel:{{ $phoneTel }}" style="color:#e8d3a4;text-decoration:none;">{{ $phone }}</a>
                                        @if($phone2)
                                            &nbsp;·&nbsp;
                                            <a href="tel:{{ $phone2Tel }}" style="color:#e8d3a4;text-decoration:none;">{{ $phone2 }}</a>
                                        @endif
                                    </p>

                                    <p style="margin:0 0 4px;">
                                        <a href="mailto:{{ $email }}" style="color:#e8d3a4;text-decoration:none;">{{ $email }}</a>
                                    </p>

                                    @if($whatsappUrl)
                                    <p style="margin:0 0 14px;">
                                        <a href="{{ $whatsappUrl }}" style="color:#e8d3a4;text-decoration:none;">WhatsApp booking</a>
                                    </p>
                                    @endif

                                    <p style="margin:0 0 6px;">
                                        <a href="{{ $siteUrl }}" style="color:#f7f3ec;text-decoration:underline;">Website</a>
                                        &nbsp;·&nbsp;
                                        <a href="{{ $bookingUrl }}" style="color:#f7f3ec;text-decoration:underline;">Book stay</a>
                                        &nbsp;·&nbsp;
                                        <a href="{{ $exploreUrl }}" style="color:#f7f3ec;text-decoration:underline;">Explore</a>
                                        &nbsp;·&nbsp;
                                        <a href="{{ $mapsUrl }}" style="color:#f7f3ec;text-decoration:underline;">Directions</a>
                                    </p>

                                    @if($instagram || $facebook || $youtube)
                                    <p style="margin:12px 0 0;">
                                        @if($instagram)
                                            <a href="{{ $instagram }}" style="color:#e8d3a4;text-decoration:none;margin-right:12px;">Instagram</a>
                                        @endif
                                        @if($facebook)
                                            <a href="{{ $facebook }}" style="color:#e8d3a4;text-decoration:none;margin-right:12px;">Facebook</a>
                                        @endif
                                        @if($youtube)
                                            <a href="{{ $youtube }}" style="color:#e8d3a4;text-decoration:none;">YouTube</a>
                                        @endif
                                    </p>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td align="center" style="background-color:#0e1c16;padding:14px 24px;font-size:11px;line-height:1.5;color:#8fa397;">
                        © {{ $year }} {{ $businessName }}. All rights reserved.<br>
                        {{ $piece }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
