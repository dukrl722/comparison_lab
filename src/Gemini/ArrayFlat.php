<?php

declare(strict_types = 1);

namespace Src\Gemini;

use RuntimeException;

class ArrayFlat
{
    /**
     * The flat input array.
     * @var array<int, array<string, mixed>>
     */
    public array $data = [];

    /**
     * Groups the flat array into a hierarchical tree structure.
     *
     * @return array
     * @throws RuntimeException If an item is missing the "id" key.
     */
    public function group(): array
    {
        if (empty($this->data)) {
            return [];
        }

        $refs = [];
        $tree = [];

        // First pass: Index items by ID and initialize 'children'
        // We use references to modify the array in place later
        foreach ($this->data as &$item) {
            if (!array_key_exists('id', $item)) {
                throw new RuntimeException('Each item must have a unique "id" key.');
            }

            $item['children']  = [];
            $refs[$item['id']] = &$item;
        }
        unset($item); // Break the reference to the last element

        // Second pass: Build the tree
        foreach ($this->data as &$item) {
            $parentId = $item['parent_id'] ?? null;

            // If parent exists in our references, add this item to the parent's children
            if ($parentId !== null && isset($refs[$parentId])) {
                $refs[$parentId]['children'][] = &$item;
            } else {
                // Otherwise, it is a root node
                $tree[] = &$item;
            }
        }
        unset($item); // Break reference

        return $tree;
    }
}
