<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/15
 * Time: 下午5:21
 */

namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code = 400;
    public $errorCode = 999;
    public $msg = '微信服务器接口调用失败';

}