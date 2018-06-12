<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/6/25
 * Time: 下午8:47
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck(){
        //获取http传入的参数，对这些参数进行校验
        $request =  Request::instance();
        $params = $request->param();

        //调用validate的check方法进行验证
        $result = $this -> batch() -> check($params);
        if(!$result){
            throw new ParameterException([
                'msg' => $this ->error
            ]);
        }else{
            return true;
        }
    }

    /**
     * @param $valve
     * @return bool
     * @remake  验证$value是否是正整数
     */
    protected function isPostiveInteger($valve){
        if (is_numeric($valve) && is_int($valve + 0) && ($valve + 0) > 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $value
     * @return bool
     * @remake 验证手机号
     */
    protected function isMobile($value)
    {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $value
     * @return bool
     * @remake 验证$value是否为空
     */
    protected function isNotEmpty($value){
        if(empty($value)){
            return false;
        }else{
            return true;
        }
    }

    /**
     * @param $arrays
     * @return array
     * @throws ParameterException
     * @remake 根据规则获取参数
     */
    public function getDataByRule($arrays){
        if(array_key_exists('user_id',$arrays) | array_key_exists('uid',$arrays)){
            throw new ParameterException([
                'msg' => '参数中包含非法参数名user_id或uid'
            ]);
        }
        $newArray = [];
        foreach ($this->rule as $key=>$value){
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }
}