<?php

declare(strict_types = 1);

namespace Src\ChatGPT;

use RuntimeException;

class ArrayFlat
{
    public array $data = [];

    public function group(): array
    {
        if (empty($this->data)) {
            return [];
        }

        $itemsById = [];

        foreach ($this->data as $item) {
            if (!array_key_exists('id', $item)) {
                throw new RuntimeException('Each item must have a unique "id" key.');
            }

            if (isset($itemsById[$item['id']])) {
                throw new RuntimeException('Each item must have a unique "id" key.');
            }

            $item['children']       = [];
            $itemsById[$item['id']] = $item;
        }

        $tree = [];

        foreach ($itemsById as $id => &$item) {
            $parentId = $item['parent_id'] ?? null;

            if ($parentId === null) {
                $tree[] = &$item;

                continue;
            }

            if (!isset($itemsById[$parentId])) {
                continue;
            }

            $itemsById[$parentId]['children'][] = &$item;
        }

        return $tree;
    }
}
