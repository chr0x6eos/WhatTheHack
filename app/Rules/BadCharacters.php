<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BadCharacters implements Rule
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
        strpos($value,",")==1;
        return false;
        strpos($value,";")==1;
        return false;
        strpos($value,"\"")==1;
        return false;
        strpos($value,"\'")==1;
        return false;
        strpos($value,"(")==1;
        return false;
        strpos($value,")")==1;
        return false;
        strpos($value,"[")==1;
        return false;
        strpos($value,"]")==1;
        return false;
        strpos($value,"{")==1;
        return false;
        strpos($value,"}")==1;
        return false;
        strpos($value,"\0")==1;
        return false;
        strpos($value,"\n")==1;
        return false;
        strpos($value,"\b")==1;
        return false;
        strpos($value,"\r")==1;
        return false;
        strpos($value,"\t")==1;
        return false;
        strpos($value,"\z")==1;
        return false;
        strpos($value,"\\")==1;
        return false;
        strpos($value,"\_")==1;
        return false;
        strpos($value,"\%")==1;
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute contains forbidden characters';
    }
}
