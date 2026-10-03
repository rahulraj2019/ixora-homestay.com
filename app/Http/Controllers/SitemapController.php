<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $pages = Page::query()
            ->published()
            ->orderBy('sort_order')
            ->get()
            ->filter(fn (Page $page) => $page->isIndexable());

        $xml = view('frontend.sitemap-xml', compact('pages'))->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
