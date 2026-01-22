<?php

declare(strict_types = 1);

namespace Src\Gemini;

class ArraySorting
{
    /**
     * The dataset to be sorted.
     * @var array
     */
    public array $data = [];

    /**
     * Sorts the dataset based on a specific column and direction.
     *
     * @param string $column The column to sort by (defaults to 'id').
     * @param int $direction The sort direction (SORT_ASC or SORT_DESC).
     * @return array The sorted array.
     */
    public function sort(string $column = 'id', int $direction = SORT_ASC): array
    {
        if (empty($this->data)) {
            return [];
        }

        // Check if the requested column exists in the first item.
        // If not, fall back to sorting by 'id' in ascending order.
        $firstItem = reset($this->data);

        if (!array_key_exists($column, $firstItem)) {
            $column    = 'id';
            $direction = SORT_ASC;
        }

        // Create a copy of the data to avoid modifying the property directly if not desired,
        // though the tests primarily check the return value.
        $sortedData = $this->data;

        // Extract the column values to use as the sorting key
        $columns = array_column($sortedData, $column);

        // Perform the sort
        // We use $columns as the sort key, and apply that order to $sortedData
        array_multisort($columns, $direction, $sortedData);

        return $sortedData;
    }
}
