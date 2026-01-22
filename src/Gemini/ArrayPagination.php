<?php

declare(strict_types = 1);

namespace Src\Gemini;

class ArrayPagination
{
    /**
     * The input dataset to be paginated.
     * @var array
     */
    public array $data = [];

    /**
     * Paginates the current dataset.
     *
     * @param int $page The current page number (defaults to 1).
     * @param int $perPage The number of items per page (defaults to 10).
     * @return array An array containing the 'data' subset and 'pagination' metadata.
     */
    public function paginate(int $page = 1, int $perPage = 10): array
    {
        // Handle negative numbers (absolute value) and ensure minimum value is 1
        $page    = max(1, abs($page));
        $perPage = max(1, abs($perPage));

        $totalItems = count($this->data);

        // Calculate total pages, ensuring at least 1 page exists if needed,
        // though strictly 0 items = 0 pages is often valid,
        // the test implies logic compatible with standard ceil calculation.
        $totalPages = (int) ceil($totalItems / $perPage);

        // Handle case where total items is 0 to avoid division issues or logic errors,
        // though ceil handles 0 fine (result 0).
        // We ensure total_pages is at least 1 based on Test 2 expectations
        // (9 items, per_page 10 -> total_pages 1).
        $totalPages = $totalPages < 1 ? 1 : $totalPages;

        // Calculate the starting offset
        $offset = ($page - 1) * $perPage;

        // Slice the array to get the specific items for this page
        $currentData = array_slice($this->data, $offset, $perPage);

        return [
            'data'       => $currentData,
            'pagination' => [
                'current_page'  => $page,
                'per_page'      => $perPage,
                'total_items'   => $totalItems,
                'total_pages'   => $totalPages,
                'has_next_page' => $page < $totalPages,
            ],
        ];
    }
}
