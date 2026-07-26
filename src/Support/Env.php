<?php

declare(strict_types=1);

namespace App\Support;

final class Env
{
    public static function load(string $file): void
    {
        if (!is_file($file)) {
            return;
        }

        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($lines === false) {
            return;
        }

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                continue;
            }

            [$name, $value] = array_map('trim', explode('=', $line, 2));
            $value = trim($value, "\"'");

            if (getenv($name) === false) {
                putenv("{$name}={$value}");
                $_ENV[$name] = $value;
            }
        }
    }

    public static function get(string $name, string $default = ''): string
    {
        $value = getenv($name);
        return $value === false ? $default : $value;
    }

    public static function int(string $name, int $default): int
    {
        $value = getenv($name);
        return $value === false ? $default : (int) $value;
    }

    public static function bool(string $name, bool $default): bool
    {
        $value = getenv($name);

        if ($value === false) {
            return $default;
        }

        return filter_var($value, FILTER_VALIDATE_BOOL);
    }
}
