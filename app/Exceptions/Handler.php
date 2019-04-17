<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    private $httpCode;

    private $msg;

    private $errorCode;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof BaseException) {
            // 自定义异常错误
            $this->setResponseContent(
                $exception->httpCode,
                $exception->msg,
                $exception->errorCode
            );
        } else if ($exception instanceof NotFoundHttpException) {
            $this->setResponseContent(404,
                '请求路由不存在', 901);
        } else if ($exception instanceof ModelNotFoundException) {
            $this->setResponseContent(404,
                '获取数据不存在', 902);
        } else if ($exception instanceof HttpException) {
            $this->setResponseContent(400,
                $exception->getMessage(), 1001);
        } else {
            if (config('app.debug')) {
                return parent::render($request, $exception);
            } else {
                $this->setRecordErrorLogs($exception);
                $this->setResponseContent(500,
                    '服务器内部异常', 903);
            }
        }
        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'request_url' => Request::method() . '  ' . Request::Url(),
        ];
        return Response()->json($result, $this->httpCode);
    }

    /**
     * 设置响应内容
     * @param $httpCode
     * @param $msg
     * @param $errorCode
     */
    private function setResponseContent($httpCode, $msg, $errorCode)
    {
        $this->httpCode = $httpCode;
        $this->msg = $msg;
        $this->errorCode = $errorCode;
    }

    /**
     * 记录错误日志
     * @param $exception
     */
    private function setRecordErrorLogs($exception)
    {
        Log::error('API REQUEST : ' . $exception->getMessage());
    }
}
