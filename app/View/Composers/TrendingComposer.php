<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\TrendingService;
use App\Models\Topic;

class TrendingComposer
{
    public function __construct(protected TrendingService $trendingService)
    {
        //
    }

    public function compose(View $view)
    {
        $view->with(['topics' => $this->trendingService->getTopTopics()]);
    }
}