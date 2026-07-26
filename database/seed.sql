USE mini_ilias;

-- Password for all demo users: Password123!
INSERT INTO users (name, email, password_hash, role) VALUES
('Admin User', 'admin@example.com', '$2y$12$mXMCaC5kiKHc9fNb/oyw6OZcaXtozozKsyGN9Qmyz6SQuT.95xUx2', 'admin'),
('ILIAS Instructor', 'instructor@example.com', '$2y$12$mXMCaC5kiKHc9fNb/oyw6OZcaXtozozKsyGN9Qmyz6SQuT.95xUx2', 'instructor'),
('Student User', 'student@example.com', '$2y$12$mXMCaC5kiKHc9fNb/oyw6OZcaXtozozKsyGN9Qmyz6SQuT.95xUx2', 'student');

INSERT INTO courses (title, description, instructor_id, status) VALUES
(
    'PHP Foundations',
    'Learn variables, arrays, conditions, loops, functions, request data and secure output escaping.',
    2,
    'published'
),
(
    'OOP and Composer',
    'Practise classes, interfaces, dependency injection, namespaces, PSR-4 autoloading and Composer scripts.',
    2,
    'published'
),
(
    'ILIAS Code Navigation',
    'A draft course about tracing a request through ILIAS components, services, GUI classes, templates and database access.',
    2,
    'draft'
);

INSERT INTO enrollments (user_id, course_id) VALUES
(3, 1);
