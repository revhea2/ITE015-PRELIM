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
        $dictionariesLoaded = array();
        for($i = 0; $i < strlen($value) - 3; $i++){
            for($j=0; $j+$i < strlen($value) - 3; $j++){
                $word = substr($value, $j, $i+4);
                echo $word;
                echo '<br/>';
                $hasSpecialChar = preg_match("/^.*[^\w\s]+.*$/", $word);
                $hasNumber = preg_match("/^.*\d+.*$/", $word);
                // If-statements are nested to avoid potential unnecessary checking
                if(!$hasSpecialChar && !$hasNumber){
                    // If the dictionary for the word's starting letter is not yet loaded, load it
                    // otherwise, check it against the loaded dictionary
                    if(!isset($dictionariesLoaded[$word[0]])){
                        $file = file_get_contents(resource_path("words/words_alpha_".$word[0].".txt"));
                        $dictionariesLoaded[$word[0]] = explode("\r\n", $file);

                    } else if(in_array(strtolower($word), $dictionariesLoaded[$word[0]])){
                        return false;
                    }
                }
            }
        }
        return true;
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
