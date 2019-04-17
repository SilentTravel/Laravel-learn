<?php

namespace App\Http\Requests\Api;

use App\Exceptions\ParamsException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class ApiFromRequest extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            throw (new ParamsException([
                // 取出第一个错误原因
                'msg' => $validator->errors()->first()
            ]));
        }
    }
}