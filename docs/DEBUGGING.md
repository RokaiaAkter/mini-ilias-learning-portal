# Debugging guide

## 1. Reproduce the problem

Write exact steps, expected result and actual result.

## 2. Read the visible error and logs

Development mode displays errors. Every uncaught exception is also written to:

```text
storage/logs/app.log
```

Follow it live:

```bash
tail -f storage/logs/app.log
```

## 3. Use temporary inspection carefully

```php
var_dump($variable);
die;
```

For cleaner debugging:

```php
error_log(json_encode($variable));
```

Remove temporary debugging statements before committing.

## 4. Xdebug with VS Code

Install the PHP Debug extension and Xdebug. Typical Xdebug 3 settings:

```ini
xdebug.mode=debug,develop
xdebug.start_with_request=yes
xdebug.client_port=9003
```

Restart PHP or the web server after changing `php.ini`.

Set a breakpoint in:

```text
src/Controllers/CourseController.php
```

Then submit the create-course form and inspect:

- request data
- current user
- validated values
- service call
- SQL repository call

## 5. Database debugging

Confirm the query independently:

```sql
SELECT c.*, u.name AS instructor_name
FROM courses c
JOIN users u ON u.id = c.instructor_id;
```

Check MySQL errors and confirm that the `.env` credentials match.

## 6. Request tracing exercise

Trace `GET /courses/show?id=1` through:

1. `public/router.php`
2. `public/index.php`
3. `routes/web.php`
4. `CourseController::show()`
5. `PdoCourseRepository::find()`
6. `views/courses/show.php`
7. `views/layout.php`

This same tracing habit is essential in a large system such as ILIAS.
