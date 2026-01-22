<?php

declare(strict_types = 1);

use Src\ChatGPT\ArrayFlat as ChatGPTArrayFlat;
use Src\Claude\ArrayFlat as ClaudeArrayFlat;
use Src\Copilot\ArrayFlat as CopilotArrayFlat;
use Src\Cursor\ArrayFlatLLM as CursorArrayFlat;
use Src\Gemini\ArrayFlat as GeminiArrayFlat;
use Src\Human\ArrayFlat as HumanArrayFlat;

it('should group flat array into hierarchical structure', function (string $className): void {
    $json    = file_get_contents(__DIR__ . '/../Datasets/ArrayFlatTest.json');
    $dataset = json_decode($json, true);

    $class = new $className();

    $class->data = $dataset;

    $grouped = $class->group();

    // father
    expect($grouped)->toBeArray()
        ->and(count($grouped))->toBeGreaterThan(0)
        ->and($grouped[0])->toHaveKey('children')
        ->and($grouped[0]['children'])->toBeArray()
        ->and(count($grouped[0]['children']))->toBe(2)
        // child 1
        ->and($grouped[0]['children'])->toBeArray()
        ->and($grouped[0]['children'][0])->toHaveKey('children')
        ->and($grouped[0]['children'][0]['children'])->toBeArray()
        ->and(count($grouped[0]['children'][0]['children']))->toBe(1)
        // child 2
        ->and($grouped[0]['children'][1])->toHaveKey('children')
        ->and($grouped[0]['children'][1]['children'])->toBe([]);
})->with([
    HumanArrayFlat::class,
    CursorArrayFlat::class,
    ClaudeArrayFlat::class,
    CopilotArrayFlat::class,
    ChatGPTArrayFlat::class,
    GeminiArrayFlat::class,
]);

it('should return an empty array when data is empty', function (string $className): void {
    $class = new $className();

    $class->data = [];

    $grouped = $class->group();

    expect($grouped)->toBeArray()->toBe([]);
})->with([
    HumanArrayFlat::class,
    CursorArrayFlat::class,
    ClaudeArrayFlat::class,
    CopilotArrayFlat::class,
    ChatGPTArrayFlat::class,
    GeminiArrayFlat::class,
]);

it('should return an exception when dataset is incorrect', function (string $className): void {
    $class = new $className();

    $class->data = [
        ['id' => 1, 'parent_id' => null, 'name' => 'Item 1'],
        ['parent_id' => 1, 'name' => 'Item 2'],
    ];

    $class->group();
})
    ->throws(RuntimeException::class, 'Each item must have a unique "id" key.')
    ->with([
        HumanArrayFlat::class,
        CursorArrayFlat::class,
        ClaudeArrayFlat::class,
        CopilotArrayFlat::class,
        ChatGPTArrayFlat::class,
        GeminiArrayFlat::class,
    ]);
