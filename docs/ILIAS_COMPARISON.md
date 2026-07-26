# MiniILIAS to ILIAS comparison

This project is a teaching model, not an ILIAS clone.

## Concept mapping

| MiniILIAS | Comparable ILIAS idea |
|---|---|
| Course entity and course pages | Repository objects such as courses |
| `CourseController` | Request/UI command handling |
| `CourseService` | Reusable application/domain service |
| Repository interfaces | Database-access abstraction |
| `views/` | HTML templates and UI rendering |
| Router table | Entry point and request dispatching |
| Student/instructor/admin checks | ILIAS permission and role concepts |
| Enrollment table | Membership/assignment relationship |
| Composer autoload | Dependency and class loading |
| JavaScript AJAX search | Client-side behaviour calling server endpoints |
| `storage/logs/app.log` | Application/server logs used during troubleshooting |

## Important differences

- ILIAS is a mature, very large open-source LMS.
- ILIAS divides functionality into components, especially modules and services.
- ILIAS supports plugin slots; plugins extend defined interfaces.
- ILIAS has its own established UI, database, permission, setup and migration APIs.
- Do not modify production ILIAS core files merely to customise an installation.
- A real ILIAS change must follow its coding conventions, review process and compatibility rules.

## How to navigate the ILIAS source

Clone the official repository separately:

```bash
git clone https://github.com/ILIAS-eLearning/ILIAS.git
cd ILIAS
git branch -a
```

Start from these repository-level items:

```text
README.md
composer.json
package.json
components/ILIAS/
docs/
templates/
public/
```

### Navigation method

1. Choose one visible feature, for example Course.
2. Search for the relevant component directory.
3. Find its metadata/configuration files.
4. Search for GUI/request classes and command methods.
5. Locate service calls and database access.
6. Locate templates or UI components.
7. Search for tests.
8. Use `git log`, `git blame` and pull-request history to understand why code changed.

Useful commands:

```bash
find components/ILIAS -maxdepth 2 -type d | less
rg "class ilObjCourse" components/ILIAS
rg "function executeCommand|function performCommand" components/ILIAS
rg "getPluginName" public/Customizing components
rg "component.repository" components/ILIAS
rg "Course" tests components/ILIAS
```

Names and exact locations can change between ILIAS releases. Confirm them in the branch used by the employer.

## Interview comparison example

> In my MiniILIAS project, a request is dispatched to a controller, which calls a service and repository, then renders a view. I understand that ILIAS is much larger and follows its own component architecture, APIs and GUI conventions, but the exercise trained me to trace responsibilities across request handling, business logic, persistence and presentation. I would first identify the responsible ILIAS module or service, follow the established interfaces, and avoid bypassing the framework with isolated custom code.
