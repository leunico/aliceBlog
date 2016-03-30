<?php namespace AliceFrameWork\weixin;
/*  
 *  微信核心类
 *  @leunico 
 */

class WeixinClass
{
    protected $sessionId = 'admin_user_login';
    protected $new_sessionId = 'new_admin_user_login';
    
    public function valid()
    {
        $echoStr = $_GET['echostr'];
        if ($this->checkSignature()) {
            echo $echoStr;
            die;
        }
    }
    
    private function checkSignature()
    {
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }
    
    public function responseMsg()
    {
        $postStr = $GLOBALS['HTTP_RAW_POST_DATA'];
        if (!empty($postStr)) {
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
            switch ($RX_TYPE) {
                case 'text':
                    $resultStr = $this->receiveText($postObj);
                    break;
                case 'event':
                    $resultStr = $this->receiveEvent($postObj);
                    break;
                case 'location':
                    $resultStr = $this->receiveLocation($postObj);
                    break;
                default:
                    $resultStr = '';
                    break;
            }
            echo $resultStr;
        } else {
            die('没有设置这个MsgType');
        }
    }
    
    //接收位置消息
    private function receiveLocation($object)
    {
        $content = '你发送的是位置，纬度为：' . $object->Location_X . '；经度为：' . $object->Location_Y . '；缩放级别为：' . $object->Scale . '；位置为：' . $object->Label;
        $result = $this->transmitText($object, $content);
        return $result;
    }
    
    //接收文本消息
    private function receiveText($object)
    {
        $keyword = trim($object->Content);
        //多客服人工回复模式
        if (strstr($keyword, '您好') || strstr($keyword, '你好') || strstr($keyword, '在吗')) {
            $result = $this->transmitService($object);
        } else {
            //自动回复模式
            if (strstr($keyword, '文本')) {
                $weixin = new class_weixin_adv();
                $info = $weixin->get_user_info($object->FromUserName);
                $content = '这是个文本消息，你写的就是文本' . $info['nickname'];
            } else {
                if (strstr($keyword, '单图文')) {
                    $content = array();
                    $content[] = array('Title' => '单图文标题', 'Description' => '单图文内容', 'PicUrl' => 'http://discuz.comli.com/weixin/weather/icon/cartoon.jpg', 'Url' => 'http://m.cnblogs.com/?u=txw1958');
                } else {
                    if (strstr($keyword, '图文') || strstr($keyword, '多图文')) {
                        $content = array();
                        $content[] = array('Title' => '【深圳】天气实况 温度：3℃ 湿度：43﹪ 风速：西南风2级', 'Description' => '南京', 'PicUrl' => 'http://www.doucube.com/weixin/weather/icon/banner.jpg', 'Url' => 'http://m.cnblogs.com/?u=txw1958');
                        $content[] = array('Title' => '06月24日 周四 2℃~-7℃ 晴 北风3-4级转东南风小于3级', 'Description' => '长沙', 'PicUrl' => 'http://www.doucube.com/weixin/weather/icon/d00.gif', 'Url' => 'http://m.cnblogs.com/?u=txw1958');
                        $content[] = array('Title' => '06月25日 周五 -1℃~-8℃ 晴 东南风小于3级转东北风3-4级', 'Description' => '桂林', 'PicUrl' => 'http://www.doucube.com/weixin/weather/icon/d00.gif', 'Url' => 'http://m.cnblogs.com/?u=txw1958');
                    } else {
                        if (strstr($keyword, '音乐')) {
                            $content = array();
                            $content = array('Title' => '最炫民族风', 'Description' => '歌手：凤凰传奇', 'MusicUrl' => 'http://121.199.4.61/music/zxmzf.mp3', 'HQMusicUrl' => 'http://121.199.4.61/music/zxmzf.mp3');
                        } else {
                            if (strstr($keyword, '爱')) {
                                $content = '敬往事一杯酒，再爱不回头...';
                            } else {
                                if ($keyword == '你喜欢谁') {
                                    $content = '哈哈哈哈哈哈哈';
                                } else {
                                    $content = '你发送的内容是：' . $object->Content . '时间:' . date('Y-m-d H:i:s', time()) . 'Alice的窝回答不了，么么哒！';
                                }
                            }
                        }
                    }
                }
            }
            if (is_array($content)) {
                if (isset($content[0]['PicUrl'])) {
                    $result = $this->transmitNews($object, $content);
                } else {
                    if (isset($content['MusicUrl'])) {
                        $result = $this->transmitMusic($object, $content);
                    }
                }
            } else {
                $result = $this->transmitText($object, $content);
            }
        }
        return $result;
    }
    
