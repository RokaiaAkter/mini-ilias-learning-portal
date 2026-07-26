# PHP concept map

Use this table to explain where each PHP concept appears.

| Concept | Project example |
|---|---|
| Variables and scalar types | `examples/php_basics.php` |
| Indexed and associative arrays | `examples/php_basics.php`, configuration arrays |
| Conditions and `match` | `examples/php_basics.php`, authorization checks |
| Loops | views and the basics example |
| Named functions | `src/Support/helpers.php` |
| Anonymous and arrow functions | `examples/php_basics.php`, `array_map` in repositories |
| Superglobals | `$_GET`, `$_POST`, `$_SESSION`, `$_SERVER` |
| Namespaces | every class below `src/` |
| Classes and objects | controllers, services, repositories and entities |
| Interfaces | repository interfaces |
| Inheritance | PHPUnit tests inherit from `TestCase` |
| Encapsulation | private dependencies and methods |
| Dependency injection | constructor arguments in controllers and services |
| Exceptions | database errors, domain rules and global handler |
| Typed properties and return types | all modern PHP classes |
| Nullable types | `?User`, `?Course`, `?PDO` |
| Readonly classes | `User` and `Course` entities |
| PDO | all `Pdo*Repository` classes |
| Sessions | login state, old form data and flash messages |
| Security | password hashing, CSRF, escaping, prepared statements |
| JSON API | `CourseController::apiSearch()` |
