<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EmailValidate2 implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (str_contains($value, '@yahoo')
            or str_contains($value, '@ymail')
            or str_contains($value, '@gmail')
            or str_contains($value, '@hotmail')
            or str_contains($value, '@outlook')
        ) {
            $fail('Please enter Company :attribute.',);
        }
    }
}
