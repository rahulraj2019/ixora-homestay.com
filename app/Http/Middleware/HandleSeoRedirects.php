<?php

namespace App\Http\Middleware;

use App\Models\SeoRedirect;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleSeoRedirects
{
    public function handle(Request $request, Closure $next): Response
    {
        $path = '/'.ltrim($request->getPathInfo(), '/');
        if ($path !== '/') {
            $path = rtrim($path, '/') ?: '/';
        }

        $redirect = SeoRedirect::query()
            ->where('is_active', true)
            ->where(function ($q) use ($path, $request) {
                $q->where('old_url', $path)
                    ->orWhere('old_url', $request->getPathInfo())
                    ->orWhere('old_url', $request->fullUrl());
            })
            ->first();

        if ($redirect) {
            return redirect($redirect->new_url, $redirect->type ?: 301);
        }

        return $next($request);
    }
}
