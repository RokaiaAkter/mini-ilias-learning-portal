<?php

declare(strict_types=1);

/**
 * Run with:
 * php examples/php_basics.php
 */

// Scalar variables
$name = 'Lipi';
$age = 30;
$averageScore = 87.5;
$isPreparingForInterview = true;
$notAssigned = null;

// Array types
$skills = ['PHP', 'MySQL', 'Git'];
$profile = [
    'name' => $name,
    'city' => 'Hamburg',
    'skills' => $skills,
];

// Constant
const PROJECT_NAME = 'MiniILIAS';

// String interpolation and concatenation
echo "Project: " . PROJECT_NAME . PHP_EOL;
echo "Learner: {$profile['name']}" . PHP_EOL;

// Conditions and match
$level = $averageScore >= 80 ? 'strong' : 'developing';
$roleMessage = match ($profile['city']) {
    'Hamburg' => 'Local learner',
    default => 'Remote learner',
};

// Loops
foreach ($skills as $index => $skill) {
    echo ($index + 1) . ". {$skill}" . PHP_EOL;
}

for ($attempt = 1; $attempt <= 3; $attempt++) {
    echo "Practice attempt {$attempt}" . PHP_EOL;
}

// Typed function with a default parameter
function calculateProgress(int $completed, int $total = 10): float
{
    if ($total <= 0) {
        throw new InvalidArgumentException('Total must be greater than zero.');
    }

    return round(($completed / $total) * 100, 2);
}

// Anonymous function and arrow function
$normalise = static function (string $value): string {
    return mb_strtolower(trim($value));
};

$skillLengths = array_map(
    static fn (string $skill): int => mb_strlen($skill),
    $skills
);

// Null coalescing
$preferredEditor = $_ENV['EDITOR'] ?? 'VS Code';

printf(
    "%s | %s | %.2f%% | editor: %s\n",
    $level,
    $roleMessage,
    calculateProgress(7),
    $normalise($preferredEditor)
);

var_dump([
    'age' => $age,
    'averageScore' => $averageScore,
    'interview' => $isPreparingForInterview,
    'notAssigned' => $notAssigned,
    'skillLengths' => $skillLengths,
]);
