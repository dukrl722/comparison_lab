<?php

declare(strict_types = 1);

namespace Src;

class ArrayFlat
{
    protected array $data;

    public function __construct()
    {
        $json = file_get_contents(__DIR__ . '/../data/ArrayFlatData.json');
        $this->data = json_decode($json, true);
    }

    public function group(): array
    {
        if (empty($this->data)) {
            return [];
        }

        $items = [];
        foreach ($this->data as $item) {
            if (!array_key_exists('id', $item) || is_null($item['id'])) {
                throw new \RuntimeException('Each item must have a unique "id" key.');
            }

            $item['children'] = [];
            $items[$item['id']] = $item;
        }

        $tree = [];

        foreach ($items as &$item) {
            if (is_null($item['parent_id'])) {
                $tree[] = &$item;

                continue;
            }

            $parentId = $item['parent_id'];

            if (isset($items[$parentId])) {
                $items[$parentId]['children'][] = &$item;
            }
        }

        unset($item);

        array_multisort(array_column($tree, 'id'), SORT_ASC, $tree);

        return $tree;
    }
}
