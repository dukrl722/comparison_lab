<?php

declare(strict_types = 1);

namespace Src\Cursor;

class ArrayPaginationLLM
{
    public array $data = [];

    public function paginate(int $page = 1, int $perPage = 10): array
    {
        // Convert negative numbers to absolute values
        $page    = abs($page);
        $perPage = abs($perPage);

        $totalItems = count($this->data);

        // If no data, return empty result
        if ($totalItems === 0) {
            return [];
        }

        // Calculate total pages
        $totalPages = (int) ceil($totalItems / $perPage);

        // Cap page at total pages if it exceeds
        $page = min($page, $totalPages);

        // Ensure page is at least 1
        if ($page < 1) {
            $page = 1;
        }

        // Calculate offset
        $offset = ($page - 1) * $perPage;

        // Get the slice of data
        $arraySlice = array_slice($this->data, $offset, $perPage);

        // Determine if there's a next page
        $hasNextPage = ($page * $perPage) < $totalItems;

        return [
            'data'       => $arraySlice,
            'pagination' => [
                'current_page'  => $page,
                'per_page'      => $perPage,
                'total_items'   => $totalItems,
                'total_pages'   => $totalPages,
                'has_next_page' => $hasNextPage,
            ],
        ];
    }
}
