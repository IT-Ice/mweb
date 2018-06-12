<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/9/6
 * Time: 下午10:25
 */

namespace app\lib\exception;


use Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;
    public function render(Exception $e)
    {
        if ($e instanceof BaseException){
            $this -> code = $e -> code;
            $this -> msg = $e -> msg;
            $this -> errorCode = $e -> errorCode;
        }else{
            if (config('app_debug')){
                return parent::render($e);
            }else{
                $this -> code = 500;
                $this -> msg = '服务器内部错误或未知错误';
                $this -> errorCode = 999;
                $this -> recordLogError($e);
            }
        }
        $request = Request::instance();
        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'requset_url' => $request->url()
        ];

        return json($result,$this->code);
    }

    /**
     * 系统级别的错误需要记录日志
     * @param $e
     */
    private function recordLogError($e){
        Log::init([
            'type' => 'File',
            'path' => LOG_PATH,
            'level' => ['error']
        ]);

        Log::record($e -> getMessage(),'error');
    }
}