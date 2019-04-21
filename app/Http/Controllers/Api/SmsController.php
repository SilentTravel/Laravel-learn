<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\SendSmsRequest;
use App\Services\VerificationCode;

class SmsController extends BaseController
{
    private $VerificationCodeService;

    public function __construct(VerificationCode $verificationCode)
    {
        $this->VerificationCodeService = $verificationCode;
    }

    /**
     * 发送短信
     * @param SendSmsRequest $request
     * @return array
     * @throws \Exception
     */
    public function send(SendSmsRequest $request)
    {
        $phone = $request->get('phone');
        $scene  = $request->get('scene');
        $result = $this->VerificationCodeService->create($phone, $scene);
        return Response()->json($result);
    }
}