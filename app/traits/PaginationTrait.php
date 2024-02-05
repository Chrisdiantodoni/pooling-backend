<?php

namespace App\Traits;

trait PaginationTrait
{
    public static function getPaginationDetails($data)
    {
        return [
            'current_page' => $data->currentPage(),
            'first_page_url' => $data->url(1),
            'from' => $data->firstItem(),
            'last_page' => $data->lastPage(),
            'last_page_url' => $data->url($data->lastPage()),
            'links' => $data->links()->elements,
            'next_page_url' => $data->nextPageUrl(),
            'path' => $data->path(),
            'per_page' => $data->perPage(),
            'prev_page_url' => $data->previousPageUrl(),
            'to' => $data->lastItem(),
            'total' => $data->total(),
        ];
    }
}
