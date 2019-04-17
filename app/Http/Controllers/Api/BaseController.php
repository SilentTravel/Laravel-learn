<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

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
            return Response()->json([
                'msg' => $msg,
                'error_code' => 0,
                'data' => $data,
                'request_time' => time()
            ], $httpCode);
        } else {
            return Response()->json([
                'msg' => $msg,
                'error_code' => 0,
                'request_time' => time()
            ], $httpCode);
        }
    }
}