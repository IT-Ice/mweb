<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/9/6
 * Time: 下午10:31
 */

namespace app\lib\exception;


class BannerMissException extends BaseException
{
    public $code = 404;

    public $msg = '请求的Banner不存在';

    public $errorCode = 40000;

}