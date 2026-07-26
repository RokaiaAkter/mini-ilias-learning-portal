<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Services\AuthService;
use App\Support\Auth;
use App\Support\Csrf;
use App\Support\Validator;
use DomainException;

final class AuthController
{
    public function __construct(
        private readonly AuthService $service,
        private readonly Auth $auth
    ) {
    }

    public function showRegister(): void
    {
        if ($this->auth->check()) {
            redirect('/dashboard');
        }

        View::render('auth/register', ['title' => 'Register']);
    }

    public function register(): void
    {
        if (!Csrf::verify($_POST['_token'] ?? null)) {
            http_response_code(419);
            exit('Invalid CSRF token.');
        }

        $data = [
            'name' => trim((string) ($_POST['name'] ?? '')),
            'email' => trim((string) ($_POST['email'] ?? '')),
            'password' => (string) ($_POST['password'] ?? ''),
        ];

        $_SESSION['old'] = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        $validator = new Validator();
        $valid = $validator->validate($data, [
            'name' => ['required', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:190'],
            'password' => ['required', 'min:8', 'max:200'],
        ]);

        if (!$valid) {
            $_SESSION['errors'] = $validator->errors();
            redirect('/register');
        }

        try {
            $this->service->register(
                $data['name'],
                $data['email'],
                $data['password']
            );
        } catch (DomainException $exception) {
            $_SESSION['errors'] = ['email' => $exception->getMessage()];
            redirect('/register');
        }

        unset($_SESSION['old'], $_SESSION['errors']);
        flash('success', 'Your account was created.');
        redirect('/dashboard');
    }

    public function showLogin(): void
    {
        if ($this->auth->check()) {
            redirect('/dashboard');
        }

        View::render('auth/login', ['title' => 'Login']);
    }

    public function login(): void
    {
        if (!Csrf::verify($_POST['_token'] ?? null)) {
            http_response_code(419);
            exit('Invalid CSRF token.');
        }

        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        if (!$this->service->attempt($email, $password)) {
            $_SESSION['old'] = ['email' => $email];
            $_SESSION['errors'] = ['email' => 'The email or password is incorrect.'];
            redirect('/login');
        }

        unset($_SESSION['old'], $_SESSION['errors']);
        flash('success', 'Welcome back.');
        redirect('/dashboard');
    }

    public function logout(): void
    {
        if (!Csrf::verify($_POST['_token'] ?? null)) {
            http_response_code(419);
            exit('Invalid CSRF token.');
        }

        $this->auth->logout();
        flash('success', 'You have been logged out.');
        redirect('/');
    }
}
