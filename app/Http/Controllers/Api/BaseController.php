<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * 成功返回信息
     * @param string $msg
     * @param array $data
     * @param int $httpCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($msg = '操作成功', $data = [], $httpCode = 200)
    {
        if (!empty($data)) {
            $list = [
                'code' => 1,
                'data' => [
                    'key' => 123,
                    'op' => 6
                ]
            ];
            return \Illuminate\Support\Facades\Response::json($list);
        } else {
            return Response()->json([
                'msg' => $msg,
                'error_code' => 0,
                'request_time' => time()
            ], $httpCode);
        }
    }
}