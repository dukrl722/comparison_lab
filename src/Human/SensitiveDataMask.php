<?php

declare(strict_types = 1);

namespace Src\Human;

class SensitiveDataMask
{
    public function generateMask(string $email): string
    {
        $this->validate($email);

        [$localPart, $domainPart] = explode('@', $email, 2);

        if (strlen($localPart) <= 2) {
            return "*$localPart***@$domainPart";
        }

        $parts = str_split($localPart);

        $maskedPart = $parts[0] . str_repeat('*', strlen($localPart) - 2) . end($parts);

        return "$maskedPart@$domainPart";
    }

    private function validate(string $email): void
    {
        if (
            (!str_contains($email, '@') || strpos($email, '@') === strlen($email) - 1)
            || !filter_var($email, FILTER_VALIDATE_EMAIL)
        ) {
            throw new \InvalidArgumentException("Invalid email address provided.");
        }
    }
}
