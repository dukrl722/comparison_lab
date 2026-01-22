<?php

declare(strict_types = 1);

namespace Src\ChatGPT;

class ArrayPagination
{
    public array $data = [];

    public function paginate(int $page = 1, int $perPage = 10): array
    {
        $page    = abs($page);
        $perPage = abs($perPage);

        if ($page === 0) {
            $page = 1;
        }

        if ($perPage === 0) {
            $perPage = 10;
        }

        $totalItems = count($this->data);
        $totalPages = (int) ceil($totalItems / $perPage);

        $offset = ($page - 1) * $perPage;

        $paginatedData = array_slice($this->data, $offset, $perPage);

        return [
            'data'       => array_values($paginatedData),
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
