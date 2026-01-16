<?php

declare(strict_types = 1);

namespace Src\Cursor;

class ArraySortingLLM
{
    public array $data = [];

    public function sort(?string $column = null, int $direction = SORT_ASC): array
    {
        $data = $this->data;

        // If column is null or empty, default to 'id'
        if ($column === null || $column === '') {
            $column = 'id';
        }

        // Check if column exists in at least one item
        $columnExists = false;

        foreach ($data as $item) {
            if (isset($item[$column])) {
                $columnExists = true;

                break;
            }
        }

        // If column doesn't exist, fall back to 'id'
        if (!$columnExists) {
            $column = 'id';
        }

        // Extract the values for sorting
        $sortColumn = [];

        foreach ($data as $key => $item) {
            $sortColumn[$key] = $item[$column] ?? null;
        }

        // Sort the data array based on the sort column
        if ($direction === SORT_DESC) {
            array_multisort($sortColumn, SORT_DESC, $data);
        } else {
            array_multisort($sortColumn, SORT_ASC, $data);
        }

        return $data;
    }
}
