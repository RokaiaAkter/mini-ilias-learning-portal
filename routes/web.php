<?php

declare(strict_types=1);

use App\Core\View;

$router->get('/', static function () use ($auth): void {
    View::render('home', [
        'title' => 'Home',
        'user' => $auth->user(),
    ]);
});

$router->get('/register', [$authController, 'showRegister']);
$router->post('/register', [$authController, 'register']);
$router->get('/login', [$authController, 'showLogin']);
$router->post('/login', [$authController, 'login']);
$router->post('/logout', [$authController, 'logout']);

$router->get('/dashboard', [$dashboardController, 'index']);

$router->get('/courses', [$courseController, 'index']);
$router->get('/courses/show', [$courseController, 'show']);
$router->get('/courses/create', [$courseController, 'showCreate']);
$router->post('/courses/create', [$courseController, 'create']);
$router->get('/courses/edit', [$courseController, 'showEdit']);
$router->post('/courses/edit', [$courseController, 'update']);
$router->post('/courses/delete', [$courseController, 'delete']);
$router->post('/courses/enroll', [$courseController, 'enroll']);

$router->get('/api/courses', [$courseController, 'apiSearch']);
