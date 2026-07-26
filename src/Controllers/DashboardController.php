<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\View;
use App\Repositories\CourseRepositoryInterface;
use App\Repositories\EnrollmentRepositoryInterface;
use App\Support\Auth;

final class DashboardController
{
    public function __construct(
        private readonly CourseRepositoryInterface $courses,
        private readonly EnrollmentRepositoryInterface $enrollments,
        private readonly Auth $auth
    ) {
    }

    public function index(): void
    {
        $user = $this->auth->requireLogin();

        View::render('dashboard', [
            'title' => 'Dashboard',
            'user' => $user,
            'enrolledCourses' => $this->enrollments->coursesForUser($user->id),
            'authoredCourses' => $user->canManageCourses()
                ? $this->courses->authoredBy($user->id)
                : [],
        ]);
    }
}
