<?php

declare(strict_types = 1);

use Src\Claude\SensitiveDataMask as ClaudeSensitiveDataMask;
use Src\Copilot\SensitiveDataMask as CopilotSensitiveDataMask;
use Src\Cursor\SensitiveDataMaskLLM as CursorSensitiveDataMask;
use Src\Human\SensitiveDataMask as HumanSensitiveDataMask;

it('should create a masked version of sensitive email data', function (string $className): void {
    $class = new $className();

    $maskedData = $class->generateMask('test@email.com');

    expect($maskedData)->toBe('t**t@email.com');

    $maskedData = $class->generateMask('a@email.com');

    expect($maskedData)->toBe('*a***@email.com');
})->with([
    HumanSensitiveDataMask::class,
    CursorSensitiveDataMask::class,
    ClaudeSensitiveDataMask::class,
    CopilotSensitiveDataMask::class,
]);

it('should return an exception when email has an invalid format', function (string $className, string $invalidMailFormat): void {
    $class = new $className();

    $class->generateMask($invalidMailFormat);
})
    ->throws(InvalidArgumentException::class, 'Invalid email address provided.')
    ->with([
        [HumanSensitiveDataMask::class, 'test_mail.com'],
        [HumanSensitiveDataMask::class, 'test@'],
        [HumanSensitiveDataMask::class, 'test@com'],
        [CursorSensitiveDataMask::class, 'test_mail.com'],
        [CursorSensitiveDataMask::class, 'test@'],
        [CursorSensitiveDataMask::class, 'test@com'],
        [ClaudeSensitiveDataMask::class, 'test_mail.com'],
        [ClaudeSensitiveDataMask::class, 'test@'],
        [ClaudeSensitiveDataMask::class, 'test@com'],
        [CopilotSensitiveDataMask::class, 'test_mail.com'],
        [CopilotSensitiveDataMask::class, 'test@'],
        [CopilotSensitiveDataMask::class, 'test@com'],
    ]);
