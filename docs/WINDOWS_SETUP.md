# Windows 11 setup

## Recommended learning setup

Use:

- VS Code
- PHP 8.2 or newer
- Composer
- MySQL or MariaDB
- PHP extensions: PDO MySQL and mbstring
- Optional: Xdebug 3

XAMPP can provide Apache, PHP and MariaDB. Composer should still be installed separately so that the `composer` command is available in PowerShell.

## Check tools in PowerShell

```powershell
php -v
php -m
composer --version
mysql --version
git --version
```

Confirm that `pdo_mysql` and `mbstring` appear in:

```powershell
php -m
```

## Prepare the project

```powershell
Copy-Item .env.example .env
composer install
```

Create and seed the database:

```powershell
mysql -u root -p < database/schema.sql
mysql -u root -p mini_ilias < database/seed.sql
```

PowerShell can handle input redirection differently depending on the shell. When necessary, run the commands from Command Prompt or import both SQL files with phpMyAdmin.

Update `.env`, then run:

```powershell
composer serve
```

Open:

```text
http://localhost:8000
```

## XAMPP alternative

Place the project anywhere; the Composer development server does not require the project to be inside `htdocs`.

When using Apache instead, point the virtual host document root to:

```text
mini-ilias-learning-portal/public
```

Do not expose the project root as the web document root because `.env`, source code and SQL files should not be public.
