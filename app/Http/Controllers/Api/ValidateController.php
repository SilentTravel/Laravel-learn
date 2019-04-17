<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ValidateController extends BaseController
{
    /**
     * 检测数据是否存在
     * @param Request $request
     */
    public function check(Request $request)
    {
        if ($request->has('email')) {
            User::whereEmail($request->get('email'))->exists();
        }
        if ($request->has('mobile')) {
            User::whereEmail($request->get('email'))->exists();
        }
        if ($request->has('username')) {
            User::whereEmail($request->get('email'))->exists();
        }
    }
}
