<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Course;

interface CourseRepositoryInterface
{
    /** @return list<Course> */
    public function allVisibleTo(?int $userId, bool $canManageAll): array;

    /** @return list<Course> */
    public function search(string $query): array;

    /** @return list<Course> */
    public function authoredBy(int $userId): array;

    public function find(int $id): ?Course;

    public function create(string $title, string $description, int $instructorId, string $status): int;

    public function update(int $id, string $title, string $description, string $status): void;

    public function delete(int $id): void;
}
