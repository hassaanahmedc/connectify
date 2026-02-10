<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DiscoveryController extends Controller
{
    public function explore(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        $results = User::where('id', '!=', $user->id)
                    ->whereNotIn('id', $user->following()->pluck('id'))
                    ->orderByRaw('location = ? DESC', [$user->location])
                    ->paginate(15);

        // return response()->json(['success' => true, 'results' => $results ]);
        return view('explore', compact('results'));
    }

    public function suggestions()
    {
        //
    }
    
}
