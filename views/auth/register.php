<section class="form-panel">
    <h1>Create student account</h1>
    <form method="post" action="/register" novalidate>
        <?= csrf_field() ?>

        <label for="name">Name</label>
        <input id="name" name="name" value="<?= old('name') ?>" required>
        <?php if (isset($errors['name'])): ?>
            <p class="field-error"><?= e($errors['name']) ?></p>
        <?php endif; ?>

        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="<?= old('email') ?>" required>
        <?php if (isset($errors['email'])): ?>
            <p class="field-error"><?= e($errors['email']) ?></p>
        <?php endif; ?>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" minlength="8" required>
        <?php if (isset($errors['password'])): ?>
            <p class="field-error"><?= e($errors['password']) ?></p>
        <?php endif; ?>

        <button class="button" type="submit">Register</button>
    </form>
</section>
