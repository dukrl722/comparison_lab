<?php

declare(strict_types = 1);

namespace Src\Human;

class ArrayPagination
{
    public array $data;

    public function __construct()
    {
        $json       = file_get_contents(__DIR__ . '/../../data/ArrayPaginationData.json');
        $this->data = json_decode($json, true);
    }

    public function paginate(int $page = 1, int $perPage = 10): array
    {
        $page    = abs($page);
        $perPage = abs($perPage);

        if (!$totalItems = count($this->data)) {
            return [];
        }

        $hasNextPage = ($page * $perPage) < $totalItems;
        $totalPages  = (int) ceil($totalItems / $perPage);
        $page        = min($page, $totalPages);

        $arraySlice = array_slice($this->data, ($page - 1) * $perPage, $perPage);

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
