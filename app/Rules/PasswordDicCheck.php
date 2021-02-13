<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use PhpSpellcheck\Spellchecker\Aspell;

class PasswordDicCheck implements Rule
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
    public function passes($attribute, $value)
    {
        $aspell = Aspell::create();
        $words = "";

        for($i = 0; $i < strlen($value) - 3; $i++){
            $substrCount = 0;
            for($j=0; $j+$i < strlen($value) - 3; $j++){
                $word = substr($value, $j, $i+4);
                $hasSpecialChar = preg_match("/^.*[^\w\s]+.*$/", $word);
                $hasNumber = preg_match("/^.*\d+.*$/", $word);
                if(!$hasSpecialChar && !$hasNumber){
                    $words .= $word . " ";
                    $substrCount++;
                }
            }
        }

        $spellcheck = $aspell->check($words, ['en_US'], ['from_example']);
        return $substrCount === sizeof($spellcheck);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Password must not contain words from the English language.';
    }
}
