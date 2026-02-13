<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserDiscoveryService;
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

        return view('explore', compact('results'));
    }

    public function suggestions()
    {
        //
    }
    
}
