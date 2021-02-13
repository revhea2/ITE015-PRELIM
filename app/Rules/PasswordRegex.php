<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PasswordRegex implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->message = "";
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
        $error_flag = true;
        // Regex rule for numbers
        if(!preg_match("/^.*\d+.*$/", $value)){
            $this->message .= "Password must contain at least 1 number. \n";
            $error_flag = false;
        }
        // Regex rule for lowercase letters
        if(!preg_match("/^.*[a-z]+.*$/", $value)){
            $this->message .= "Password must contain at least 1 lowercase letter. \n";
            $error_flag = false;
        }
        // Regex rule for uppercase letters
        if(!preg_match("/^.*[A-Z]+.*$/", $value)){
            $this->message .= "Password must contain at least 1 uppercase letter. \n";
            $error_flag = false;
        }
        // Regex rule for special characters
        if(!preg_match("/^.*[^\w\s]+.*$/", $value)){
            $this->message .= "Password must contain at least 1 special character. \n";
            $error_flag = false;
        }
        return $error_flag;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
