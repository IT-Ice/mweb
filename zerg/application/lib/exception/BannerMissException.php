<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/6/25
 * Time: 下午10:33
 */

namespace app\lib\exception;


class BannerMissException extends BaseException
{
    public $code = 404;
    public $msg = "请求的bnner不存在";
    public $errorCode = 40000;
}