<section class="page-heading">
    <div>
        <p class="eyebrow"><?= e(ucfirst($user->role)) ?> dashboard</p>
        <h1>Hello, <?= e($user->name) ?></h1>
    </div>
    <?php if ($user->canManageCourses()): ?>
        <a class="button" href="/courses/create">Create course</a>
    <?php endif; ?>
</section>

<section>
    <h2>My enrollments</h2>
    <div class="grid two">
        <?php foreach ($enrolledCourses as $course): ?>
            <article class="card">
                <h3><a href="/courses/show?id=<?= $course->id ?>"><?= e($course->title) ?></a></h3>
                <p><?= e($course->instructorName) ?></p>
            </article>
        <?php endforeach; ?>

        <?php if ($enrolledCourses === []): ?>
            <p>You have not joined a course yet.</p>
        <?php endif; ?>
    </div>
</section>

<?php if ($user->canManageCourses()): ?>
<section>
    <h2>Courses I teach</h2>
    <div class="grid two">
        <?php foreach ($authoredCourses as $course): ?>
            <article class="card">
                <p class="status"><?= e($course->status) ?></p>
                <h3><a href="/courses/show?id=<?= $course->id ?>"><?= e($course->title) ?></a></h3>
                <a href="/courses/edit?id=<?= $course->id ?>">Edit course</a>
            </article>
        <?php endforeach; ?>

        <?php if ($authoredCourses === []): ?>
            <p>You have not created a course yet.</p>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>
