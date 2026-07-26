# Completion checklist

## Phase 1 — Run and understand
- [ ] Install PHP, Composer and MySQL
- [ ] Import the schema and seed data
- [ ] Start the app
- [ ] Log in with all three roles
- [ ] Trace `/courses` from route to SQL to view

## Phase 2 — Modify
- [ ] Add a `category` column to courses
- [ ] Update the entity, form, validation and repository
- [ ] Add a category filter to the JSON API
- [ ] Commit the feature on a Git branch

## Phase 3 — Test and debug
- [ ] Run `composer lint`
- [ ] Run `composer test`
- [ ] Add a failing validation test, then fix it
- [ ] Set an Xdebug breakpoint
- [ ] Read and explain one Monolog entry

## Phase 4 — ILIAS navigation
- [ ] Clone the official ILIAS repository
- [ ] Locate `composer.json`, `package.json`, `components/ILIAS` and `docs`
- [ ] Identify one module and one service
- [ ] Identify one plugin slot
- [ ] Follow one visible feature through GUI, service, persistence and template code
- [ ] Prepare a two-minute comparison explanation
