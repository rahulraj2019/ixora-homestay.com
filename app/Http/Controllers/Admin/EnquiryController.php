<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EnquiryController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $statuses = ['new' => 'New', 'pending' => 'Pending', 'contacted' => 'Contacted', 'closed' => 'Closed'];

        $statusCounts = [];
        foreach (array_keys($statuses) as $key) {
            $statusCounts[$key] = ContactEnquiry::query()->where('status', $key)->count();
        }
        $statusCounts['all'] = array_sum($statusCounts);

        $enquiries = ContactEnquiry::query()
            ->when(
                in_array($status, array_keys($statuses), true),
                fn ($query) => $query->where('status', $status),
            )
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.enquiries.index', compact('enquiries', 'status', 'statuses', 'statusCounts'));
    }

    public function show(ContactEnquiry $enquiry): View
    {
        return view('admin.enquiries.show', compact('enquiry'));
    }

    public function update(Request $request, ContactEnquiry $enquiry, ActivityLogger $logger): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:new,pending,contacted,closed'],
            'admin_notes' => ['nullable', 'string'],
        ]);

        $enquiry->update($data);
        $logger->log('enquiry.updated', $enquiry);

        return back()->with('success', 'Enquiry updated.');
    }

    public function destroy(ContactEnquiry $enquiry, ActivityLogger $logger): RedirectResponse
    {
        $logger->log('enquiry.deleted', $enquiry);
        $enquiry->delete();

        return redirect()->route('admin.enquiries.index')->with('success', 'Enquiry archived.');
    }
}
