<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            [
                'name' => 'Ananya Krishnan',
                'email' => 'ananya.guest@example.com',
                'location' => 'Kochi, Kerala',
                'rating' => 5,
                'message' => 'Wonderful private 2 BHK homestay in Niduvaloor. The courtyard, campfire and kitchen made our family weekend perfect. Clean rooms and easy booking with the hosts.',
            ],
            [
                'name' => 'Rahul Menon',
                'email' => 'rahul.guest@example.com',
                'location' => 'Bengaluru, Karnataka',
                'rating' => 5,
                'message' => 'Best homestay near Kannur for a quiet stay. We visited Palakkayam Thattu and Muzhappilangad from here. Parking on site and very helpful WhatsApp support.',
            ],
            [
                'name' => 'Meera Nair',
                'email' => 'meera.guest@example.com',
                'location' => 'Thrissur, Kerala',
                'rating' => 5,
                'message' => 'Hosted my sister’s birthday at IXORA. Stage, photo point and grill were excellent. Perfect event venue in Niduvaloor Gate for family celebrations.',
            ],
            [
                'name' => 'Arjun Patel',
                'email' => 'arjun.guest@example.com',
                'location' => 'Ahmedabad, Gujarat',
                'rating' => 5,
                'message' => 'Peaceful Kerala retreat with a full house to ourselves. Two bedrooms, dining and courtyard evenings — ideal private stay in Kannur district.',
            ],
            [
                'name' => 'Sneha Rajan',
                'email' => 'sneha.guest@example.com',
                'location' => 'Kozhikode, Kerala',
                'rating' => 5,
                'message' => 'Engagement celebration felt magical under the evening lights. Spacious venue, friendly hosts and great value for a Kannur event space.',
            ],
            [
                'name' => 'Vivek Sharma',
                'email' => 'vivek.guest@example.com',
                'location' => 'Hyderabad, Telangana',
                'rating' => 4,
                'message' => 'Comfortable overnight stay with kitchen access. Close to waterfalls and hill stations. Would book again for a North Kerala weekend getaway.',
            ],
            [
                'name' => 'Divya Thomas',
                'email' => 'divya.guest@example.com',
                'location' => 'Thiruvananthapuram, Kerala',
                'rating' => 5,
                'message' => 'Clean, private and surrounded by greenery. Kids loved the courtyard games. Highly recommend IXORA Homestay for families visiting Kannur.',
            ],
            [
                'name' => 'Nikhil Das',
                'email' => 'nikhil.guest@example.com',
                'location' => 'Mangalore, Karnataka',
                'rating' => 5,
                'message' => 'Friends get-together with BBQ and campfire was unforgettable. Easy drive from the coast and a private house for the whole group.',
            ],
            [
                'name' => 'Priya Iyer',
                'email' => 'priya.guest@example.com',
                'location' => 'Chennai, Tamil Nadu',
                'rating' => 5,
                'message' => 'Beautiful homestay experience in Niduvaloor. Hosts confirmed rates quickly on WhatsApp. Perfect base to explore Kannur forts and beaches.',
            ],
            [
                'name' => 'Mohammed Farhan',
                'email' => 'farhan.guest@example.com',
                'location' => 'Malappuram, Kerala',
                'rating' => 5,
                'message' => 'Spacious rooms, private kitchen and calm courtyard. Excellent choice for a family gathering without hotel crowds.',
            ],
            [
                'name' => 'Lakshmi Venkatesh',
                'email' => 'lakshmi.guest@example.com',
                'location' => 'Mysuru, Karnataka',
                'rating' => 4,
                'message' => 'Loved the nature around the property. Day stay for relatives worked well. Clear communication and good parking.',
            ],
            [
                'name' => 'George Mathew',
                'email' => 'george.guest@example.com',
                'location' => 'Ernakulam, Kerala',
                'rating' => 5,
                'message' => 'IXORA is a gem for stay and celebrate plans in Kannur. Courtyard evenings, campfire and photo point — everything guests need.',
            ],
        ];

        // Remove placeholder demo review if present.
        Review::query()
            ->where('email', 'demo@example.com')
            ->orWhere('name', 'Demo Guest')
            ->forceDelete();

        foreach ($reviews as $review) {
            Review::query()->updateOrCreate(
                ['email' => $review['email']],
                [
                    'name' => $review['name'],
                    'location' => $review['location'],
                    'rating' => $review['rating'],
                    'message' => $review['message'],
                    'status' => 'approved',
                    'ip_address' => '127.0.0.1',
                ]
            );
        }
    }
}
