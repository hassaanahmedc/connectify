<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\View\Composers\NavbarComposer;
use App\View\Composers\RightSideBarComposer;
use App\View\Composers\LeftSideBarComposer;
use App\View\Composers\TrendingComposer;
use App\Models\Topic;

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
        View::composer('components.left-sidebar', LeftSideBarComposer::class);
        View::composer([
            'components.right-sidebar',
            'components.nav.mobile-sidebar'
            ], TrendingComposer::class);
        view::composer([
            'components.modals.post-modal', 
            'components.modals.topics-selection-modal'
            ], function($view) {
                $view->with('topics', Topic::select('id', 'slug', 'name')->get());
        });
    }
}
