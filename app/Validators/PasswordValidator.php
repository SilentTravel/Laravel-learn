<?php

namespace App\Validators;


class PasswordValidator
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        return preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?!.*\s).{6,}/', $value);
    }
}