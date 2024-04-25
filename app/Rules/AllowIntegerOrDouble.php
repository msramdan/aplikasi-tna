<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AllowIntegerOrDouble implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value != 0) {
            if (!(intval($value) != 0 || doubleval($value) != 0.0)) {
                $fail('number is invalid must be an integer or decimal number');
            }
        }
    }
}
