<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\Review;
use Database\Seeders\PagesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewsPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PagesSeeder::class);
    }

    public function test_home_shows_reviews_showcase_without_form(): void
    {
        Review::query()->create([
            'name' => 'Priya Nair',
            'email' => 'priya@example.com',
            'location' => 'Kochi',
            'rating' => 5,
            'message' => 'A peaceful family stay near Niduvaloor with a lovely courtyard.',
            'status' => 'approved',
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('What our guests say', false);
        $response->assertSee('Priya Nair', false);
        $response->assertSee(route('page.show', 'reviews'), false);
        $response->assertDontSee('id="review-form"', false);
        $response->assertDontSee('Add a review', false);
    }

    public function test_reviews_page_lists_reviews_and_shows_form(): void
    {
        Review::query()->create([
            'name' => 'Arun Menon',
            'email' => 'arun@example.com',
            'location' => 'Bengaluru',
            'rating' => 5,
            'message' => 'Perfect venue for our small family celebration in Kannur.',
            'status' => 'approved',
        ]);

        Review::query()->create([
            'name' => 'Pending Guest',
            'email' => 'pending@example.com',
            'location' => 'Delhi',
            'rating' => 4,
            'message' => 'This pending review should stay hidden from the public page.',
            'status' => 'pending',
        ]);

        $page = Page::query()->where('slug', 'reviews')->first();
        $this->assertNotNull($page);

        $response = $this->get(route('page.show', 'reviews'));

        $response->assertOk();
        $response->assertSee('Stories from stays at IXORA', false);
        $response->assertSee('Arun Menon', false);
        $response->assertSee('Add a review', false);
        $response->assertSee('id="review-form"', false);
        $response->assertDontSee('Pending Guest', false);
    }
}
