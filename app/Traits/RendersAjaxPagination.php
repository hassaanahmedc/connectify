<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

trait RendersAjaxPagination
{
    protected function renderAjaxPagination(Request $request, $paginator, string $viewName, string $dataKey)
    {
        if (!$request->ajax()) {
            return null;
        }

        $html = '';

        foreach ($paginator as $item) {
            $html .= view($viewName, [$dataKey => $item])->render();
        };

        return response()->json([
            'success' => true,
            'markup' => $html,
            'nextPageUrl' => $paginator->nextPageUrl(),
        ], 200);
    }
}
