<?php

declare(strict_types = 1);

namespace Src\ChatGPT;

use InvalidArgumentException;

class SensitiveDataMask
{
    public function generateMask(string $email): string
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email address provided.');
        }

        [$localPart, $domain] = explode('@', $email);

        $length = strlen($localPart);

        if ($length === 1) {
            return '*a***@' . $domain;
        }

        if ($length === 2) {
            return $localPart[0] . '*@' . $domain;
        }

        $maskedLocalPart = $localPart[0]
            . str_repeat('*', $length - 2)
            . $localPart[$length - 1];

        return $maskedLocalPart . '@' . $domain;
    }
}
