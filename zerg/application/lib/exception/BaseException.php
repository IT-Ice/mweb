<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/6/25
 * Time: 下午10:33
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception
{
    //http求情状态码
    public $code = 400;

    //错误信息描述
    public $msg = "参数不正确";

    //自定义错误吗
    public $errorCode = 10000;

    //构造器
    public function __construct($pramae = [])
    {
        if (!is_array($pramae)){
            return;
        }

        if (array_key_exists('code',$pramae)){
            $this -> code = $pramae['code'];
        }

        if (array_key_exists('msg',$pramae)){
            $this -> msg = $pramae['msg'];
        }

        if (array_key_exists('errorCode',$pramae)){
            $this -> errorCode = $pramae['errorCode'];
        }
    }
}