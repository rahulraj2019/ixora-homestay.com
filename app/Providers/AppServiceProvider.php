<?php

namespace App\Providers;

use App\Services\SettingsService;
use App\Services\SiteImageService;
use App\View\Composers\EmailBrandComposer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SettingsService::class);
        $this->app->singleton(SiteImageService::class);
    }

    public function boot(): void
    {
        $this->configureApplicationUrls();

        View::composer('admin.*', function () {
            Paginator::defaultView('vendor.pagination.admin');
            Paginator::defaultSimpleView('vendor.pagination.admin');
        });

        View::composer(['layouts.app', 'partials.*', 'frontend.*'], function ($view) {
            if (! isset($view->getData()['page'])) {
                $view->with('page', (object) [
                    'slug' => request()->route('slug') ?? (request()->routeIs('home') ? 'home' : null),
                    'title' => null,
                    'meta_title' => null,
                    'meta_description' => null,
                    'canonical_url' => null,
                    'robots' => 'index, follow',
                    'og_title' => null,
                    'og_description' => null,
                    'og_image' => null,
                    'twitter_title' => null,
                    'twitter_description' => null,
                    'twitter_image' => null,
                ]);
            }
        });

        View::composer(['emails.*', 'components.emails.*'], EmailBrandComposer::class);
    }

    /**
     * Force url()/asset()/route() to honor APP_URL (and optional ASSET_URL).
     * Needed for subdirectory installs (e.g. /Home) so CSS/JS/images do not
     * resolve to the web-server root when moving between local and live.
     */
    private function configureApplicationUrls(): void
    {
        $appUrl = config('app.url');

        if (! is_string($appUrl) || $appUrl === '') {
            return;
        }

        URL::useOrigin($appUrl);
        URL::useAssetOrigin(config('app.asset_url') ?: $appUrl);

        if (str_starts_with($appUrl, 'https://')) {
            URL::forceScheme('https');
        }
    }
}
