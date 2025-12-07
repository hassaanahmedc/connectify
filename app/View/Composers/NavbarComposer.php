<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class NavbarComposer
{
    public function compose(View $view)
    {
        $user = Auth::user();
        $view->with([ 'navUser' => $user ]);
    }
}