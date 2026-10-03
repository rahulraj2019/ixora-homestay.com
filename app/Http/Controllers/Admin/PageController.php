<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageBlock;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        $pages = Page::query()->orderBy('sort_order')->orderBy('title')->paginate(20);

        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.pages.form', ['page' => new Page]);
    }

    public function store(Request $request, ActivityLogger $logger): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $page = Page::query()->create($data);
        $logger->log('page.created', $page);

        return redirect()->route('admin.pages.edit', $page)->with('success', 'Page created.');
    }

    public function edit(Page $page): View
    {
        $page->load(['blocks.items']);

        return view('admin.pages.form', compact('page'));
    }

    public function update(Request $request, Page $page, ActivityLogger $logger): RedirectResponse
    {
        $data = $this->validated($request, $page->id);
        $page->update($data);
        forget_frontend_content_cache($page->slug);
        $logger->log('page.updated', $page);

        return back()->with('success', 'Page updated.');
    }

    public function destroy(Page $page, ActivityLogger $logger): RedirectResponse
    {
        $logger->log('page.deleted', $page);
        $page->delete();
        forget_frontend_content_cache($page->slug);

        return redirect()->route('admin.pages.index')->with('success', 'Page deleted.');
    }

    public function storeBlock(Request $request, Page $page, ActivityLogger $logger): RedirectResponse
    {
        $data = $request->validate([
            'block_type' => ['required', 'string', 'max:60'],
            'title' => ['nullable', 'string', 'max:180'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $max = (int) $page->blocks()->max('sort_order');
        $block = $page->blocks()->create([...$data, 'sort_order' => $max + 1]);
        $logger->log('block.created', $block);

        return back()->with('success', 'Block added.');
    }

    public function updateBlock(Request $request, PageBlock $block, ActivityLogger $logger): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:180'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'settings_json' => ['nullable', 'array'],
            'status' => ['required', 'in:active,inactive'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $block->update($data);
        $logger->log('block.updated', $block);

        return back()->with('success', 'Block updated.');
    }

    public function destroyBlock(PageBlock $block, ActivityLogger $logger): RedirectResponse
    {
        $logger->log('block.deleted', $block);
        $block->delete();

        return back()->with('success', 'Block deleted.');
    }

    public function reorderBlocks(Request $request, Page $page): RedirectResponse
    {
        $order = $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['integer'],
        ])['order'];

        foreach ($order as $index => $id) {
            PageBlock::query()->where('page_id', $page->id)->where('id', $id)->update(['sort_order' => $index]);
        }

        return back()->with('success', 'Blocks reordered.');
    }

    protected function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:180', 'unique:pages,slug,'.($ignoreId ?: 'NULL').',id,deleted_at,NULL'],
            'status' => ['required', 'in:published,draft'],
            'template' => ['nullable', 'string', 'max:60'],
            'meta_title' => ['nullable', 'string', 'max:180'],
            'meta_description' => ['nullable', 'string', 'max:320'],
            'canonical_url' => ['nullable', 'url', 'max:255'],
            'robots' => ['nullable', 'string', 'max:60'],
            'og_title' => ['nullable', 'string', 'max:180'],
            'og_description' => ['nullable', 'string', 'max:320'],
            'og_image' => ['nullable', 'string', 'max:255'],
            'twitter_title' => ['nullable', 'string', 'max:180'],
            'twitter_description' => ['nullable', 'string', 'max:320'],
            'twitter_image' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
