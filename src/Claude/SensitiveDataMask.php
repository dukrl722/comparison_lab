<?php

declare(strict_types = 1);

namespace Src\Claude;

use InvalidArgumentException;

class SensitiveDataMask
{
    /**
     * Generate a masked version of an email address
     *
     * @param string $email Email address to mask
     * @return string Masked email address
     * @throws InvalidArgumentException If email format is invalid
     */
    public function generateMask(string $email): string
    {
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email address provided.');
        }

        // Split email into local part and domain
        [$localPart, $domain] = explode('@', $email);

        $localLength = strlen($localPart);

        // Mask the local part based on its length
        if ($localLength === 1) {
            // For single character, add asterisks before it
            $maskedLocal = '*' . $localPart . '***';
        } elseif ($localLength === 2) {
            // For two characters, keep both and add asterisks between
            $maskedLocal = $localPart[0] . '**' . $localPart[1];
        } else {
            // For three or more characters, keep first and last, mask the middle
            $maskedLocal = $localPart[0] . str_repeat('*', $localLength - 2) . $localPart[$localLength - 1];
        }

        return $maskedLocal . '@' . $domain;
    }
}
