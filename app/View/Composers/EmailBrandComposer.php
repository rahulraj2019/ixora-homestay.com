<?php

namespace App\View\Composers;

use Illuminate\View\View;

class EmailBrandComposer
{
    /**
     * @return array<string, mixed>
     */
    public function brand(): array
    {
        $phone = setting('phone_primary', '+91 89215 25086');
        $phone2 = setting('phone_secondary', '+91 80757 71824');
        $email = setting('email', config('mail.from.address', 'info@ixora-homestay.com'));
        $whatsapp = whatsapp_number();

        $logoPath = 'assets/images/ixora-homestay-logo-mail.png';
        if (! is_file(public_path($logoPath))) {
            $logoPath = 'assets/images/ixora-homestay-logo.webp';
        }

        return [
            'brandName' => setting('brand_name', 'IXORA'),
            'businessName' => setting('business_name', 'IXORA Homestay'),
            'tagline' => setting('footer_tagline', 'Stay | Celebrate | Belong'),
            'script' => setting('footer_script', 'Stay Closer to Nature'),
            'piece' => setting('footer_piece', 'A Piece of Kerala, Just for You'),
            'address' => setting('address', "Building No. 7-334, Ixora Homestay,\nNiduvaloor Gate, Niduvaloor, 670142"),
            'phone' => $phone,
            'phoneTel' => preg_replace('/\s+/', '', (string) $phone),
            'phone2' => $phone2,
            'phone2Tel' => preg_replace('/\s+/', '', (string) $phone2),
            'email' => $email,
            'whatsapp' => $whatsapp,
            'whatsappUrl' => $whatsapp !== '' ? whatsapp_url() : null,
            'mapsUrl' => function_exists('homestay_maps_link') ? homestay_maps_link() : url('/'),
            'siteUrl' => url('/'),
            'bookingUrl' => route('page.show', 'booking'),
            'contactUrl' => route('page.show', 'contact'),
            'exploreUrl' => route('page.show', 'explore'),
            'logoUrl' => asset($logoPath),
            'instagram' => setting('instagram'),
            'facebook' => setting('facebook'),
            'youtube' => setting('youtube'),
            'year' => date('Y'),
        ];
    }

    public function compose(View $view): void
    {
        $view->with($this->brand());
    }
}
