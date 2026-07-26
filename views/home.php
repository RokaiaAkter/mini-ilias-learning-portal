<section class="hero">
    <p class="eyebrow">Learning management system practice project</p>
    <h1>Understand PHP by building a small LMS.</h1>
    <p>
        Practise routing, controllers, services, repositories, PDO, MySQL,
        sessions, security, JavaScript and role-based actions.
    </p>
    <div class="actions">
        <a class="button" href="/courses">Browse courses</a>
        <?php if (!isset($user) || $user === null): ?>
            <a class="button button-secondary" href="/register">Create account</a>
        <?php endif; ?>
    </div>
</section>

<section class="grid three">
    <article class="card">
        <h2>PHP and OOP</h2>
        <p>Typed classes, interfaces, dependency injection, validation and reusable functions.</p>
    </article>
    <article class="card">
        <h2>Database</h2>
        <p>MySQL relationships, indexes, PDO prepared statements and CRUD operations.</p>
    </article>
    <article class="card">
        <h2>ILIAS comparison</h2>
        <p>Relate this small architecture to ILIAS modules, services, plugins and repository objects.</p>
    </article>
</section>
