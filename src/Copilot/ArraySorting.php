<?php

declare(strict_types = 1);

namespace Src\Copilot;

class ArraySorting
{
    public array $data = [];

    /**
     * Sorts the data array by a given column and direction.
     *
     * @param string $column
     * @param int $direction
     * @return array
     */
    public function sort(string $column = 'id', int $direction = SORT_ASC): array
    {
        $columnToSort = $column;

        if (!isset($this->data[0][$column])) {
            $columnToSort = 'id';
        }
        $data = $this->data;
        usort($data, function ($a, $b) use ($columnToSort, $direction) {
            $valA = $a[$columnToSort] ?? null;
            $valB = $b[$columnToSort] ?? null;

            if ($valA == $valB) {
                return 0;
            }

            if ($direction === SORT_DESC) {
                return ($valA < $valB) ? 1 : -1;
            }

            return ($valA < $valB) ? -1 : 1;
        });

        return $data;
    }
}
