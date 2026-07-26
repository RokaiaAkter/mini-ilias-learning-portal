# Interview questions and project-based answers

## What happens when a user opens `/courses`?

The built-in web server forwards the request to `public/index.php`. The bootstrap creates dependencies, loads routes and dispatches the path. `CourseController::index()` asks the repository for visible courses and renders the view. The browser receives HTML, CSS and JavaScript.

## Why use a service layer?

The service contains business rules independent of HTTP. For example, only an instructor or administrator may create a course. This makes rules reusable and easier to test.

## Why use repository interfaces?

Controllers and services depend on a contract rather than PDO details. A test can replace a PDO repository with an in-memory implementation.

## How is SQL injection prevented?

User values are passed through PDO prepared statements. They are not concatenated into SQL strings.

## How is cross-site scripting reduced?

Dynamic text is escaped with `htmlspecialchars()` through the `e()` helper. The JavaScript renderer also treats data as text before inserting it.

## Why use CSRF tokens?

A token stored in the session must match the hidden form token. This helps prevent another site from submitting authenticated state-changing requests.

## What does Composer do here?

Composer checks dependencies, installs Monolog and PHPUnit, creates the `vendor/` directory and generates PSR-4 autoloading for the `App` namespace.

## How would you debug a blank page?

Enable development error reporting, inspect the PHP/web-server log, reproduce the request, set an Xdebug breakpoint, inspect input and object state, run the SQL separately, and compare the current code with Git history.

## How does this relate to ILIAS?

Both involve an LMS domain, PHP, persistence, permissions, server-rendered UI, JavaScript and modular responsibilities. ILIAS is far more complex and has its own component, UI, setup, database and plugin APIs, so I would follow its established architecture rather than directly copying this small MVC structure.
