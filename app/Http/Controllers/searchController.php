<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Log;
use App\Services\SearchService;
use App\Http\Resources\search\UserSearchResource;
use App\Http\Resources\search\PostSearchResource;

class searchController extends Controller
{
    public function navSearch(SearchRequest $request, SearchService $SearchService)
    {
        Log::info('Incoming request headers', $request->headers->all());
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
            Log::info('Ajax REquest Recieved', ['request' => $request->ajax()]);
            $context = $request->header('X-Search-Context');

            if ($context === 'dropdown') {
                Log::info('Dropdown search', ['query' => $q, 'filters' => $filters]);
                $jsonResults = $results->map(function ($result) {

                    if ($result->type === 'user') {
                        return new UserSearchResource($result);
                        Log::info('Dropdown search user', ['query' => $q, 'filters' => $filters, 'user' => $result]);
                    };
                    return new PostSearchResource($result);
                    Log::info('Dropdown search post', ['query' => $q, 'filters' => $filters, 'post' => $result]);
                });
    
                return response()->json([ 'query' => $q, 'filters' => $filters, 'results' => $jsonResults ]);
            };
            Log::info('Results search', ['query' => $q, 'filters' => $filters]);

            $html = view('partials.search.search-results', compact('results'))->render();
            return response()->json(['query' => $q, 'filters' => $filters, 'html' => $html]);
        }
        Log::info('Results Page', ['query' => $q, 'filters' => $filters, 'results' => $results]);
        return view('results', compact('results'));
    }
}