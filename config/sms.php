<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [
    'timeout' => 5.0,
    'default' => [
        'strategy' => \Overtrue\EasySms\Strategies\RandomStrategy::class,
        'gateways' => [
            // 这里的值与下面数组的键对应
            'aliyun',
        ],
    ],
    'gateways' => [
        /*
         * PHP error log gateway
         *
         * http://php.net/manual/en/function.error-log.php
         */
        'error-log' => [
            'file' => '/tmp/easy-sms.log',
        ],
        /*
         * Aliyun SMS service.
         *
         * https://dysms.console.aliyun.com
         */
        'aliyun' => [
            'access_key_id' => env('ALIYUN_ACCESS_KEY_ID'),
            'access_key_secret' => env('ALIYUN_ACCESS_KEY_SECRET'),
            'sign_name' => env('ALIYUN_SIGN_NAME'),
        ],
    ],
];
