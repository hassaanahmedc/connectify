<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Topic;

class LeftSideBarComposer
{
    public function compose(View $view)
    {
        $user = Auth::user();
        if ($user) {
            $user->loadCount(['followers', 'following']);
        }

        $view->with('sidebarUser', $user);
        $view->with('topics', Topic::select('id', 'slug', 'name')->get());
    } 
}