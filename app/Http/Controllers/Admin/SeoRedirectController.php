<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoRedirect;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeoRedirectController extends Controller
{
    public function index(): View
    {
        $redirects = SeoRedirect::query()->latest()->paginate(30);

        return view('admin.seo.redirects', compact('redirects'));
    }

    public function store(Request $request, ActivityLogger $logger): RedirectResponse
    {
        $data = $request->validate([
            'old_url' => ['required', 'string', 'max:255'],
            'new_url' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:301,302'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        $redirect = SeoRedirect::query()->create($data);
        $logger->log('redirect.created', $redirect);

        return back()->with('success', 'Redirect created.');
    }

    public function update(Request $request, SeoRedirect $redirect, ActivityLogger $logger): RedirectResponse
    {
        $data = $request->validate([
            'old_url' => ['required', 'string', 'max:255'],
            'new_url' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:301,302'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $redirect->update($data);
        $logger->log('redirect.updated', $redirect);

        return back()->with('success', 'Redirect updated.');
    }

    public function destroy(SeoRedirect $redirect, ActivityLogger $logger): RedirectResponse
    {
        $logger->log('redirect.deleted', $redirect);
        $redirect->delete();

        return back()->with('success', 'Redirect deleted.');
    }
}
