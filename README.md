# MiniILIAS Learning Portal

A small PHP/MySQL learning-management project designed to practise the concepts needed to discuss and navigate a large PHP LMS such as ILIAS.

## Features

- Student, instructor and administrator roles
- Registration, login, logout and PHP sessions
- Course list, search, create, update and delete
- Student enrollment
- AJAX course search returning JSON
- PDO prepared statements
- OOP with entities, controllers, services, repositories and interfaces
- Composer PSR-4 autoloading
- Monolog file logging
- PHPUnit example tests
- CSRF protection, escaping and validation
- Linux setup notes, Git workflow and Xdebug configuration
- An ILIAS comparison and code-navigation guide

## Requirements

- PHP 8.2 or newer
- Composer
- MySQL 8 or MariaDB
- PDO MySQL extension
- Optional: Xdebug 3

## Quick start

```bash
git clone <your-repository-url>
cd mini-ilias-learning-portal
cp .env.example .env
composer install
```

Create the database:

```bash
mysql -u root -p < database/schema.sql
mysql -u root -p mini_ilias < database/seed.sql
```

Edit `.env` with your database credentials, then run:

```bash
composer serve
```

Open `http://localhost:8000`.

## Demo accounts

All seeded accounts use the password:

```text
Password123!
```

- `admin@example.com`
- `instructor@example.com`
- `student@example.com`

## Recommended study order

1. `examples/php_basics.php`
2. `public/index.php`
3. `routes/web.php`
4. `src/Core/Router.php`
5. `src/Controllers/CourseController.php`
6. `src/Services/CourseService.php`
7. `src/Repositories/PdoCourseRepository.php`
8. `database/schema.sql`
9. `views/`
10. `docs/ILIAS_COMPARISON.md`

## Main architecture

```text
Browser
  -> Router
  -> Controller
  -> Service
  -> Repository
  -> PDO / MySQL

Controller
  -> View
  -> HTML/CSS/JavaScript
```

This is intentionally much smaller than ILIAS. The purpose is to make architectural responsibilities visible and easy to explain in an interview.
