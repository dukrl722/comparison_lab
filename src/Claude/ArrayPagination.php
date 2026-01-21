<?php

declare(strict_types = 1);

namespace Src\Claude;

class ArrayPagination
{
    public array $data = [];

    /**
     * Paginate an array with pagination metadata
     *
     * @param int $page Current page number (default: 1)
     * @param int $perPage Items per page (default: 10)
     * @return array Paginated data with pagination info
     */
    public function paginate(int $page = 1, int $perPage = 10): array
    {
        // Convert negative values to absolute values
        $page    = abs($page);
        $perPage = abs($perPage);

        // Ensure minimum values
        $page    = max(1, $page);
        $perPage = max(1, $perPage);

        $totalItems = count($this->data);
        $totalPages = (int) ceil($totalItems / $perPage);

        // Calculate offset for array slicing
        $offset = ($page - 1) * $perPage;

        // Get the paginated data
        $paginatedData = array_slice($this->data, $offset, $perPage);

        // Check if there's a next page
        $hasNextPage = $page < $totalPages;

        return [
            'data'       => $paginatedData,
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
