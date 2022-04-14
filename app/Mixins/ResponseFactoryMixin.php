<?php

namespace App\Mixins;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ResponseFactoryMixin
{
    public function paginate(): Closure
    {
        return function (LengthAwarePaginator|Collection $paginatorOrCollection): JsonResponse {
            if ($paginatorOrCollection instanceof Collection) {
                return response()->json($paginatorOrCollection);
            }

            return response()->json([
                'pagination' => [
                    'current_page_items'  => $paginatorOrCollection->count(),
                    'current_page_number' => $paginatorOrCollection->currentPage(),
                    'last_page_number'    => $paginatorOrCollection->lastPage(),
                    'items_per_page'      => $paginatorOrCollection->perPage(),
                    'total_items'         => $paginatorOrCollection->total(),
                ],
                'data'       => $paginatorOrCollection->items(),
            ]);
        };
    }
}