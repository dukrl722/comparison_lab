<?php

declare(strict_types = 1);

use Src\Claude\ArrayPagination as ClaudeArrayPagination;
use Src\Copilot\ArrayPagination as CopilotArrayPagination;
use Src\Cursor\ArrayPaginationLLM as CursorArrayPagination;
use Src\Human\ArrayPagination as HumanArrayPagination;

beforeEach(function (): void {
    $json          = file_get_contents(__DIR__ . '/../Datasets/ArrayPaginationTest.json');
    $this->dataset = json_decode($json, true);
});

it('should paginate array correctly', function (string $className): void {
    $class = new $className();

    $class->data = $this->dataset;

    $arrayPaginated = $class->paginate(page: 2, perPage: 2);

    expect($arrayPaginated)->toBeArray()
        // new array generated
        ->and($arrayPaginated)->toHaveKey('data')
        ->and($arrayPaginated['data'])->toBeArray()
        ->and(count($arrayPaginated['data']))->toBe(2)
        ->and($arrayPaginated['data'][0]['id'])->toBe(3)
        ->and($arrayPaginated['data'][1]['id'])->toBe(4)
        // pagination info
        ->and($arrayPaginated)->toHaveKey('pagination')
        ->and($arrayPaginated['pagination'])->toBeArray()
        // pagination details
        ->and($arrayPaginated['pagination']['current_page'])->toBe(2)
        ->and($arrayPaginated['pagination']['per_page'])->toBe(2)
        ->and($arrayPaginated['pagination']['total_items'])->toBe(9)
        ->and($arrayPaginated['pagination']['total_pages'])->toBe(5)
        ->and($arrayPaginated['pagination']['has_next_page'])->toBeTrue();
})->with([
    HumanArrayPagination::class,
    CursorArrayPagination::class,
    ClaudeArrayPagination::class,
    CopilotArrayPagination::class,
]);

it('should paginate array when no params are passed', function (string $className): void {
    $class = new $className();

    $class->data = $this->dataset;

    $arrayPaginated = $class->paginate();

    expect($arrayPaginated)->toBeArray()
        // new array generated
        ->and($arrayPaginated)->toHaveKey('data')
        ->and($arrayPaginated['data'])->toBeArray()
        ->and(count($arrayPaginated['data']))->toBe(9)
        // pagination info
        ->and($arrayPaginated)->toHaveKey('pagination')
        ->and($arrayPaginated['pagination'])->toBeArray()
        // pagination details
        ->and($arrayPaginated['pagination']['current_page'])->toBe(1)
        ->and($arrayPaginated['pagination']['per_page'])->toBe(10)
        ->and($arrayPaginated['pagination']['total_items'])->toBe(9)
        ->and($arrayPaginated['pagination']['total_pages'])->toBe(1)
        ->and($arrayPaginated['pagination']['has_next_page'])->toBeFalse();
})->with([
    HumanArrayPagination::class,
    CursorArrayPagination::class,
    ClaudeArrayPagination::class,
    CopilotArrayPagination::class,
]);

it('should paginate using absolute values when paginate params are negative numbers', function (string $className): void {
    $class = new $className();

    $class->data = $this->dataset;

    $arrayPaginated = $class->paginate(page: -2, perPage: -3);

    var_dump($arrayPaginated);

    expect($arrayPaginated)->toBeArray()
        // new array generated
        ->and($arrayPaginated)->toHaveKey('data')
        ->and($arrayPaginated['data'])->toBeArray()
        ->and(count($arrayPaginated['data']))->toBe(3)
        ->and($arrayPaginated['data'][0]['id'])->toBe(4)
        ->and($arrayPaginated['data'][1]['id'])->toBe(5)
        ->and($arrayPaginated['data'][2]['id'])->toBe(6)
        // pagination info
        ->and($arrayPaginated)->toHaveKey('pagination')
        ->and($arrayPaginated['pagination'])->toBeArray()
        // pagination details
        ->and($arrayPaginated['pagination']['current_page'])->toBe(2)
        ->and($arrayPaginated['pagination']['per_page'])->toBe(3)
        ->and($arrayPaginated['pagination']['total_items'])->toBe(9)
        ->and($arrayPaginated['pagination']['total_pages'])->toBe(3)
        ->and($arrayPaginated['pagination']['has_next_page'])->toBeTrue();
})->with([
    HumanArrayPagination::class,
    CursorArrayPagination::class,
    ClaudeArrayPagination::class,
    CopilotArrayPagination::class,
]);
