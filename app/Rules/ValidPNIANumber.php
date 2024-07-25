<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidPNIANumber implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Vérifie si la valeur correspond au format 000 000 00 00
        return preg_match('/^862 \d{3} \d{2} \d{2}$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Le numéro de poste PNIA doit être au format 862 000 00 00.';
    }
}
