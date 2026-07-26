<?php
$isEditing = $course !== null;
?>
<section class="form-panel wide">
    <h1><?= $isEditing ? 'Edit course' : 'Create course' ?></h1>

    <form method="post" action="<?= e($action) ?>" novalidate>
        <?= csrf_field() ?>

        <label for="title">Title</label>
        <input
            id="title"
            name="title"
            value="<?= old('title', $course?->title ?? '') ?>"
            maxlength="150"
            required
        >
        <?php if (isset($errors['title'])): ?>
            <p class="field-error"><?= e($errors['title']) ?></p>
        <?php endif; ?>

        <label for="description">Description</label>
        <textarea
            id="description"
            name="description"
            rows="9"
            maxlength="3000"
            required
        ><?= old('description', $course?->description ?? '') ?></textarea>
        <?php if (isset($errors['description'])): ?>
            <p class="field-error"><?= e($errors['description']) ?></p>
        <?php endif; ?>

        <label for="status">Status</label>
        <?php $selectedStatus = $oldInput['status'] ?? $course?->status ?? 'draft'; ?>
        <select id="status" name="status">
            <option value="draft" <?= $selectedStatus === 'draft' ? 'selected' : '' ?>>Draft</option>
            <option value="published" <?= $selectedStatus === 'published' ? 'selected' : '' ?>>Published</option>
        </select>

        <button class="button" type="submit">
            <?= $isEditing ? 'Save changes' : 'Create course' ?>
        </button>
    </form>
</section>
