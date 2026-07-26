<?php

declare(strict_types=1);

namespace App\Core;

use Closure;

final class Router
{
    /** @var array<string, array<string, callable|array{object,string}>> */
    private array $routes = [];

    public function get(string $path, callable|array $handler): void
    {
        $this->add('GET', $path, $handler);
    }

    public function post(string $path, callable|array $handler): void
    {
        $this->add('POST', $path, $handler);
    }

    public function add(string $method, string $path, callable|array $handler): void
    {
        $this->routes[$method][$path] = $handler;
    }

    public function dispatch(string $method, string $path): void
    {
        $handler = $this->routes[$method][$path] ?? null;

        if ($handler === null) {
            http_response_code(404);
            View::render('errors/404', ['title' => 'Page not found']);
            return;
        }

        if ($handler instanceof Closure) {
            $handler();
            return;
        }

        [$controller, $action] = $handler;
        $controller->{$action}();
    }
}
