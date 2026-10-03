<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Booking;
use App\Models\ContactEnquiry;
use App\Models\Media;
use App\Models\Page;
use App\Models\Review;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $counts = [
            'total' => Booking::count(),
            'new' => Booking::where('status', 'new')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'pages' => Page::count(),
            'media' => Media::count(),
            'reviews_pending' => Review::where('status', 'pending')->count(),
            'reviews_total' => Review::count(),
            'enquiries_new' => ContactEnquiry::where('status', 'new')->count(),
            'enquiries_total' => ContactEnquiry::count(),
        ];

        $statCards = [
            [
                'label' => 'Total bookings',
                'value' => $counts['total'],
                'url' => route('admin.bookings.index'),
                'tone' => 'neutral',
            ],
            [
                'label' => 'New bookings',
                'value' => $counts['new'],
                'url' => route('admin.bookings.index', ['status' => 'new']),
                'tone' => 'info',
            ],
            [
                'label' => 'Pending bookings',
                'value' => $counts['pending'],
                'url' => route('admin.bookings.index', ['status' => 'pending']),
                'tone' => 'warn',
            ],
            [
                'label' => 'Confirmed',
                'value' => $counts['confirmed'],
                'url' => route('admin.bookings.index', ['status' => 'confirmed']),
                'tone' => 'ok',
            ],
            [
                'label' => 'Cancelled',
                'value' => $counts['cancelled'],
                'url' => route('admin.bookings.index', ['status' => 'cancelled']),
                'tone' => 'danger',
            ],
            [
                'label' => 'New enquiries',
                'value' => $counts['enquiries_new'],
                'url' => route('admin.enquiries.index'),
                'tone' => 'info',
            ],
            [
                'label' => 'Pending reviews',
                'value' => $counts['reviews_pending'],
                'url' => route('admin.reviews.index', ['status' => 'pending']),
                'tone' => 'warn',
            ],
            [
                'label' => 'All reviews',
                'value' => $counts['reviews_total'],
                'url' => route('admin.reviews.index'),
                'tone' => 'ok',
            ],
            [
                'label' => 'Pages',
                'value' => $counts['pages'],
                'url' => route('admin.pages.index'),
                'tone' => 'neutral',
            ],
            [
                'label' => 'Media files',
                'value' => $counts['media'],
                'url' => route('admin.media.index'),
                'tone' => 'neutral',
            ],
        ];

        $recentBookings = Booking::query()->latest()->limit(8)->get();
        $recentReviews = Review::query()->latest()->limit(8)->get();
        $recentEnquiries = ContactEnquiry::query()->latest()->limit(6)->get();
        $activity = ActivityLog::query()->with('user')->latest()->limit(10)->get();

        return view('admin.dashboard.index', compact(
            'counts',
            'statCards',
            'recentBookings',
            'recentReviews',
            'recentEnquiries',
            'activity',
        ));
    }
}
