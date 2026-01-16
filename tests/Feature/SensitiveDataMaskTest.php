<?php

declare(strict_types = 1);

use Src\Cursor\SensitiveDataMaskLLM as CursorSensitiveDataMask;
use Src\Human\SensitiveDataMask;

it('should create a masked version of sensitive email data', function (string $className): void {
    $class = new $className();

    $maskedData = $class->generateMask('test@email.com');

    expect($maskedData)->toBe('t**t@email.com');

    $maskedData = $class->generateMask('a@email.com');

    expect($maskedData)->toBe('*a***@email.com');
})->with([
    SensitiveDataMask::class,
    CursorSensitiveDataMask::class,
]);

it('should return an exception when email has an invalid format', function (string $className, string $invalidMailFormat): void {
    $class = new $className();

    $class->generateMask($invalidMailFormat);
})
    ->throws(InvalidArgumentException::class, 'Invalid email address provided.')
    ->with([
        [SensitiveDataMask::class, 'test_mail.com'],
        [SensitiveDataMask::class, 'test@'],
        [SensitiveDataMask::class, 'test@com'],
        [CursorSensitiveDataMask::class, 'test_mail.com'],
        [CursorSensitiveDataMask::class, 'test@'],
        [CursorSensitiveDataMask::class, 'test@com'],
    ]);
