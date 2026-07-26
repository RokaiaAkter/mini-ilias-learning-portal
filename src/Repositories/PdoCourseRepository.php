<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Course;
use PDO;

final class PdoCourseRepository implements CourseRepositoryInterface
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function allVisibleTo(?int $userId, bool $canManageAll): array
    {
        if ($canManageAll) {
            $sql = $this->baseSelect() . ' ORDER BY c.created_at DESC';
            $statement = $this->pdo->query($sql);
        } elseif ($userId !== null) {
            $sql = $this->baseSelect() . '
                WHERE c.status = "published"
                   OR EXISTS (
                       SELECT 1 FROM enrollments e
                       WHERE e.course_id = c.id AND e.user_id = :user_id
                   )
                ORDER BY c.created_at DESC';
            $statement = $this->pdo->prepare($sql);
            $statement->execute(['user_id' => $userId]);
        } else {
            $sql = $this->baseSelect() . '
                WHERE c.status = "published"
                ORDER BY c.created_at DESC';
            $statement = $this->pdo->query($sql);
        }

        return array_map(
            static fn (array $row): Course => Course::fromRow($row),
            $statement->fetchAll()
        );
    }

    public function search(string $query): array
    {
        $statement = $this->pdo->prepare(
            $this->baseSelect() . '
             WHERE c.status = "published"
               AND (c.title LIKE :query OR c.description LIKE :query)
             ORDER BY c.title'
        );
        $statement->execute(['query' => '%' . $query . '%']);

        return array_map(
            static fn (array $row): Course => Course::fromRow($row),
            $statement->fetchAll()
        );
    }

    public function authoredBy(int $userId): array
    {
        $statement = $this->pdo->prepare(
            $this->baseSelect() . '
             WHERE c.instructor_id = :user_id
             ORDER BY c.created_at DESC'
        );
        $statement->execute(['user_id' => $userId]);

        return array_map(
            static fn (array $row): Course => Course::fromRow($row),
            $statement->fetchAll()
        );
    }

    public function find(int $id): ?Course
    {
        $statement = $this->pdo->prepare(
            $this->baseSelect() . ' WHERE c.id = :id LIMIT 1'
        );
        $statement->execute(['id' => $id]);
        $row = $statement->fetch();

        return is_array($row) ? Course::fromRow($row) : null;
    }

    public function create(
        string $title,
        string $description,
        int $instructorId,
        string $status
    ): int {
        $statement = $this->pdo->prepare(
            'INSERT INTO courses (title, description, instructor_id, status)
             VALUES (:title, :description, :instructor_id, :status)'
        );
        $statement->execute([
            'title' => $title,
            'description' => $description,
            'instructor_id' => $instructorId,
            'status' => $status,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function update(
        int $id,
        string $title,
        string $description,
        string $status
    ): void {
        $statement = $this->pdo->prepare(
            'UPDATE courses
             SET title = :title, description = :description, status = :status
             WHERE id = :id'
        );
        $statement->execute([
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'status' => $status,
        ]);
    }

    public function delete(int $id): void
    {
        $statement = $this->pdo->prepare('DELETE FROM courses WHERE id = :id');
        $statement->execute(['id' => $id]);
    }

    private function baseSelect(): string
    {
        return 'SELECT c.*, u.name AS instructor_name
                FROM courses c
                INNER JOIN users u ON u.id = c.instructor_id';
    }
}
