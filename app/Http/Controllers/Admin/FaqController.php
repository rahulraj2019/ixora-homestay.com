<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        $faqs = Faq::query()->ordered()->paginate(30);

        return view('admin.faqs.index', compact('faqs'));
    }

    public function create(): View
    {
        return view('admin.faqs.form', ['faq' => new Faq]);
    }

    public function store(Request $request, ActivityLogger $logger): RedirectResponse
    {
        $faq = Faq::query()->create($this->validated($request));
        forget_frontend_content_cache();
        $logger->log('faq.created', $faq);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created.');
    }

    public function edit(Faq $faq): View
    {
        return view('admin.faqs.form', compact('faq'));
    }

    public function update(Request $request, Faq $faq, ActivityLogger $logger): RedirectResponse
    {
        $faq->update($this->validated($request));
        forget_frontend_content_cache();
        $logger->log('faq.updated', $faq);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated.');
    }

    public function destroy(Faq $faq, ActivityLogger $logger): RedirectResponse
    {
        $logger->log('faq.deleted', $faq);
        $faq->delete();
        forget_frontend_content_cache();

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted.');
    }

    /**
     * @return array{question: string, answer: string, sort_order: int, status: string}
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        return $data;
    }
}
