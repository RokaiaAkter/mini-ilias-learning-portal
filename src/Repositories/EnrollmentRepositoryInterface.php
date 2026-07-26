<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Course;

interface EnrollmentRepositoryInterface
{
    public function enroll(int $userId, int $courseId): void;

    public function isEnrolled(int $userId, int $courseId): bool;

    /** @return list<Course> */
    public function coursesForUser(int $userId): array;
}
