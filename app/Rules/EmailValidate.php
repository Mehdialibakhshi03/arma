<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EmailValidate implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value,$fail)
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

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
