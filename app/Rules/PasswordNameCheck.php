<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordNameCheck implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($firstName, $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $password = strtolower($value);
        $firstName = strtolower($this->firstName);
        $lastName = strtolower($this->lastName);
        $containsFirstName = str_contains($password, $firstName);
        $containsLastName = str_contains($password, $lastName);
        $containsReversedFN = str_contains($password, strrev($firstName));
        $containsReversedLN = str_contains($password, strrev($lastName));
        return !($containsFirstName || $containsLastName || $containsReversedFN || $containsReversedLN);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Password must not contain your first name or last name!';
    }
}
