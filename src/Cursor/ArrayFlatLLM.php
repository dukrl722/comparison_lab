<?php

declare(strict_types = 1);

namespace Src\Cursor;

use RuntimeException;

class ArrayFlatLLM
{
    public array $data = [];

    public function group(): array
    {
        if (empty($this->data)) {
            return [];
        }

        $this->validateData();

        // Create a map of all items by id for quick lookup
        $itemsMap = [];

        foreach ($this->data as $item) {
            $itemsMap[$item['id']]             = $item;
            $itemsMap[$item['id']]['children'] = [];
        }

        // Build the hierarchical structure
        $rootItems = [];

        foreach ($this->data as $item) {
            $parentId = $item['parent_id'];

            if ($parentId === null) {
                // This is a root item
                $rootItems[] = &$itemsMap[$item['id']];
            } else {
                // This is a child item - add it to its parent's children
                if (isset($itemsMap[$parentId])) {
                    $itemsMap[$parentId]['children'][] = &$itemsMap[$item['id']];
                }
            }
        }

        return $rootItems;
    }

    private function validateData(): void
    {
        $ids = [];

        foreach ($this->data as $item) {
            if (!isset($item['id'])) {
                throw new RuntimeException('Each item must have a unique "id" key.');
            }

            $id = $item['id'];

            if (isset($ids[$id])) {
                throw new RuntimeException('Each item must have a unique "id" key.');
            }

            $ids[$id] = true;
        }
    }
}
