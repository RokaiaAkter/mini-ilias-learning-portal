<?php

declare(strict_types=1);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? 'MiniILIAS') ?> · MiniILIAS</title>
    <link rel="stylesheet" href="/assets/css/app.css">
    <script src="/assets/js/app.js" defer></script>
</head>
<body>
<header class="site-header">
    <div class="container nav-wrap">
        <a class="brand" href="/">MiniILIAS</a>
        <nav aria-label="Main navigation">
            <a href="/courses">Courses</a>
            <?php if (isset($user) && $user !== null): ?>
                <a href="/dashboard">Dashboard</a>
                <form class="inline-form" method="post" action="/logout">
                    <?= csrf_field() ?>
                    <button class="link-button" type="submit">Logout</button>
                </form>
            <?php else: ?>
                <a href="/login">Login</a>
                <a href="/register">Register</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="container">
    <?php foreach ($flashMessages as $type => $message): ?>
        <div class="alert alert-<?= e((string) $type) ?>">
            <?= e((string) $message) ?>
        </div>
    <?php endforeach; ?>

    <?= $content ?>
</main>

<footer class="site-footer">
    <div class="container">
        Built for PHP, MySQL and ILIAS interview preparation.
    </div>
</footer>
</body>
</html>
