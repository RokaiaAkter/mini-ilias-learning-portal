<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Course;
use PDO;

final class PdoEnrollmentRepository implements EnrollmentRepositoryInterface
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function enroll(int $userId, int $courseId): void
    {
        $statement = $this->pdo->prepare(
            'INSERT IGNORE INTO enrollments (user_id, course_id)
             VALUES (:user_id, :course_id)'
        );
        $statement->execute([
            'user_id' => $userId,
            'course_id' => $courseId,
        ]);
    }

    public function isEnrolled(int $userId, int $courseId): bool
    {
        $statement = $this->pdo->prepare(
            'SELECT COUNT(*) FROM enrollments
             WHERE user_id = :user_id AND course_id = :course_id'
        );
        $statement->execute([
            'user_id' => $userId,
            'course_id' => $courseId,
        ]);

        return (int) $statement->fetchColumn() > 0;
    }

    public function coursesForUser(int $userId): array
    {
        $statement = $this->pdo->prepare(
            'SELECT c.*, u.name AS instructor_name
             FROM courses c
             INNER JOIN users u ON u.id = c.instructor_id
             INNER JOIN enrollments e ON e.course_id = c.id
             WHERE e.user_id = :user_id
             ORDER BY e.enrolled_at DESC'
        );
        $statement->execute(['user_id' => $userId]);

        return array_map(
            static fn (array $row): Course => Course::fromRow($row),
            $statement->fetchAll()
        );
    }
}
