<?php

namespace App\Http\Requests\Api;


class RegisterRequest extends ApiFromRequest
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
            'username' => 'required|unique:users|username|keep_word',
            'password' => 'required|password',
            'email' => 'required|email|unique:users',
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
            'username.required'  => '用户名不能为空',
            'username.unique'    => '用户名:input不可用',
            'username.username'  => '用户名由2-16位数字或字母、汉字、下划线组成',
            'username.keep_word' => '用户名含有系统保留字:input',
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式不正确',
            'password.required' => '密码不能为空',
            'password.password' => '密码长度至少6位,必须包含有大写字母、小写字母、数字',
            'email.unique' => '邮箱:input不可用'
        ];
    }
}
