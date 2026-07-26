<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

final class View
{
    /**
     * @param array<string,mixed> $data
     */
    public static function render(string $template, array $data = []): void
    {
        $viewsPath = dirname(__DIR__, 2) . '/views';
        $templatePath = $viewsPath . '/' . $template . '.php';

        if (!is_file($templatePath)) {
            throw new RuntimeException("View not found: {$template}");
        }

        $data['errors'] ??= $_SESSION['errors'] ?? [];
        $data['oldInput'] ??= $_SESSION['old'] ?? [];
        $data['flashMessages'] ??= $_SESSION['flash'] ?? [];

        extract($data, EXTR_SKIP);

        ob_start();
        require $templatePath;
        $content = (string) ob_get_clean();

        unset($_SESSION['errors'], $_SESSION['old'], $_SESSION['flash']);

        require $viewsPath . '/layout.php';
    }
}
