<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Home',
                'slug' => 'home',
                'template' => 'home',
                'sort_order' => 1,
                'meta_title' => 'Best Homestay in Kannur | Family Homestay near Irikkur & Thaliparamba',
                'meta_description' => 'Book the best homestay in Kannur at IXORA Niduvaloor - affordable family homestay near Irikkur & Thaliparamba. Private 2 BHK home stay in Kannur Kerala with parking & courtyard.',
            ],
            [
                'title' => 'Stay',
                'slug' => 'stay',
                'template' => 'stay',
                'sort_order' => 2,
                'meta_title' => 'Family Homestay in Kannur | Affordable Homestay near Irikkur',
                'meta_description' => 'Affordable family rooms at IXORA - a private homestay in Kannur near Irikkur and Thaliparamba with 2 bedrooms, kitchen, dining, courtyard and parking.',
            ],
            [
                'title' => 'Events',
                'slug' => 'events',
                'template' => 'events',
                'sort_order' => 3,
                'meta_title' => 'Homestay in Kannur for Celebrations | Event Venue Niduvaloor',
                'meta_description' => 'Host birthdays and family gatherings at IXORA - a Kannur homestay near Thaliparamba & Irikkur with courtyard, stage, photo point, campfire and grill.',
            ],
            [
                'title' => 'Explore',
                'slug' => 'explore',
                'template' => 'explore',
                'sort_order' => 4,
                'meta_title' => 'Things to Do near Homestay in Kannur | Explore from IXORA',
                'meta_description' => 'From your homestay near Kannur & Irikkur explore Muzhappilangad Beach, St. Angelo Fort, Parassinikadavu Temple, Paithalmala and more day trips.',
            ],
            [
                'title' => 'Gallery',
                'slug' => 'gallery',
                'template' => 'gallery',
                'sort_order' => 5,
                'meta_title' => 'Homestay in Kannur Photos | IXORA Rooms & Courtyard Gallery',
                'meta_description' => 'See rooms, courtyard and celebration spaces at IXORA - an affordable family home stay in Kannur Kerala at Niduvaloor Gate near Irikkur.',
            ],
            [
                'title' => 'Book Now',
                'slug' => 'booking',
                'template' => 'booking',
                'sort_order' => 6,
                'meta_title' => 'Book Homestay in Kannur | IXORA near Irikkur & Thaliparamba',
                'meta_description' => 'Book an affordable family homestay in Kannur at IXORA Niduvaloor Gate. Check dates for private 2 BHK stay near Irikkur and Thaliparamba - WhatsApp rates.',
            ],
            [
                'title' => 'About Us',
                'slug' => 'about',
                'template' => 'about',
                'sort_order' => 7,
                'meta_title' => 'About IXORA | Homestay near Irikkur, Thaliparamba & Kannur',
                'meta_description' => 'IXORA is a traditional Kerala family homestay in Niduvaloor near Irikkur and Thaliparamba - private house, courtyard, kitchen and parking in Kannur district.',
            ],
            [
                'title' => 'FAQ',
                'slug' => 'faq',
                'template' => 'faq',
                'sort_order' => 8,
                'meta_title' => 'Homestay in Kannur FAQ | Location near Irikkur & Booking Tips',
                'meta_description' => 'FAQs for the best homestay in Kannur near Irikkur & Thaliparamba: location, parking, kitchen, check-in, events and day trips around Kannur Kerala.',
            ],
            [
                'title' => 'Guest Reviews',
                'slug' => 'reviews',
                'template' => 'reviews',
                'sort_order' => 9,
                'meta_title' => 'IXORA Homestay Reviews | Best Homestay in Kannur Guests',
                'meta_description' => 'Guest reviews of IXORA - family homestay in Kannur near Irikkur and Thaliparamba. Real stays, celebrations and Kerala hospitality at Niduvaloor.',
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact',
                'template' => 'contact',
                'sort_order' => 10,
                'meta_title' => 'Contact Homestay in Kannur | IXORA Niduvaloor near Irikkur',
                'meta_description' => 'Call or WhatsApp to book an affordable homestay in Kannur near Irikkur and Thaliparamba. IXORA Niduvaloor Gate - +91 89215 25086 / +91 80757 71824.',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy',
                'template' => 'privacy',
                'sort_order' => 11,
                'meta_title' => 'Privacy Policy | IXORA Homestay Kannur',
                'meta_description' => 'How IXORA Homestay & Event Venue handles guest and booking enquiry data at Niduvaloor, Kannur, Kerala.',
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms',
                'template' => 'terms',
                'sort_order' => 12,
                'meta_title' => 'Terms & Conditions | IXORA Homestay Kannur',
                'meta_description' => 'Booking terms, check-in times and cancellation notes for IXORA Homestay & Event Venue in Niduvaloor, Kannur Kerala.',
            ],
            [
                'title' => 'Sitemap',
                'slug' => 'sitemap',
                'template' => 'sitemap',
                'sort_order' => 13,
                'meta_title' => 'Sitemap | IXORA Homestay Kannur Pages',
                'meta_description' => 'All IXORA Homestay pages - stay, events, explore Kannur tourist places, gallery, booking, reviews, FAQ and contact.',
            ],
        ];

        foreach ($pages as $data) {
            Page::query()->updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, [
                    'status' => 'published',
                    'robots' => 'index,follow',
                    'og_title' => $data['meta_title'],
                    'og_description' => $data['meta_description'],
                    'twitter_title' => $data['meta_title'],
                    'twitter_description' => $data['meta_description'],
                    'og_image' => 'assets/images/ixora-homestay-niduvaloor-exterior-sunset.jpg',
                ]),
            );
        }
    }
}
