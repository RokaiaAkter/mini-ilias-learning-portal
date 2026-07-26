<?php

declare(strict_types=1);

namespace Tests;

use App\Support\Validator;
use PHPUnit\Framework\TestCase;

final class ValidatorTest extends TestCase
{
    public function testValidCourseDataPasses(): void
    {
        $validator = new Validator();

        $valid = $validator->validate([
            'title' => 'PHP Course',
            'description' => 'A sufficiently long course description.',
            'status' => 'published',
        ], [
            'title' => ['required', 'min:3'],
            'description' => ['required', 'min:10'],
            'status' => ['in:draft,published'],
        ]);

        self::assertTrue($valid);
        self::assertSame([], $validator->errors());
    }

    public function testInvalidEmailProducesError(): void
    {
        $validator = new Validator();

        $valid = $validator->validate([
            'email' => 'not-an-email',
        ], [
            'email' => ['required', 'email'],
        ]);

        self::assertFalse($valid);
        self::assertArrayHasKey('email', $validator->errors());
    }
}
