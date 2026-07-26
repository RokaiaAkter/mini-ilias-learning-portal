<?php

declare(strict_types=1);

namespace App\Entities;

final readonly class Course
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public int $instructorId,
        public string $instructorName,
        public string $status,
        public string $createdAt
    ) {
    }

    /** @param array<string,mixed> $row */
    public static function fromRow(array $row): self
    {
        return new self(
            id: (int) $row['id'],
            title: (string) $row['title'],
            description: (string) $row['description'],
            instructorId: (int) $row['instructor_id'],
            instructorName: (string) ($row['instructor_name'] ?? ''),
            status: (string) $row['status'],
            createdAt: (string) $row['created_at']
        );
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }
}
