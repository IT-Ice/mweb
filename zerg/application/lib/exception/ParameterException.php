<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/6/26
 * Time: 下午10:26
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = 10000;

}