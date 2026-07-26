<?php

declare(strict_types=1);

use App\Support\Csrf;

if (!function_exists('e')) {
    function e(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('redirect')) {
    function redirect(string $path): never
    {
        header('Location: ' . $path);
        exit;
    }
}

if (!function_exists('old')) {
    function old(string $key, string $default = ''): string
    {
        return e((string) ($_SESSION['old'][$key] ?? $default));
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        return '<input type="hidden" name="_token" value="' . e(Csrf::token()) . '">';
    }
}

if (!function_exists('flash')) {
    function flash(string $type, string $message): void
    {
        $_SESSION['flash'][$type] = $message;
    }
}
