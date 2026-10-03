<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $statusCounts = [
            'pending' => Review::query()->where('status', 'pending')->count(),
            'approved' => Review::query()->where('status', 'approved')->count(),
            'rejected' => Review::query()->where('status', 'rejected')->count(),
        ];
        $statusCounts['all'] = array_sum($statusCounts);

        $reviews = Review::query()
            ->when(
                in_array($status, ['pending', 'approved', 'rejected'], true),
                fn ($query) => $query->where('status', $status),
            )
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.reviews.index', compact('reviews', 'status', 'statusCounts'));
    }

    public function update(Request $request, Review $review, ActivityLogger $logger): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);
        $review->update($data);
        Cache::forget('schema_approved_reviews');
        forget_frontend_content_cache();
        $logger->log('review.updated', $review);

        return back()->with('success', 'Review updated.');
    }

    public function destroy(Review $review, ActivityLogger $logger): RedirectResponse
    {
        $logger->log('review.deleted', $review);
        $review->delete();
        Cache::forget('schema_approved_reviews');
        forget_frontend_content_cache();

        return back()->with('success', 'Review deleted.');
    }
}
