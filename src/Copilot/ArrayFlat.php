<?php

declare(strict_types = 1);

namespace Src\Copilot;

use RuntimeException;

class ArrayFlat
{
    public array $data = [];

    /**
     * Groups a flat array into a hierarchical structure based on 'id' and 'parent_id'.
     *
     * @return array
     */
    public function group(): array
    {
        if (empty($this->data)) {
            return [];
        }

        $items = [];

        foreach ($this->data as $item) {
            if (!isset($item['id'])) {
                throw new RuntimeException('Each item must have a unique "id" key.');
            }
            $item['children']   = [];
            $items[$item['id']] = $item;
        }

        $tree = [];

        foreach ($items as $id => &$item) {
            if (isset($item['parent_id']) && $item['parent_id'] !== null) {
                if (isset($items[$item['parent_id']])) {
                    $items[$item['parent_id']]['children'][] = &$item;
                }
            } else {
                $tree[] = &$item;
            }
        }
        unset($item);

        return $tree;
    }
}
