<?php

declare(strict_types = 1);

namespace Src\Human;

class ArraySorting
{
    public array $data;

    public function __construct()
    {
        $json       = file_get_contents(__DIR__ . '/../../data/ArraySortingData.json');
        $this->data = json_decode($json, true);
    }

    public function sort(string $column = 'id', int $direction = SORT_ASC): array
    {
        foreach ($this->data as $item) {
            if (!array_key_exists($column, $item)) {
                $column = 'id';

                break;
            }
        }

        usort($this->data, function (array $a, array $b) use ($column, $direction) {
            $result = $a[$column] <=> $b[$column];

            return $direction === SORT_ASC ? $result : -$result;
        });

        return $this->data;
    }
}
