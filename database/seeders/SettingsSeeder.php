<?php

namespace Database\Seeders;

use App\Services\SettingsService;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = app(SettingsService::class);

        $rows = [
            ['general', 'site_name', 'IXORA', 'text'],
            ['general', 'brand_name', 'IXORA', 'text'],
            ['general', 'business_name', 'IXORA Homestay', 'text'],
            ['general', 'alternate_name', 'Niduvaloor Gate Homestay & Event Venue', 'text'],
            ['general', 'tagline', 'Best family homestay in Kannur', 'text'],
            ['general', 'site_description', 'IXORA is an affordable family homestay in Kannur at Niduvaloor Gate near Irikkur and Thaliparamba - private 2 BHK home stay in Kannur Kerala with courtyard, kitchen, parking and easy access to beaches, forts and temples.', 'text'],
            ['general', 'schema_description', 'Best homestay in Kannur near Irikkur and Thaliparamba: private 2 BHK family rooms, kitchen, parking, courtyard, campfire and grill. Ideal affordable homestay in Kannur Kerala for families and weekend getaways.', 'text'],
            ['general', 'favicon', '', 'text'],
            ['general', 'logo', '', 'text'],
            ['general', 'admin_email', 'info@ixora-homestay.com', 'text'],
            ['general', 'header_cta_label', 'Call to book', 'text'],
            ['general', 'price_range', '$$', 'text'],

            ['contact', 'phone_primary', '+91 89215 25086', 'text'],
            ['contact', 'phone_secondary', '+91 80757 71824', 'text'],
            ['contact', 'whatsapp', '918921525086', 'text'],
            ['contact', 'email', 'info@ixora-homestay.com', 'text'],
            ['contact', 'address', "Building No. 7-334, Ixora Homestay,\nNiduvaloor Gate, Niduvaloor, 670142", 'text'],
            ['contact', 'street_address', 'Building No. 7-334, Ixora Homestay, Niduvaloor Gate', 'text'],
            ['contact', 'address_locality', 'Niduvaloor', 'text'],
            ['contact', 'address_region', 'Kerala', 'text'],
            ['contact', 'postal_code', '670142', 'text'],
            ['contact', 'map_query', '12.043528,75.466966', 'text'],
            ['contact', 'geo_region', 'IN-KL', 'text'],
            ['contact', 'geo_placename', 'Niduvaloor, Irikkur, Thaliparamba, Kannur, Kerala', 'text'],
            ['contact', 'geo_position', '12.043528;75.466966', 'text'],
            ['contact', 'geo_latitude', '12.043528', 'text'],
            ['contact', 'geo_longitude', '75.466966', 'text'],

            ['social', 'instagram', 'https://instagram.com', 'text'],
            ['social', 'facebook', 'https://facebook.com', 'text'],
            ['social', 'youtube', 'https://youtube.com', 'text'],

            ['seo', 'meta_description', 'Best homestay in Kannur at IXORA Niduvaloor near Irikkur & Thaliparamba - affordable family homestay in Kannur Kerala with private 2 BHK, parking and courtyard.', 'text'],
            ['seo', 'default_meta_title', 'Best Homestay in Kannur | Family Homestay near Irikkur & Thaliparamba', 'text'],
            ['seo', 'default_meta_description', 'Book IXORA - affordable family homestay in Kannur near Irikkur and Thaliparamba. Private 2 BHK home stay in Kannur Kerala with kitchen, parking and courtyard.', 'text'],
            ['seo', 'seo_keywords', 'Homestay in Kannur, Best homestay in Kannur, Affordable homestay in Kannur, Family homestay in Kannur, Homestay near Kannur, Homestay in Thaliparamba, Homestay in Irikkur, Homestay near Irikkur, Homestay near Thaliparamba, Home stay in Kannur Kerala, Niduvaloor Homestay', 'text'],
            ['seo', 'default_og_image', 'assets/images/ixora-homestay-niduvaloor-exterior-sunset.jpg', 'text'],
            ['seo', 'robots_default', 'index,follow', 'text'],

            ['general', 'footer_text', 'A premium private homestay and event venue in Niduvaloor, Kannur Kerala - serene family stays, memorable celebrations, courtyard, campfire and grill.', 'text'],
            ['general', 'footer_tagline', 'Stay | Celebrate | Belong', 'text'],
            ['general', 'footer_script', 'Stay Closer to Nature', 'text'],
            ['general', 'footer_piece', 'A Piece of Kerala, Just for You', 'text'],
            ['general', 'copyright', '© '.date('Y').' IXORA. All Rights Reserved.', 'text'],
            ['contact', 'maps_link', 'https://maps.app.goo.gl/ht4uuSDodgYPxeKT6', 'text'],
            ['contact', 'maps_embed', 'https://www.google.com/maps?q=12.043528,75.466966+(IXORA+Homestay)&z=16&output=embed', 'text'],
            ['contact', 'whatsapp_message', 'Hi IXORA Homestay! I found your details on the website and I\'d love to know more about booking a stay or celebration with you.', 'text'],
            ['email', 'booking_email_primary', 'info@ixora-homestay.com', 'text'],
            ['email', 'booking_email_additional', '', 'text'],
            ['email', 'mail_from_name', 'IXORA Homestay', 'text'],
            ['email', 'mail_from_address', 'info@ixora-homestay.com', 'text'],
            ['email', 'mail_reply_to', 'info@ixora-homestay.com', 'text'],
            ['email', 'booking_customer_confirmation', '1', 'text'],
        ];

        foreach ($rows as [$group, $key, $value, $type]) {
            $settings->set($group, $key, $value, $type);
        }
    }
}
