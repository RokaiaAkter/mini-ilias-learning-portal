<?php

declare(strict_types=1);

namespace App\Support;

use App\Entities\User;
use App\Repositories\UserRepositoryInterface;

final class Auth
{
    private ?User $resolvedUser = null;

    public function __construct(private readonly UserRepositoryInterface $users)
    {
    }

    public function login(User $user): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->id;
        $this->resolvedUser = $user;
    }

    public function logout(): void
    {
        unset($_SESSION['user_id']);
        session_regenerate_id(true);
        $this->resolvedUser = null;
    }

    public function check(): bool
    {
        return $this->user() instanceof User;
    }

    public function user(): ?User
    {
        if ($this->resolvedUser instanceof User) {
            return $this->resolvedUser;
        }

        $id = $_SESSION['user_id'] ?? null;

        if (!is_int($id) && !ctype_digit((string) $id)) {
            return null;
        }

        $this->resolvedUser = $this->users->findById((int) $id);

        return $this->resolvedUser;
    }

    public function requireLogin(): User
    {
        $user = $this->user();

        if (!$user instanceof User) {
            flash('error', 'Please log in first.');
            redirect('/login');
        }

        return $user;
    }
}
