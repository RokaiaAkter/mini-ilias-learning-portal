CREATE DATABASE IF NOT EXISTS mini_ilias
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE mini_ilias;

CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('student', 'instructor', 'admin') NOT NULL DEFAULT 'student',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_users_role (role)
) ENGINE=InnoDB;

CREATE TABLE courses (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    instructor_id BIGINT UNSIGNED NOT NULL,
    status ENUM('draft', 'published') NOT NULL DEFAULT 'draft',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_courses_instructor
        FOREIGN KEY (instructor_id) REFERENCES users(id)
        ON DELETE RESTRICT,
    INDEX idx_courses_status (status),
    INDEX idx_courses_instructor (instructor_id),
    FULLTEXT INDEX ft_courses_content (title, description)
) ENGINE=InnoDB;

CREATE TABLE enrollments (
    user_id BIGINT UNSIGNED NOT NULL,
    course_id BIGINT UNSIGNED NOT NULL,
    enrolled_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, course_id),
    CONSTRAINT fk_enrollments_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_enrollments_course
        FOREIGN KEY (course_id) REFERENCES courses(id)
        ON DELETE CASCADE,
    INDEX idx_enrollments_course (course_id)
) ENGINE=InnoDB;
