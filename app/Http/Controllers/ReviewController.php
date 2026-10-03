<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(): JsonResponse
    {
        $reviews = Review::query()
            ->where('status', 'approved')
            ->latest()
            ->limit(50)
            ->get(['name', 'location', 'rating', 'message', 'created_at']);

        $avg = round((float) Review::query()->where('status', 'approved')->avg('rating'), 1);
        $count = Review::query()->where('status', 'approved')->count();

        return response()->json([
            'ok' => true,
            'reviews' => $reviews,
            'average' => $avg,
            'count' => $count,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'email' => ['required', 'email', 'max:120'],
            'location' => ['required', 'string', 'max:100'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'message' => ['required', 'string', 'min:10', 'max:800'],
            'website' => ['nullable', 'max:0'],
        ]);

        unset($data['website']);

        Review::query()->create([
            ...$data,
            'status' => 'pending',
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'Thank you! Your review was submitted and will appear after approval.',
        ]);
    }
}
