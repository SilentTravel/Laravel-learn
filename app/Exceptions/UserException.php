<?php


namespace App\Exceptions;


class UserException extends BaseException
{
    public $httpCode = 201;

    public $msg = '用户不存在';

    public $errorCode = 2000;
}