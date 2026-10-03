<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class RobotsController extends Controller
{
    public function __invoke(): Response
    {
        $sitemap = url('/sitemap.xml');
        $content = <<<TXT
User-agent: *
Allow: /

Disallow: /admin
Disallow: /admin/
Disallow: /login

# Prefer canonical public pages
Sitemap: {$sitemap}
TXT;

        return response($content, 200)
            ->header('Content-Type', 'text/plain; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }
}
