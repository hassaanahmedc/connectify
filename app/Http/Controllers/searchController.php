<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Resources\Post\PostCardResource;
use App\Http\Resources\Search\PostSearchResource;
use App\Http\Resources\Search\UserSearchResource;
use App\Services\SearchService;

class searchController extends Controller
{
    public function navSearch(SearchRequest $request, SearchService $SearchService)
    {
        $data = $request->validated();
        $q = $data['q'];

        $filters = [
            'all' => $request->boolean('all'),
            'users' => $request->boolean('users'),
            'posts' => $request->boolean('posts'),
            'near' => $request->boolean('near'),
        ];

        if (! array_filter($filters)) {
            $filters['all'] = true;
        }
        $results = $SearchService->search($q, $filters);

        if ($request->ajax() || $request->wantsJson()) {
            $jsonResults = $results->map(function ($result) {
                return $result->type === 'user' 
                    ? new UserSearchResource($result)
                    : new PostCardResource($result);
            });

            return response()->json([
                'query' => $q,
                'filters' => $filters,
                'results' => $jsonResults,
            ]);
        }

        return view('results', compact('results'));
    }

    public function navSearchFilters($type)
    {
        //
    }
}