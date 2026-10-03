<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlockItem;
use App\Models\PageBlock;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BlockItemController extends Controller
{
    public function store(Request $request, PageBlock $block, ActivityLogger $logger): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:180'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'link' => ['nullable', 'string', 'max:255'],
            'button_label' => ['nullable', 'string', 'max:80'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'extra_json' => ['nullable', 'array'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $max = (int) $block->items()->max('sort_order');
        $item = $block->items()->create([...$data, 'sort_order' => $max + 1]);
        $logger->log('block_item.created', $item);

        return back()->with('success', 'Item added.');
    }

    public function update(Request $request, BlockItem $item, ActivityLogger $logger): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:180'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'link' => ['nullable', 'string', 'max:255'],
            'button_label' => ['nullable', 'string', 'max:80'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'extra_json' => ['nullable', 'array'],
            'status' => ['required', 'in:active,inactive'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $item->update($data);
        $logger->log('block_item.updated', $item);

        return back()->with('success', 'Item updated.');
    }

    public function destroy(BlockItem $item, ActivityLogger $logger): RedirectResponse
    {
        $logger->log('block_item.deleted', $item);
        $item->delete();

        return back()->with('success', 'Item deleted.');
    }

    public function duplicate(BlockItem $item, ActivityLogger $logger): RedirectResponse
    {
        $copy = $item->replicate();
        $copy->title = ($item->title ?: 'Item').' (copy)';
        $copy->sort_order = ((int) $item->block->items()->max('sort_order')) + 1;
        $copy->save();
        $logger->log('block_item.duplicated', $copy);

        return back()->with('success', 'Item duplicated.');
    }
}
