<?php
/**
 * Created by PhpStorm.
 * User: silent
 * Date: 2019/4/11
 * Time: 22:59
 */

namespace App\Exceptions;


class ParamsException extends BaseException
{
    public $httpCode = 400;

    public $errorCode = 1000;

    public $msg = "参数错误";

}