<section class="form-panel">
    <h1>Login</h1>
    <form method="post" action="/login" novalidate>
        <?= csrf_field() ?>

        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="<?= old('email') ?>" required>
        <?php if (isset($errors['email'])): ?>
            <p class="field-error"><?= e($errors['email']) ?></p>
        <?php endif; ?>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>

        <button class="button" type="submit">Login</button>
    </form>

    <p class="hint">Demo password: <code>Password123!</code></p>
</section>
