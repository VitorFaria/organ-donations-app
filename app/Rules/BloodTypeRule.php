<?php

namespace App\Rules;

use App\Enums\BloodType;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules\Enum;

class BloodTypeRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (BloodType::mapValuesToCase($value) == null) {
            $fail("Tipo sanguíneo inválido.");
        }
    }
}
