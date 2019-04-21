<?php


namespace App\Validators;


use App\Services\VerificationCode;

class PhoneVerifyCodeValidator
{
    public function validate($attribute, $value, $parameters, $validator)
    {
//        dd($attribute);

        $phone = request('phone');
        $code = request('code');
        $salt_key = request('salt_key');
        return VerificationCode::validate($salt_key, $code, $phone);
    }
}