<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
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

        if ($request->ajax()) {
            $html = view('partials.search.search-results', compact('results'))->render();

            return response()->json([
                'query' => $q,
                'filters' => $filters,
                'html' => $html,
            ]);
        }

        return view('results', compact('results'));
    }

    public function navSearchFilters($type)
    {
        //
    }
}
