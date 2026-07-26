<section class="page-heading">
    <div>
        <p class="eyebrow">Repository-style course list</p>
        <h1>Courses</h1>
    </div>
    <?php if (isset($user) && $user !== null && $user->canManageCourses()): ?>
        <a class="button" href="/courses/create">Create course</a>
    <?php endif; ?>
</section>

<label for="course-search">Live course search</label>
<input
    id="course-search"
    type="search"
    placeholder="Search title or description"
    data-course-search
>
<p class="hint">This field calls the PHP JSON API with JavaScript.</p>

<div class="grid two" data-course-results>
    <?php foreach ($courses as $course): ?>
        <article class="card">
            <p class="status"><?= e($course->status) ?></p>
            <h2><a href="/courses/show?id=<?= $course->id ?>"><?= e($course->title) ?></a></h2>
            <p><?= e(mb_strimwidth($course->description, 0, 160, '…')) ?></p>
            <p class="muted">Instructor: <?= e($course->instructorName) ?></p>
        </article>
    <?php endforeach; ?>
</div>
