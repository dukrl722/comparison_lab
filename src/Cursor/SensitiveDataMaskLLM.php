<?php

declare(strict_types = 1);

namespace Src\Cursor;

use InvalidArgumentException;

class SensitiveDataMaskLLM
{
    public function generateMask(string $email): string
    {
        $this->validate($email);

        [$localPart, $domainPart] = explode('@', $email, 2);

        if (strlen($localPart) <= 2) {
            return "*$localPart***@$domainPart";
        }

        $localPartChars = str_split($localPart);
        $firstChar      = $localPartChars[0];
        $lastChar       = end($localPartChars);
        $maskLength     = strlen($localPart) - 2;
        $maskedPart     = $firstChar . str_repeat('*', $maskLength) . $lastChar;

        return "$maskedPart@$domainPart";
    }

    private function validate(string $email): void
    {
        if (
            (!str_contains($email, '@') || strpos($email, '@') === strlen($email) - 1)
            || !filter_var($email, FILTER_VALIDATE_EMAIL)
        ) {
            throw new InvalidArgumentException('Invalid email address provided.');
        }
    }
}
