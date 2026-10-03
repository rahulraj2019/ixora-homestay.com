<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageBlock;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PageBlockController extends Controller
{
    public function store(Request $request, Page $page, ActivityLogger $logger): RedirectResponse
    {
        $data = $request->validate([
            'block_type' => ['required', 'string', 'max:100'],
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'settings_json' => ['nullable', 'array'],
            'sort_order' => ['nullable', 'integer'],
            'status' => ['nullable', 'string', 'max:50'],
        ]);

        $data['status'] = $data['status'] ?? 'active';
        $data['sort_order'] = $data['sort_order'] ?? (($page->blocks()->max('sort_order') ?? 0) + 1);

        $block = $page->blocks()->create($data);
        $logger->log('page_block.created', $block, $data);

        return back()->with('success', 'Block added.');
    }

    public function update(Request $request, PageBlock $pageBlock, ActivityLogger $logger): RedirectResponse
    {
        $data = $request->validate([
            'block_type' => ['required', 'string', 'max:100'],
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'settings_json' => ['nullable', 'array'],
            'sort_order' => ['nullable', 'integer'],
            'status' => ['nullable', 'string', 'max:50'],
        ]);

        $pageBlock->update($data);
        $logger->log('page_block.updated', $pageBlock, $data);

        return back()->with('success', 'Block updated.');
    }

    public function destroy(PageBlock $pageBlock, ActivityLogger $logger): RedirectResponse
    {
        $logger->log('page_block.deleted', $pageBlock);
        $pageBlock->delete();

        return back()->with('success', 'Block deleted.');
    }
}
