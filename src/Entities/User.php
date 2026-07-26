<?php

declare(strict_types=1);

namespace App\Entities;

final readonly class User
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $passwordHash,
        public string $role
    ) {
    }

    /** @param array<string,mixed> $row */
    public static function fromRow(array $row): self
    {
        return new self(
            id: (int) $row['id'],
            name: (string) $row['name'],
            email: (string) $row['email'],
            passwordHash: (string) $row['password_hash'],
            role: (string) $row['role']
        );
    }

    public function canManageCourses(): bool
    {
        return in_array($this->role, ['admin', 'instructor'], true);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
