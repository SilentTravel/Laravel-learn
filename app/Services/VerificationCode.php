<?php

namespace App\Services;


use App\Services\Sms\RegisterMessage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class VerificationCode
{
    /**
     * 创建短信
     * @param $phone
     * @return array
     * @throws \Exception
     */
    public function create($phone, $scene)
    {
        // 确定当前是否是正式环境, 节约短信费用
        // https://learnku.com/docs/laravel/5.7/configuration/2243
        if (app()->environment(['production', 'testing'])) {
            // 生成4位随机数，左侧补0
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);
            $key = 'verificationCode_' . str_random(15);

            Log::debug("验证码:{$phone}:{$code}:{$key}");

            $expiredAt = now()->addMinutes(5);
            // 缓存验证码 10分钟过期。
            Cache::put($key, ['mobile' => $phone, 'code' => $code], $expiredAt);

            switch ($scene) {
                case 'register' :
                    $message = new RegisterMessage($code);
                    break;
            }

            app('sms')->send($phone, $message);
        } else {

            $code = '1234';  // 开发环境调试验证码
            $key = 'verificationCode_' . str_random(15);

            Log::debug("验证码:{$phone}:{$code}:{$key}");

            $expiredAt = now()->addMinutes(5);
            // 缓存验证码 10分钟过期。
            Cache::put($key, ['mobile' => $phone, 'code' => $code], $expiredAt);
        }

        return [
            'key' => $key,
            'expired_at' => $expiredAt->toDateTimeString()
        ];
    }

    /**
     * 验证短信
     * @param $key
     * @param $code
     * @param $phone
     * @return bool
     */
    public static function validate($key, $code, $phone)
    {
        if (!$key || !$code || !$phone) {
            return false;
        }

        $cachedData = Cache::get($key);

        if (!$cachedData || $phone != $cachedData['mobile']) {
            return false;
        }

        Log::debug('cached verify code', ['key' => $key,
            'cached' => $cachedData, 'input' => $code]);

        return hash_equals($cachedData['code'], $code);
    }
}