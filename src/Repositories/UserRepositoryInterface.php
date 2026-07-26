<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\User;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function create(string $name, string $email, string $passwordHash, string $role): User;
}
