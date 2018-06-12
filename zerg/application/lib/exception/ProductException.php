<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/11
 * Time: 下午8:33
 */

namespace app\lib\exception;


class ProductException extends BaseException
{
    public $code = 404;
    public $msg = '指定的商品不存在，请检查参数';
    public $errorCode = 20000;

}