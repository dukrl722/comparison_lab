<?php

declare(strict_types = 1);

namespace Src\Gemini;

use InvalidArgumentException;

class SensitiveDataMask
{
    /**
     * Generates a masked version of the provided email address.
     *
     * @param string $email The email address to mask.
     * @return string The masked email address.
     * @throws InvalidArgumentException If the email format is invalid.
     */
    public function generateMask(string $email): string
    {
        // 1. Validate Email Format
        // We use filter_var for standard compliance, but we also explicitly check for a dot
        // in the domain part to satisfy the test case rejecting 'test@com'.
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email address provided.');
        }

        $parts  = explode('@', $email);
        $domain = $parts[1];

        // explicit check to ensure domain contains a dot (e.g. reject 'test@com')
        if (!str_contains($domain, '.')) {
            throw new InvalidArgumentException('Invalid email address provided.');
        }

        $localPart = $parts[0];
        $length    = strlen($localPart);

        // 2. Apply Masking Logic based on length
        if ($length <= 1) {
            // Special case for very short usernames (e.g. 'a@...')
            // Output format: * + char + *** (e.g. '*a***')
            $maskedLocal = '*' . $localPart . '***';
        } else {
            // Standard case (e.g. 'test@...')
            // Keep first char, mask middle, keep last char.
            // Output format: t**t
            $first        = $localPart[0];
            $last         = $localPart[$length - 1];
            $maskedMiddle = str_repeat('*', $length - 2);

            $maskedLocal = $first . $maskedMiddle . $last;
        }

        return $maskedLocal . '@' . $domain;
    }
}
