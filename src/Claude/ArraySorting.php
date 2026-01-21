<?php

declare(strict_types = 1);

namespace Src\Claude;

class ArraySorting
{
    public array $data = [];

    /**
     * Sort an array by a specified column
     *
     * @param string $column Column name to sort by (default: 'id')
     * @param int $direction Sort direction SORT_ASC or SORT_DESC (default: SORT_ASC)
     * @return array Sorted array
     */
    public function sort(string $column = 'id', int $direction = SORT_ASC): array
    {
        if (empty($this->data)) {
            return [];
        }

        // Check if the column exists in the first item
        $columnExists = isset($this->data[0][$column]);

        // If column doesn't exist, fallback to 'id'
        if (!$columnExists) {
            $column = 'id';
        }

        // Extract the column values for sorting
        $sortColumn = array_column($this->data, $column);

        // Sort the array
        array_multisort($sortColumn, $direction, $this->data);

        return $this->data;
    }
}