    private function receiveEvent($object)
    {
        $contentStr = '';
        switch ($object->Event) {
            case 'subscribe':
                $weixin = new Weixin();
                $info = $weixin->get_user_info($object->FromUserName);
                $password = rand(100, 999) . rand(100, 999);
                $return = empty($info['nickname']) ? NULL : WeixinData::SetUser($object->FromUserName, $info['nickname'], $password);
                if (isset($return)) {
                    $contentStr = is_array($return) ? '你已经关注且注册过帐号请再扫描二维码登录......帐号是:' . $return[0]['username'] : '感谢关注我的微信公众平台！请再扫描二维码登录......帐号:' . $info['nickname'] . '密码:' . $password;
                } else {
                    $contentStr = '不是有效的openid,请在手机端操作!!openid是:' . $object->FromUserName;
                }
                break;
            case 'unsubscribe':
                $contentStr = '取消关注';
                break;
            case 'SCAN':
                $weixin = new Weixin();
                $info = $weixin->get_user_info($object->FromUserName);
                $return = WeixinData::GetUser($object->FromUserName);
                if (!empty($return)) {
                    $login = WeixinData::SetweixinUser($object->FromUserName, $info['nickname'], $object->EventKey);
                    $contentStr = empty($login) ? '由于数据处理错误，登录失败！' : $info['nickname'] . '在AliceBlog的帐号已经登录啦，请等待跳转~登录数字:' . $object->EventKey;
                } else {
                    $contentStr = 'sorry,网站并没有你的帐号，请联系管理员。openid是:' . $object->FromUserName;
                }
                break;
            case 'LOCATION':
                $contentStr = '上传位置：纬度 ' . $object->Latitude . ';经度 ' . $object->Longitude;
                break;
            case 'CLICK':
                switch ($object->EventKey) {
                    case 'company':
                        $contentStr[] = array('Title' => '个人简介', 'Description' => '我的个人微博及个人Blog', 'PicUrl' => 'http://discuz.comli.com/weixin/weather/icon/cartoon.jpg', 'Url' => 'http://520.leunico.sinaapp.com/');
                        break;
                    case '游戏':
                        $contentStr[] = array('Title' => 'OAuth2.0网页授权演示', 'Description' => 'OAuth2.0网页授权演示', 'PicUrl' => 'http://discuz.comli.com/weixin/weather/icon/cartoon.jpg', 'Url' => 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxb33bef172a0860cf&redirect_uri=http://520.leunico.sinaapp.com/wechat/oauth.php&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect');
                        break;
                    default:
                        $contentStr[] = array('Title' => '默认菜单回复', 'Description' => '您正在使用的是Leunico测试帐号的自定义菜单测试接口', 'PicUrl' => 'http://discuz.comli.com/weixin/weather/icon/cartoon.jpg', 'Url' => 'http://520.leunico.sinaapp.com/');
                        break;
                }
                break;
            default:
                $contentStr = '未找到事件';
                break;
        }
        if (is_array($contentStr)) {
            $resultStr = $this->transmitNews($object, $contentStr);
        } else {
            $resultStr = $this->transmitText($object, $contentStr);
        }
        return $resultStr;
    }
    
    private function transmitText($object, $content, $funcFlag = 0){
        
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
<FuncFlag>%d</FuncFlag>
</xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $funcFlag);
        return $resultStr;
        
    }

    private function transmitService($object){
        
        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[transfer_customer_service]]></MsgType>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
        
    }

    private function transmitNews($object, $arr_item, $funcFlag = 0){
        
        //首条标题28字，其他标题39字
        if(!is_array($arr_item)) return;
        $itemTpl = "    <item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
        </item>
";
        $item_str = "";
        foreach ($arr_item as $item){
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }         
        $newsTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<Content><![CDATA[]]></Content>
<ArticleCount>%s</ArticleCount>
<Articles>
$item_str</Articles>
<FuncFlag>%s</FuncFlag>
</xml>";
        $resultStr = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($arr_item), $funcFlag);
        return $resultStr;
        
    }
   
    
}
