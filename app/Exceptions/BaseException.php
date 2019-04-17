<?php
/**
 * Created by PhpStorm.
 * User: silent
 * Date: 2019/4/11
 * Time: 21:18
 */

namespace App\Exceptions;


class BaseException extends \Exception
{
    public $httpCode = 400;  // HTTP状态码

    public $msg = '参数错误'; // 具体错误信息

    public $errorCode = 1000; // 自定义错误状态码


    /**
     * 初始化操作
     * BaseException constructor.
     * @param array $params
     */
    public function __construct($params = [])
    {
        if (!is_array($params)) {
            // 对当前属性不做任何修改
            return;
        }
        if (array_key_exists('httpCode', $params)) {
            $this->httpCode = $params['httpCode'];
        }
        if (array_key_exists('msg', $params)) {
            $this->msg = $params['msg'];
        }
        if (array_key_exists('errorCode', $params)) {
            $this->errorCode = $params['errorCode'];
        }
    }
}