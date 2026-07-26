<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\User;
use App\Repositories\UserRepositoryInterface;
use App\Support\Auth;
use DomainException;

final class AuthService
{
    public function __construct(
        private readonly UserRepositoryInterface $users,
        private readonly Auth $auth
    ) {
    }

    public function register(
        string $name,
        string $email,
        string $password,
        string $role = 'student'
    ): User {
        if ($this->users->findByEmail($email) instanceof User) {
            throw new DomainException('An account with this email already exists.');
        }

        $user = $this->users->create(
            name: trim($name),
            email: trim($email),
            passwordHash: password_hash($password, PASSWORD_DEFAULT),
            role: $role
        );

        $this->auth->login($user);

        return $user;
    }

    public function attempt(string $email, string $password): bool
    {
        $user = $this->users->findByEmail($email);

        if (!$user instanceof User || !password_verify($password, $user->passwordHash)) {
            return false;
        }

        $this->auth->login($user);

        return true;
    }
}
