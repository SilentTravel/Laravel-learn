<?php

namespace App\Http\Requests\Api;


class SendSmsRequest extends ApiFromRequest
{
    /**
     * 判断用户是否有权限做出此请求。
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * 获取适用于请求的验证规则。
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => 'required|phone',
            'scene' => 'required|in:register,resetting',
        ];
    }

    /**
     * 自定义验证消息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'mobile.required' => '手机号不能为空',
            'mobile.mobile'   => '手机号格式不正确',
            'scene.required'  => '发送场景不能为空',
            'scene.in' => '不存在的错误场景',
        ];
    }
}