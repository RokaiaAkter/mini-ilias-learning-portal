<?php

declare(strict_types=1);

namespace App\Support;

final class Csrf
{
    public static function token(): string
    {
        if (!isset($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['_csrf'];
    }

    public static function verify(?string $submittedToken): bool
    {
        $sessionToken = $_SESSION['_csrf'] ?? '';

        return is_string($submittedToken)
            && $sessionToken !== ''
            && hash_equals($sessionToken, $submittedToken);
    }
}
