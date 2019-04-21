<?php

namespace App\Services\Sms;


use Overtrue\EasySms\Contracts\GatewayInterface;
use Overtrue\EasySms\Message;
use Overtrue\EasySms\Strategies\OrderStrategy;

class RegisterMessage extends Message
{
    private $code;
    protected $strategy = OrderStrategy::class;           // 定义本短信的网关使用策略，覆盖全局配置中的 `default.strategy`
    protected $gateways = ['aliyun'];                     // 定义本短信的适用平台，覆盖全局配置中的 `default.gateways`

    public function __construct($code)
    {
        $this->code = $code;
    }

    // 定义直接使用内容发送平台的内容
    public function getContent(GatewayInterface $gateway = null)
    {
        return "您的验证码{$this->code}，该验证码5分钟内有效，请勿泄漏于他人";
    }

    // 定义使用模板发送方式平台所需要的模板 ID
    public function getTemplate(GatewayInterface $gateway = null)
    {
        return 'SMS_149419120';
    }

    // 模板参数
    public function getData(GatewayInterface $gateway = null)
    {
        return [
            'code' => $this->code
        ];
    }
}