<?php

declare(strict_types = 1);

use Src\Cursor\ArraySortingLLM as CursorArraySorting;
use Src\Human\ArraySorting as HumanArraySorting;

beforeEach(function (): void {
    $json          = file_get_contents(__DIR__ . '/../Datasets/ArraySortingTest.json');
    $this->dataset = json_decode($json, true);
});

it('should sort by name asc correctly', function (string $className): void {
    $class = new $className();

    $class->data = $this->dataset;

    $arraySorting = $class->sort('name');

    expect($arraySorting)->toBeArray()
        ->and($arraySorting[0]['name'])->toBe('Computers')
        ->and($arraySorting[1]['name'])->toBe('Desktops')
        ->and($arraySorting[2]['name'])->toBe('Electronics')
        ->and($arraySorting[3]['name'])->toBe('Laptops')
        ->and($arraySorting[4]['name'])->toBe('Smartphones');
})->with([
    HumanArraySorting::class,
    CursorArraySorting::class,
]);

it('should sort by name desc correctly', function (string $className): void {
    $class = new $className();

    $class->data = $this->dataset;

    $arraySorting = $class->sort('name', SORT_DESC);

    expect($arraySorting)->toBeArray()
        ->and($arraySorting[0]['name'])->toBe('Smartphones')
        ->and($arraySorting[1]['name'])->toBe('Laptops')
        ->and($arraySorting[2]['name'])->toBe('Electronics')
        ->and($arraySorting[3]['name'])->toBe('Desktops')
        ->and($arraySorting[4]['name'])->toBe('Computers');
})->with([
    HumanArraySorting::class,
    CursorArraySorting::class,
]);

it('should sort by id asc correctly', function (string $className): void {
    $class = new $className();

    $class->data = $this->dataset;

    $arraySorting = $class->sort();

    expect($arraySorting)->toBeArray()
        ->and($arraySorting[0]['id'])->toBe(1)
        ->and($arraySorting[1]['id'])->toBe(2)
        ->and($arraySorting[2]['id'])->toBe(3)
        ->and($arraySorting[3]['id'])->toBe(4)
        ->and($arraySorting[4]['id'])->toBe(5);
})->with([
    HumanArraySorting::class,
    CursorArraySorting::class,
]);

it('should sort by id desc correctly', function (string $className): void {
    $class = new $className();

    $class->data = $this->dataset;

    $arraySorting = $class->sort('id', SORT_DESC);

    expect($arraySorting)->toBeArray()
        ->and($arraySorting[0]['id'])->toBe(5)
        ->and($arraySorting[1]['id'])->toBe(4)
        ->and($arraySorting[2]['id'])->toBe(3)
        ->and($arraySorting[3]['id'])->toBe(2)
        ->and($arraySorting[4]['id'])->toBe(1);
})->with([
    HumanArraySorting::class,
    CursorArraySorting::class,
]);

it('should sort by id if column does not exists', function (string $className): void {
    $class = new $className();

    $class->data = $this->dataset;

    $arraySorting = $class->sort(column: 'invalid_column');

    expect($arraySorting)->toBeArray()
        ->and($arraySorting[0]['id'])->toBe(1)
        ->and($arraySorting[1]['id'])->toBe(2)
        ->and($arraySorting[2]['id'])->toBe(3)
        ->and($arraySorting[3]['id'])->toBe(4)
        ->and($arraySorting[4]['id'])->toBe(5);
})->with([
    HumanArraySorting::class,
    CursorArraySorting::class,
]);
