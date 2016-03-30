<?php namespace AliceFrameWork\weixin;
/*  
 *  微信数据反应类
 *  @leunico 
 */

use AliceFrameWork\Example;

class WeixinData
{
    //插入一条数据_用户数据
    public static function SetUser($openid, $wxname, $password)
    {
        if (empty($wxname)) {
            return false;
        }
        $auth = self::GetUser($openid);
        if (empty($auth)) {
            $fields = array();
            $ret = new Example('admin_user');
            $fields['ctime'] = time();
            $fields['password'] = md5($password);
            $fields['openid'] = $openid;
            $fields['username'] = $wxname;
            $fields['email'] = 'xxx';
            $fields['wxname'] = $wxname;
            return $ret->Insert($fields)->change();
        } else {
            return $auth;
        }
    }
    
    //查询一条数据，根据openid
    public static function GetUser($openid)
    {
        $ret = new Example('admin_user');
        return $ret->Find('openid', $openid);
    }
    
    //插入一条数据_登录信息
    public static function SetweixinUser($openid, $wxname, $scene_id)
    {
        $ret = new Example('weixin_user');
        $creatime = time();
        $fields = compact('scene_id', 'wxname', 'openid', 'creatime');
        return $ret->Insert($fields)->change();
    }
}
