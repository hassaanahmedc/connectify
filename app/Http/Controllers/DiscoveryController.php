<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserDiscoveryService;
use Illuminate\Support\Str;
use App\Models\User;

class DiscoveryController extends Controller
{
    protected $service;

    public function __construct(UserDiscoveryService $service)
    {
        $this->service = $service;
    }


    public function explore(Request $request)
    {
        $user = $request->user();

        $results = $this->service->exploreUsers($user);

        $header_data = [
            'context' => 'Discovery',
            'title' => 'Explore Users',
            'count' => $results->total(),
            'label' => Str::plural('user', $results->total())
        ];

        return view('explore', compact('results', 'header_data'));
    }

    public function suggestions()
    {
        //
    }
    
}
