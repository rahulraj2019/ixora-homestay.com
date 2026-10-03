<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Page;
use App\Models\Review;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        $page = Page::query()
            ->published()
            ->where('slug', 'home')
            ->with(['activeBlocks.activeItems'])
            ->firstOrFail();

        $faqs = $this->cachedFaqModels('faqs.home', fn () => Faq::query()->forHome()->limit(8)->get());

        $reviewData = $this->approvedReviews(6);

        return view('frontend.page', array_merge(
            compact('page', 'faqs'),
            $reviewData,
        ));
    }

    public function show(string $slug): View
    {
        if ($slug === 'home') {
            return $this->home();
        }

        $page = Page::query()
            ->published()
            ->where('slug', $slug)
            ->with(['activeBlocks.activeItems'])
            ->firstOrFail();

        $faqs = $this->faqsForPage($page);

        $reviewData = $this->isReviewsPage($page)
            ? $this->approvedReviews()
            : [];

        return view('frontend.page', array_merge(
            compact('page', 'faqs'),
            $reviewData,
        ));
    }

    /**
     * @return Collection<int, Faq>
     */
    private function faqsForPage(Page $page): Collection
    {
        $template = $page->template ?: $page->slug;

        if ($template !== 'faq' && $page->slug !== 'faq') {
            return collect();
        }

        return $this->cachedFaqModels('faqs.page', fn () => Faq::query()->forPage()->get());
    }

    private function isReviewsPage(Page $page): bool
    {
        $template = $page->template ?: $page->slug;

        return $template === 'reviews' || $page->slug === 'reviews';
    }

    /**
     * Cache FAQ rows as plain arrays so file/database cache never returns
     * incomplete Eloquent classes after deploys or opcode changes.
     *
     * @param  callable(): Collection<int, Faq>  $resolver
     * @return Collection<int, Faq>
     */
    private function cachedFaqModels(string $cacheKey, callable $resolver): Collection
    {
        $rows = Cache::remember($cacheKey, 600, function () use ($resolver) {
            return $resolver()
                ->map(fn (Faq $faq) => $faq->only(['id', 'question', 'answer', 'sort_order', 'status', 'show_on_home']))
                ->values()
                ->all();
        });

        if (! is_array($rows) || (isset($rows[0]) && ! is_array($rows[0]))) {
            Cache::forget($cacheKey);
            $rows = $resolver()
                ->map(fn (Faq $faq) => $faq->only(['id', 'question', 'answer', 'sort_order', 'status', 'show_on_home']))
                ->values()
                ->all();
            Cache::put($cacheKey, $rows, 600);
        }

        return collect($rows)->map(fn (array $row) => (new Faq)->newFromBuilder($row));
    }

    /**
     * @return array{reviews: Collection<int, Review>, reviewsAverage: float|null, reviewsCount: int}
     */
    private function approvedReviews(?int $limit = null): array
    {
        $cacheKey = $limit === null ? 'reviews.approved.all' : "reviews.approved.{$limit}";

        /** @var mixed $payload */
        $payload = Cache::remember($cacheKey, 300, function () use ($limit) {
            $all = Review::query()
                ->where('status', 'approved')
                ->latest()
                ->get(['name', 'location', 'rating', 'message', 'created_at']);

            $reviewsCount = $all->count();
            $reviewsAverage = $reviewsCount > 0
                ? round((float) $all->avg('rating'), 1)
                : null;

            $reviews = $limit !== null ? $all->take($limit)->values() : $all;

            return [
                'reviews' => $reviews
                    ->map(fn (Review $review) => [
                        'name' => $review->name,
                        'location' => $review->location,
                        'rating' => $review->rating,
                        'message' => $review->message,
                        'created_at' => optional($review->created_at)->toDateTimeString(),
                    ])
                    ->values()
                    ->all(),
                'reviewsAverage' => $reviewsAverage,
                'reviewsCount' => $reviewsCount,
            ];
        });

        if (
            ! is_array($payload)
            || ! isset($payload['reviews'])
            || ! is_array($payload['reviews'])
            || (isset($payload['reviews'][0]) && ! is_array($payload['reviews'][0]))
        ) {
            Cache::forget($cacheKey);

            $all = Review::query()
                ->where('status', 'approved')
                ->latest()
                ->get(['name', 'location', 'rating', 'message', 'created_at']);

            $reviewsCount = $all->count();
            $payload = [
                'reviews' => ($limit !== null ? $all->take($limit)->values() : $all)
                    ->map(fn (Review $review) => [
                        'name' => $review->name,
                        'location' => $review->location,
                        'rating' => $review->rating,
                        'message' => $review->message,
                        'created_at' => optional($review->created_at)->toDateTimeString(),
                    ])
                    ->values()
                    ->all(),
                'reviewsAverage' => $reviewsCount > 0
                    ? round((float) $all->avg('rating'), 1)
                    : null,
                'reviewsCount' => $reviewsCount,
            ];
            Cache::put($cacheKey, $payload, 300);
        }

        return [
            'reviews' => collect($payload['reviews'])
                ->map(fn (array $row) => (new Review)->newFromBuilder($row)),
            'reviewsAverage' => $payload['reviewsAverage'] ?? null,
            'reviewsCount' => $payload['reviewsCount'] ?? 0,
        ];
    }
}
