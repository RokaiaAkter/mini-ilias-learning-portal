<?php

declare(strict_types=1);

namespace App\Support;

final class Validator
{
    /** @var array<string,string> */
    private array $errors = [];

    /**
     * @param array<string,mixed> $data
     * @param array<string,list<string>> $rules
     */
    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];

        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? null;

            foreach ($fieldRules as $rule) {
                [$name, $parameter] = array_pad(explode(':', $rule, 2), 2, null);

                match ($name) {
                    'required' => $this->required($field, $value),
                    'email' => $this->email($field, $value),
                    'min' => $this->min($field, $value, (int) $parameter),
                    'max' => $this->max($field, $value, (int) $parameter),
                    'in' => $this->in($field, $value, explode(',', (string) $parameter)),
                    default => null,
                };
            }
        }

        return $this->errors === [];
    }

    /** @return array<string,string> */
    public function errors(): array
    {
        return $this->errors;
    }

    private function required(string $field, mixed $value): void
    {
        if ($value === null || trim((string) $value) === '') {
            $this->errors[$field] ??= ucfirst($field) . ' is required.';
        }
    }

    private function email(string $field, mixed $value): void
    {
        if ($value !== null && $value !== '' && filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[$field] ??= ucfirst($field) . ' must be a valid email address.';
        }
    }

    private function min(string $field, mixed $value, int $length): void
    {
        if (is_string($value) && mb_strlen($value) < $length) {
            $this->errors[$field] ??= ucfirst($field) . " must contain at least {$length} characters.";
        }
    }

    private function max(string $field, mixed $value, int $length): void
    {
        if (is_string($value) && mb_strlen($value) > $length) {
            $this->errors[$field] ??= ucfirst($field) . " may contain at most {$length} characters.";
        }
    }

    /** @param list<string> $allowed */
    private function in(string $field, mixed $value, array $allowed): void
    {
        if (!in_array((string) $value, $allowed, true)) {
            $this->errors[$field] ??= ucfirst($field) . ' has an invalid value.';
        }
    }
}
