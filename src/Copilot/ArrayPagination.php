<?php

declare(strict_types = 1);

namespace Src\Copilot;

class ArrayPagination
{
    public array $data = [];

    /**
     * Paginates the data array.
     *
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public function paginate(int $page = 1, int $perPage = 10): array
    {
        $page    = abs($page);
        $perPage = abs($perPage);
        $page    = $page > 0 ? $page : 1;
        $perPage = $perPage > 0 ? $perPage : 10;

        $totalItems = count($this->data);
        $totalPages = (int) ceil($totalItems / ($perPage > 0 ? $perPage : 1));
        $offset     = ($page - 1) * $perPage;
        $data       = array_slice($this->data, $offset, $perPage);

        return [
            'data'       => $data,
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
