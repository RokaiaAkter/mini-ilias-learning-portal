<section class="empty-state">
    <p class="eyebrow">500</p>
    <h1>Something went wrong</h1>
    <p>The error was written to <code>storage/logs/app.log</code>.</p>

    <?php if (isset($exception) && $exception !== null): ?>
        <pre><?= e($exception->getMessage()) ?></pre>
    <?php endif; ?>
</section>
