<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Where is IXORA Homestay located?',
                'answer' => 'IXORA is at <strong>Building No. 7-334, Ixora Homestay, Niduvaloor Gate, Niduvaloor, 670142</strong>, Kannur district, Kerala - a private <strong>family homestay in Kannur</strong> near <strong>Irikkur</strong> and <strong>Thaliparamba</strong>. See the exact pin on <a href="https://maps.app.goo.gl/ht4uuSDodgYPxeKT6" target="_blank" rel="noopener">Google Maps</a>.',
                'show_on_home' => true,
                'sort_order' => 10,
            ],
            [
                'question' => 'What is included in the stay?',
                'answer' => 'You get the full private house: <strong>2 bedrooms</strong>, living area, kitchen, dining room, private courtyard, games, photo point and parking. Stage, campfire and BBQ grill can be arranged for celebrations.',
                'show_on_home' => false,
                'sort_order' => 20,
            ],
            [
                'question' => 'What are the check-in and check-out times?',
                'answer' => 'Check-in is <strong>12:00 PM</strong> and check-out is <strong>11:00 AM</strong>. Early arrival or late departure can be requested if the schedule allows.',
                'show_on_home' => true,
                'sort_order' => 30,
            ],
            [
                'question' => 'How do I book IXORA?',
                'answer' => 'Send your dates, guest count and booking type via the <a href="/booking">Book Now</a> form or WhatsApp <a href="https://wa.me/918921525086">+91 89215 25086</a>. You can also call <a href="tel:+918075771824">+91 80757 71824</a>. We confirm availability and rates directly.',
                'show_on_home' => true,
                'sort_order' => 40,
            ],
            [
                'question' => 'How much does a stay or event cost?',
                'answer' => 'Day stay, overnight stay and event packages are <strong>quoted on enquiry</strong>. Rates depend on your dates, guest count and any event add-ons. Weekday and weekend pricing may differ.',
                'show_on_home' => false,
                'sort_order' => 50,
            ],
            [
                'question' => 'Can I host a birthday, engagement or family gathering?',
                'answer' => 'Yes. IXORA hosts birthdays, engagements, family functions, friends get-togethers and custom events. Ask for stage space, photo point, grill and campfire when you plan your celebration.',
                'show_on_home' => true,
                'sort_order' => 60,
            ],
            [
                'question' => 'Is the kitchen available for guests?',
                'answer' => 'Yes. The private kitchen is included with your booking so you can prepare meals, and the dining room is ready for group meals. On-site parking is also available for guests arriving by car.',
                'show_on_home' => true,
                'sort_order' => 70,
            ],
            [
                'question' => 'Is parking available?',
                'answer' => 'Yes. On-site parking is available for guests arriving by car.',
                'show_on_home' => false,
                'sort_order' => 80,
            ],
            [
                'question' => 'Are campfire and BBQ included?',
                'answer' => 'Campfire, BBQ grill, stage, decoration, games and the photo point can be added to any stay or celebration. Mention what you need when you enquire.',
                'show_on_home' => false,
                'sort_order' => 90,
            ],
            [
                'question' => 'What nearby places can we visit?',
                'answer' => 'Popular trips from here include Palakkayam Thattu, Paithalmala, Ezharakund and Alakapuri waterfalls, Muthappan Temple, Vismaya, Rajarajeswara Temple, Madayi Para, St. Angelo Fort and Muzhappilangad Drive-in Beach. See the full list on our <a href="/explore">Explore</a> page.',
                'show_on_home' => true,
                'sort_order' => 100,
            ],
            [
                'question' => 'Is there an extra guest charge?',
                'answer' => 'Extra guest charges may apply beyond the base occupancy confirmed for your booking. Share your final headcount when you enquire so we can quote correctly.',
                'show_on_home' => false,
                'sort_order' => 110,
            ],
            [
                'question' => 'What is the cancellation policy?',
                'answer' => 'Cancellation terms are confirmed with your booking and may vary by date and package. Ask us on WhatsApp or phone for the policy that applies to your reservation.',
                'show_on_home' => false,
                'sort_order' => 120,
            ],
            [
                'question' => 'Is IXORA a good homestay near Kannur for families?',
                'answer' => 'Yes. IXORA is a <strong>private 2 BHK family homestay in Niduvaloor, Kannur</strong> with bedrooms, kitchen, dining, courtyard and parking — suited to quiet weekends and multi-generation trips.',
                'show_on_home' => true,
                'sort_order' => 130,
            ],
            [
                'question' => 'How far is IXORA from Kannur town and the beach?',
                'answer' => 'IXORA sits at <strong>Niduvaloor Gate</strong> in Kannur district. Guests commonly day-trip to Kannur town, St. Angelo Fort and <strong>Muzhappilangad Drive-in Beach</strong>. Ask us for the best route from your arrival point.',
                'show_on_home' => false,
                'sort_order' => 140,
            ],
            [
                'question' => 'Do you allow overnight stays and day stays?',
                'answer' => 'Yes. We offer <strong>overnight stays</strong> in the full private house and <strong>day stays</strong> for gatherings when the calendar is free. Share your dates on the <a href="/booking">booking form</a> or WhatsApp.',
                'show_on_home' => true,
                'sort_order' => 150,
            ],
            [
                'question' => 'Is IXORA suitable as a private event venue in Kannur?',
                'answer' => 'Yes. Guests book IXORA as a <strong>private event venue in Kannur</strong> for birthdays, engagements, family functions and friends get-togethers, with courtyard space, stage options, photo point, campfire and grill.',
                'show_on_home' => false,
                'sort_order' => 160,
            ],
            [
                'question' => 'What makes IXORA different from a hotel in Kannur?',
                'answer' => 'You get the <strong>entire house privately</strong> — not a hotel room. Cook in the kitchen, gather in the courtyard and plan evenings at your pace, with host support for stays and celebrations.',
                'show_on_home' => false,
                'sort_order' => 170,
            ],
            [
                'question' => 'Is IXORA among the best homestays in Kannur for families?',
                'answer' => 'Guests choose IXORA as a <strong>best family homestay in Kannur</strong> option because you get a private 2 BHK house with kitchen, courtyard, parking and space for children — not a cramped hotel room.',
                'show_on_home' => true,
                'sort_order' => 180,
            ],
            [
                'question' => 'Is there a homestay near Kannur airport or railway station?',
                'answer' => 'IXORA is at <strong>Niduvaloor Gate, Kannur</strong>. Guests arriving via <strong>Kannur International Airport</strong> or Kannur railway station typically continue by taxi or car. Share your arrival details when you book and we will guide the best route.',
                'show_on_home' => false,
                'sort_order' => 190,
            ],
            [
                'question' => 'Can I book IXORA for a weekend getaway in Kannur?',
                'answer' => 'Yes. IXORA is popular for a <strong>weekend stay in Kannur</strong> — overnight family stays, couples’ breaks and friends’ trips with easy access to beaches, forts and temples.',
                'show_on_home' => true,
                'sort_order' => 200,
            ],
            [
                'question' => 'Is IXORA close to Muzhappilangad Beach and St. Angelo Fort?',
                'answer' => 'Yes — many guests use IXORA as a <strong>homestay near Muzhappilangad Drive-in Beach</strong> and plan day trips to <strong>St. Angelo Fort Kannur</strong>, Payyambalam Beach and Parassinikadavu. See our <a href="/explore">Kannur travel guide</a>.',
                'show_on_home' => false,
                'sort_order' => 210,
            ],
            [
                'question' => 'Do you offer parking with the Kannur homestay stay?',
                'answer' => 'Yes. IXORA includes <strong>on-site parking</strong>, which makes it a convenient homestay with parking in Kannur for self-drive families and groups.',
                'show_on_home' => false,
                'sort_order' => 220,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::query()->updateOrCreate(
                ['question' => $faq['question']],
                [
                    'answer' => $faq['answer'],
                    'show_on_home' => $faq['show_on_home'],
                    'sort_order' => $faq['sort_order'],
                    'status' => 'active',
                ]
            );
        }
    }
}
