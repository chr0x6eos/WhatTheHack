<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;


/**
 * Class BadCharacters
 * @package App\Rules
 */
class BadCharacters implements Rule
{

    /**
     * BadCharacters constructor.
     */
    public function __construct()
    {
        //
    }


    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     * Checks if string contains bad characters
     */

    public function passes($attribute, $value)
    {
         if(strpos($value,"\'")===true)
            return false;

         if(strpos($value,",")===true)
             return false;

        if(strpos($value,";")===true)
            return false;

        if(strpos($value,"\"")===true)
            return false;

        if(strpos($value,"\(")===true)
            return false;

        if(strpos($value,"\)")===true)
            return false;

        if(strpos($value,"\[")===true)
            return false;

        if(strpos($value,"\]")===true)
            return false;

        if(strpos($value,"\{")===true)
            return false;

        if(strpos($value,"\}")===true)
            return false;

        if(strpos($value,"\0")===true)
            return false;

        if(strpos($value,"\n")===true)
            return false;

        if(strpos($value,"\r")===true)
            return false;

        if(strpos($value,"\t")===true)
            return false;

        if(strpos($value,"\\")===true)
            return false;

        if(strpos($value,"_")===true)
            return false;

        if(strpos($value,"%")===true)
            return false;

        return true;
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
