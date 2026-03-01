<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\View\Composers\NavbarComposer;
use App\View\Composers\RightSideBarComposer;
use App\View\Composers\TrendingComposer;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('components.nav.index', NavbarComposer::class);
        View::composer('components.right-sidebar-friends', RightSideBarComposer::class);
        View::composer('components.right-sidebar', TrendingComposer::class);
    }
}
