<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\RegisterRequest;
use App\User;
use http\Env\Request;


class UsersController extends BaseController
{
    /**
     * 用户注册
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        User::create([
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            // 加密密码
            'password' => bcrypt($request->get('password')),
        ]);
        return $this->success('注册成功', [], 201);
    }


    /**
     * 重置密码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(Request $request)
    {
        auth()->user()->update([
            'password' => bcrypt($request->get('password'))
        ]);
        return $this->success('重置成功', [], 200);
    }


}
