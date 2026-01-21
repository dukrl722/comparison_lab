<?php

declare(strict_types = 1);

namespace Src\Claude;

use RuntimeException;

class ArrayFlat
{
    public array $data = [];

    /**
     * Group array in a hierarchical structure
     *
     * @return array
     * @throws RuntimeException
     */
    public function group(): array
    {
        if (empty($this->data)) {
            return [];
        }

        $this->validate();

        $indexed = [];
        $result  = [];

        // Index all items by ID
        foreach ($this->data as $item) {
            $id               = $item['id'];
            $item['children'] = [];
            $indexed[$id]     = $item;
        }

        // Build hierarchic
        foreach ($indexed as $id => $item) {
            $parentId = $item['parent_id'];

            if ($parentId === null) {
                // root
                $result[] = &$indexed[$id];
            } else {
                // child
                if (isset($indexed[$parentId])) {
                    $indexed[$parentId]['children'][] = &$indexed[$id];
                }
            }
        }

        return $result;
    }

    /**
     * Validate if dataset structure is correct
     *
     * @throws RuntimeException
     */
    private function validate(): void
    {
        $ids = [];

        foreach ($this->data as $item) {
            if (!isset($item['id'])) {
                throw new RuntimeException('Each item must have a unique "id" key.');
            }

            $id = $item['id'];

            if (in_array($id, $ids, true)) {
                throw new RuntimeException('Each item must have a unique "id" key.');
            }

            $ids[] = $id;
        }
    }
}
