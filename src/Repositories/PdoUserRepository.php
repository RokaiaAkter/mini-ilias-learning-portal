<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\User;
use PDO;
use RuntimeException;

final class PdoUserRepository implements UserRepositoryInterface
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function findById(int $id): ?User
    {
        $statement = $this->pdo->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);
        $row = $statement->fetch();

        return is_array($row) ? User::fromRow($row) : null;
    }

    public function findByEmail(string $email): ?User
    {
        $statement = $this->pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $statement->execute(['email' => mb_strtolower($email)]);
        $row = $statement->fetch();

        return is_array($row) ? User::fromRow($row) : null;
    }

    public function create(string $name, string $email, string $passwordHash, string $role): User
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO users (name, email, password_hash, role)
             VALUES (:name, :email, :password_hash, :role)'
        );

        $statement->execute([
            'name' => $name,
            'email' => mb_strtolower($email),
            'password_hash' => $passwordHash,
            'role' => $role,
        ]);

        $user = $this->findById((int) $this->pdo->lastInsertId());

        if (!$user instanceof User) {
            throw new RuntimeException('The user was created but could not be loaded.');
        }

        return $user;
    }
}
