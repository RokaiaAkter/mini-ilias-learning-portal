<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\CourseController;
use App\Controllers\DashboardController;
use App\Core\Database;
use App\Core\Router;
use App\Core\View;
use App\Repositories\PdoCourseRepository;
use App\Repositories\PdoEnrollmentRepository;
use App\Repositories\PdoUserRepository;
use App\Services\AuthService;
use App\Services\CourseService;
use App\Support\Auth;
use App\Support\Env;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

require dirname(__DIR__) . '/vendor/autoload.php';

Env::load(dirname(__DIR__) . '/.env');

$config = require dirname(__DIR__) . '/config/app.php';

session_start();

if ($config['app']['debug']) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
}

$logger = new Logger('mini-ilias');
$logger->pushHandler(new StreamHandler($config['logging']['path'], Level::Debug));

set_exception_handler(static function (Throwable $exception) use ($logger, $config): void {
    $logger->error($exception->getMessage(), [
        'exception' => $exception,
        'request_uri' => $_SERVER['REQUEST_URI'] ?? null,
    ]);

    http_response_code(500);

    View::render('errors/500', [
        'title' => 'Server error',
        'exception' => $config['app']['debug'] ? $exception : null,
    ]);
});

$database = new Database($config['db']);
$pdo = $database->connection();

$userRepository = new PdoUserRepository($pdo);
$courseRepository = new PdoCourseRepository($pdo);
$enrollmentRepository = new PdoEnrollmentRepository($pdo);

$auth = new Auth($userRepository);
$authService = new AuthService($userRepository, $auth);
$courseService = new CourseService($courseRepository, $enrollmentRepository);

$authController = new AuthController($authService, $auth);
$courseController = new CourseController(
    $courseService,
    $courseRepository,
    $enrollmentRepository,
    $auth,
    $logger
);
$dashboardController = new DashboardController(
    $courseRepository,
    $enrollmentRepository,
    $auth
);

$router = new Router();

require dirname(__DIR__) . '/routes/web.php';

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

$router->dispatch($method, $path);
