<?php
/**
 * Created by PhpStorm.
 * User: ice
 * Date: 2017/7/13
 * Time: 下午11:15
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Exception;
use app\api\model\User as UserModel;

class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    /**
     * UserToken constructor.
     * @param $code
     * @remake 构造函数
     */
    function __construct($code)
    {
        $this -> code = $code;
        $this -> wxAppID = config('wx.app_id');
        $this -> wxAppSecret = config('wx.app_secret');
        $this -> wxLoginUrl = sprintf(config('wx.login_url'),$this->wxAppID,$this->wxAppSecret,$this->code);
    }

    public function get(){
        $result = curl_get($this -> wxLoginUrl);
        $wxResult = json_decode($result,true);
        if(empty($wxResult)){
            throw new Exception('获取session_key和openid时异常，微信内部错误');
        }else{
            $loginFail = array_key_exists('errcode',$wxResult);
            if($loginFail){
                $this->processLoginError($wxResult);
            }else{
                return $this->grantToken($wxResult);
            }
        }
    }

    /**
     * @param $wxResult
     * @throws WeChatException
     * @remake 处理调用微信login_url接口失败
     */
    private function processLoginError($wxResult){
        throw new WeChatException([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errcode']
        ]);
    }

    private function grantToken($wxResult){
        //第一 拿到openid
        $openid = $wxResult['openid'];
        //第二 数据库里看一下这个openid是否已经存在，如果存在不做处理，如果不存在新增一条user数据
        $user = UserModel::getByOpenID($openid);
        if($user){
            $uid = $user -> id;
        }else{
            $uid = UserModel::newUser($openid)->id;
        }
        //第三 生成令牌，准备缓存数据
        $cachedValue = $this->prepareCachedValue($wxResult,$uid);
        //第四 写入缓存
        $token = $this->saveToCache($cachedValue);
        //第五 将令牌返回到客户端
        return $token;
    }

    /**
     * @param $cachedValue
     * @return string
     * @remake 写入缓存
     */
    private function saveToCache($cachedValue){
        $key = self::generateToken();
        $value = json_encode($cachedValue);
        $expire_in = config('setting.token_expire_in');
        $result = cache($key,$value,$expire_in);
        if(!$result){
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }
        return $key;
    }

    /**
     * @param $wxResult
     * @param $uid
     * @return mixed
     * @remake 准备缓存数据
     */
    private function prepareCachedValue($wxResult,$uid){
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = ScopeEnum::User;
        return $cachedValue;
    }

}