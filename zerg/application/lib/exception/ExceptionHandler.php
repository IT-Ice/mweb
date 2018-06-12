<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/6/25
 * Time: 下午10:33
 */

namespace app\lib\exception;


use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $error_code;
    //请求的url路径
    public function render(\Exception $e)
    {
        $request = Request::instance();
        if ($e instanceof BaseException){
            $this -> code = $e -> code;
            $this -> msg = $e -> msg;
            $this -> error_code = $e -> errorCode;
        }else{
            if (config("app_debug")){
                return parent::render($e);
            }else{
                $this -> code = 500;
                $this -> msg = "服务器内部错误";
                $this -> error_code = 999;
                //系统错误需要记录日志
                $this ->recordErrorLog($e);
            }
        }

        $result = [
            'error_code' => $this -> error_code,
            'msg' => $this -> msg,
            'request_url' => $request -> url()
        ];

        return json($result,$this -> code);
    }

    protected function recordErrorLog(\Exception $exception){
        Log::init([
            "type" => "File",
            "path" => LOG_PATH,
            "level" => ["error"]
        ]);
        Log::record($exception -> getMessage(),'error');
    }
}