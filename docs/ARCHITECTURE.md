# Architecture walkthrough

```text
HTTP Request
    |
    v
public/router.php
    |
    v
public/index.php  --- Composer autoload + configuration + dependency wiring
    |
    v
routes/web.php
    |
    v
Controller  --- reads HTTP input and chooses response
    |
    v
Service     --- enforces business rules
    |
    v
Repository  --- executes prepared SQL through PDO
    |
    v
MySQL

Controller
    |
    v
View -> HTML -> CSS + JavaScript -> Browser
```

## Example: create a course

1. Browser submits `POST /courses/create`.
2. Router calls `CourseController::create()`.
3. Controller requires login and verifies the CSRF token.
4. Validator checks title, description and status.
5. `CourseService` verifies that the user may create courses.
6. `PdoCourseRepository` runs an `INSERT` prepared statement.
7. Monolog records the event.
8. The response redirects to the new course page.

## Why this separation matters

- HTTP concerns stay in controllers.
- Business decisions stay in services.
- SQL stays in repositories.
- Data shape stays in entities.
- HTML stays in views.
- Cross-cutting helpers such as authentication, validation and CSRF stay under `Support`.

A large application such as ILIAS has its own architecture and conventions, but this separation trains the same code-reading question: “Which component is responsible for this behaviour?”
