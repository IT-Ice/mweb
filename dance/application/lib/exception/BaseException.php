<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/9/6
 * Time: 下午10:28
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception
{
    //HTTP  状态吗  200 404
    public $code = 400;

    //错误具体信息
    public $msg = '参数错误';

    //自定义错误码
    public $errorCode = 10000;
}