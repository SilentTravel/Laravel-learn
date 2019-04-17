<?php

namespace App\Validators;

class KeepWordValidator
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        // str_plural() 函数将字符串转换为复数形式。该功能只支持英文(Laravel辅助函数)
        return !in_array($value, config('filter.words')) && !in_array(str_plural($value),
                config('filter.words'));
    }
}