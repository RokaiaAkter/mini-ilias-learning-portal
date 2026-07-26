<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\Course;
use App\Entities\User;
use App\Repositories\CourseRepositoryInterface;
use App\Repositories\EnrollmentRepositoryInterface;
use DomainException;

final class CourseService
{
    public function __construct(
        private readonly CourseRepositoryInterface $courses,
        private readonly EnrollmentRepositoryInterface $enrollments
    ) {
    }

    public function create(
        User $actor,
        string $title,
        string $description,
        string $status
    ): int {
        if (!$actor->canManageCourses()) {
            throw new DomainException('You are not allowed to create courses.');
        }

        return $this->courses->create(
            title: trim($title),
            description: trim($description),
            instructorId: $actor->id,
            status: $status
        );
    }

    public function update(
        User $actor,
        Course $course,
        string $title,
        string $description,
        string $status
    ): void {
        $this->assertCanManage($actor, $course);

        $this->courses->update(
            id: $course->id,
            title: trim($title),
            description: trim($description),
            status: $status
        );
    }

    public function delete(User $actor, Course $course): void
    {
        $this->assertCanManage($actor, $course);
        $this->courses->delete($course->id);
    }

    public function enroll(User $actor, Course $course): void
    {
        if (!$course->isPublished()) {
            throw new DomainException('Only published courses can be joined.');
        }

        $this->enrollments->enroll($actor->id, $course->id);
    }

    private function assertCanManage(User $actor, Course $course): void
    {
        if (!$actor->isAdmin() && $course->instructorId !== $actor->id) {
            throw new DomainException('You may only manage your own courses.');
        }
    }
}
