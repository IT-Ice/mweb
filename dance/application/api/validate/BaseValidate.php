<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/9/6
 * Time: 下午9:39
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck(){
        //获取所有参数
        $request = Request::instance();
        $params = $request->param();

        $result = $this -> check($params);

        if (!$result){
            $e = new ParameterException();
            $e -> msg = $this->error;
            throw $e;
        }else{
            return true;
        }
    }

}