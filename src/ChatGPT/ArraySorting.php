<?php

declare(strict_types = 1);

namespace Src\ChatGPT;

class ArraySorting
{
    public array $data = [];

    public function sort(string $column = 'id', int $direction = SORT_ASC): array
    {
        if (empty($this->data)) {
            return [];
        }

        // Fallback to "id" if column does not exist
        if (!array_key_exists($column, $this->data[0])) {
            $column = 'id';
        }

        $sorted = $this->data;

        usort($sorted, function (array $a, array $b) use ($column, $direction) {
            $valueA = $a[$column];
            $valueB = $b[$column];

            if ($valueA === $valueB) {
                return 0;
            }

            if ($direction === SORT_DESC) {
                return $valueA < $valueB ? 1 : -1;
            }

            return $valueA < $valueB ? -1 : 1;
        });

        return array_values($sorted);
    }
}
