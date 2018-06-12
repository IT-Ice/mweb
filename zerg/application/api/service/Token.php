<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/15
 * Time: 下午6:38
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    public static function generateToken(){
        //用三组随机字符串进行md5加密
        //第一组
        $randChar = getRandChar(32);
        //第二组
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        //第三组 salt 盐
        $salt = config('secure.token_salt');

        return md5($randChar.$timestamp.$salt);
    }

    public static function getCurrentTokenVar($key){
        $token = Request::instance() -> header('token');
        $vars = Cache::get($token);
        if(!$vars){
            throw new TokenException();
        }else{
            if(!is_array($vars)){
                $vars = json_decode($vars,true);
            }

            if(array_key_exists($key,$vars)){
                return $vars[$key];
            }else{
                throw new Exception('尝试获取的token变量不存在');
            }
        }
    }

    public static function getCurrentUid(){
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }


    public static function needPrimaryScope(){
        $scope = self::getCurrentTokenVar('scope');
        if ($scope){
            if ($scope >= ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
    }

    public static function needExclusiveScope(){
        $scope = self::getCurrentTokenVar('scope');
        if ($scope){
            if ($scope == ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
    }
}