<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\UserDiscoveryService;
use App\Models\User;

class RightSideBarComposer
{
    protected $service;

    public function __construct(UserDiscoveryService $service)
    {
        $this->service = $service;
    }

    public function compose(View $view)
    {
        $user = Auth::user();

        $suggestions = $this->service->UserSuggestions($user);

        $view->with(['suggestions' => $suggestions]);
    }
}