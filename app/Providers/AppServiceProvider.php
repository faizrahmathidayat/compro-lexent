<?php

namespace App\Providers;

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // One instance per request so the navbar and the product pages share a
        // single catalog-menu call.
        $this->app->singleton(\App\Services\CmsClient::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // The navbar appears on every page (including the CMS-driven ones), so its
        // dropdown data is supplied here instead of by each controller.
        View::composer('partials.navbar', function ($view) {
            $view->with('navMenu', app(PageController::class)->navigationMenu());
        });
    }
}
