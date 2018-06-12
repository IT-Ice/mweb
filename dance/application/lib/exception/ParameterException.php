<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/9/6
 * Time: 下午11:47
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;

    public $msg = '参数错误';

    public $errorCode = 10000;
}