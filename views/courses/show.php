<article class="course-detail">
    <p class="eyebrow"><?= e($course->status) ?> course</p>
    <h1><?= e($course->title) ?></h1>
    <p class="muted">Instructor: <?= e($course->instructorName) ?></p>
    <div class="prose"><?= nl2br(e($course->description)) ?></div>

    <div class="actions">
        <?php if ($user !== null && ($user->isAdmin() || $user->id === $course->instructorId)): ?>
            <a class="button" href="/courses/edit?id=<?= $course->id ?>">Edit</a>

            <form method="post" action="/courses/delete" onsubmit="return confirm('Delete this course?')">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= $course->id ?>">
                <button class="button button-danger" type="submit">Delete</button>
            </form>
        <?php elseif ($user !== null && !$isEnrolled): ?>
            <form method="post" action="/courses/enroll">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= $course->id ?>">
                <button class="button" type="submit">Join course</button>
            </form>
        <?php elseif ($isEnrolled): ?>
            <span class="badge">Enrolled</span>
        <?php else: ?>
            <a class="button" href="/login">Login to join</a>
        <?php endif; ?>
    </div>
</article>
