<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Entities\Course;
use App\Repositories\CourseRepositoryInterface;
use App\Repositories\EnrollmentRepositoryInterface;
use App\Services\CourseService;
use App\Support\Auth;
use App\Support\Csrf;
use App\Support\Validator;
use DomainException;
use Monolog\Logger;

final class CourseController
{
    public function __construct(
        private readonly CourseService $service,
        private readonly CourseRepositoryInterface $courses,
        private readonly EnrollmentRepositoryInterface $enrollments,
        private readonly Auth $auth,
        private readonly Logger $logger
    ) {
    }

    public function index(): void
    {
        $user = $this->auth->user();

        View::render('courses/index', [
            'title' => 'Courses',
            'user' => $user,
            'courses' => $this->courses->allVisibleTo(
                $user?->id,
                $user?->isAdmin() ?? false
            ),
        ]);
    }

    public function show(): void
    {
        $course = $this->findCourseFromQuery();
        $user = $this->auth->user();

        $mayViewDraft = $user !== null
            && ($user->isAdmin() || $user->id === $course->instructorId);

        if (!$course->isPublished() && !$mayViewDraft) {
            http_response_code(404);
            View::render('errors/404', ['title' => 'Course not found']);
            return;
        }

        View::render('courses/show', [
            'title' => $course->title,
            'course' => $course,
            'user' => $user,
            'isEnrolled' => $user !== null
                && $this->enrollments->isEnrolled($user->id, $course->id),
        ]);
    }

    public function showCreate(): void
    {
        $user = $this->auth->requireLogin();

        if (!$user->canManageCourses()) {
            http_response_code(403);
            exit('Only instructors and administrators can create courses.');
        }

        View::render('courses/form', [
            'title' => 'Create course',
            'course' => null,
            'action' => '/courses/create',
        ]);
    }

    public function create(): void
    {
        $user = $this->auth->requireLogin();
        $this->verifyCsrf();

        $data = $this->courseInput();
        $errors = $this->validateCourse($data);

        if ($errors !== []) {
            $_SESSION['old'] = $data;
            $_SESSION['errors'] = $errors;
            redirect('/courses/create');
        }

        try {
            $courseId = $this->service->create(
                $user,
                $data['title'],
                $data['description'],
                $data['status']
            );
        } catch (DomainException $exception) {
            http_response_code(403);
            exit($exception->getMessage());
        }

        $this->logger->info('Course created', [
            'course_id' => $courseId,
            'actor_id' => $user->id,
        ]);

        unset($_SESSION['old'], $_SESSION['errors']);
        flash('success', 'Course created successfully.');
        redirect('/courses/show?id=' . $courseId);
    }

    public function showEdit(): void
    {
        $user = $this->auth->requireLogin();
        $course = $this->findCourseFromQuery();
        $this->assertCanManage($user->id, $user->isAdmin(), $course);

        View::render('courses/form', [
            'title' => 'Edit course',
            'course' => $course,
            'action' => '/courses/edit?id=' . $course->id,
        ]);
    }

    public function update(): void
    {
        $user = $this->auth->requireLogin();
        $course = $this->findCourseFromQuery();
        $this->verifyCsrf();

        $data = $this->courseInput();
        $errors = $this->validateCourse($data);

        if ($errors !== []) {
            $_SESSION['old'] = $data;
            $_SESSION['errors'] = $errors;
            redirect('/courses/edit?id=' . $course->id);
        }

        try {
            $this->service->update(
                $user,
                $course,
                $data['title'],
                $data['description'],
                $data['status']
            );
        } catch (DomainException $exception) {
            http_response_code(403);
            exit($exception->getMessage());
        }

        $this->logger->info('Course updated', [
            'course_id' => $course->id,
            'actor_id' => $user->id,
        ]);

        unset($_SESSION['old'], $_SESSION['errors']);
        flash('success', 'Course updated successfully.');
        redirect('/courses/show?id=' . $course->id);
    }

    public function delete(): void
    {
        $user = $this->auth->requireLogin();
        $this->verifyCsrf();

        $id = (int) ($_POST['id'] ?? 0);
        $course = $this->courses->find($id);

        if (!$course instanceof Course) {
            http_response_code(404);
            exit('Course not found.');
        }

        try {
            $this->service->delete($user, $course);
        } catch (DomainException $exception) {
            http_response_code(403);
            exit($exception->getMessage());
        }

        $this->logger->warning('Course deleted', [
            'course_id' => $course->id,
            'actor_id' => $user->id,
        ]);

        flash('success', 'Course deleted.');
        redirect('/courses');
    }

    public function enroll(): void
    {
        $user = $this->auth->requireLogin();
        $this->verifyCsrf();

        $id = (int) ($_POST['id'] ?? 0);
        $course = $this->courses->find($id);

        if (!$course instanceof Course) {
            http_response_code(404);
            exit('Course not found.');
        }

        try {
            $this->service->enroll($user, $course);
        } catch (DomainException $exception) {
            flash('error', $exception->getMessage());
            redirect('/courses/show?id=' . $course->id);
        }

        flash('success', 'You joined the course.');
        redirect('/courses/show?id=' . $course->id);
    }

    public function apiSearch(): void
    {
        $query = trim((string) ($_GET['q'] ?? ''));
        $courses = $this->courses->search($query);

        header('Content-Type: application/json; charset=utf-8');

        echo json_encode([
            'data' => array_map(
                static fn (Course $course): array => [
                    'id' => $course->id,
                    'title' => $course->title,
                    'description' => $course->description,
                    'instructor' => $course->instructorName,
                    'url' => '/courses/show?id=' . $course->id,
                ],
                $courses
            ),
        ], JSON_THROW_ON_ERROR);
    }

    private function findCourseFromQuery(): Course
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $course = $id ? $this->courses->find($id) : null;

        if (!$course instanceof Course) {
            http_response_code(404);
            View::render('errors/404', ['title' => 'Course not found']);
            exit;
        }

        return $course;
    }

    private function verifyCsrf(): void
    {
        if (!Csrf::verify($_POST['_token'] ?? null)) {
            http_response_code(419);
            exit('Invalid CSRF token.');
        }
    }

    /** @return array{title:string,description:string,status:string} */
    private function courseInput(): array
    {
        return [
            'title' => trim((string) ($_POST['title'] ?? '')),
            'description' => trim((string) ($_POST['description'] ?? '')),
            'status' => (string) ($_POST['status'] ?? 'draft'),
        ];
    }

    /** @param array{title:string,description:string,status:string} $data */
    private function validateCourse(array $data): array
    {
        $validator = new Validator();
        $validator->validate($data, [
            'title' => ['required', 'min:3', 'max:150'],
            'description' => ['required', 'min:10', 'max:3000'],
            'status' => ['required', 'in:draft,published'],
        ]);

        return $validator->errors();
    }

    private function assertCanManage(int $userId, bool $isAdmin, Course $course): void
    {
        if (!$isAdmin && $course->instructorId !== $userId) {
            http_response_code(403);
            exit('You may only edit your own courses.');
        }
    }
}
