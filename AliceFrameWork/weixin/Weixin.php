<?php

/*  
 *  微信SDK
 *  @leunico 
 */
 
namespace AliceFrameWork\weixin;

class Weixin{
    
    public $appid = "****";
    
    public $appsecret = "****";
    
    //构造函数，获取AccessToken,一共有三种方法获取，这是其一
    public function __construct(){
        
        $this->lasttime = 1395049256;    
        $this->access_token = "nRZvVpDU7LxcSi7GnG2LrUcmKbAECzRf0NyDBwKlng4nMPf88d34pkzdNcvhqm4clidLGAS18cN1RTSK60p49zIZY4aO13sF-eqsCs0xjlbad-lKVskk8T7gALQ5dIrgXbQQ_TAesSasjJ210vIqTQ";      
        if (time() > ($this->lasttime + 7200)){         
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appid."&secret=".$this->appsecret;           
            $res = $this->https_request($url);          
            $result = json_decode($res, true);          
            $this->access_token = $result["access_token"];         
            $this->lasttime = time();           
        }
        
    }
    
    //获取用户基本信息
    public function get_user_info($openid){
        
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->access_token."&openid=".$openid."&lang=zh_CN";       
        $res = $this->https_request($url);     
        return json_decode($res, true);
        
    }
    
    //获取带参数的临时二维码  
    public function get_code_image($scene_id){
        
        $qrcode = '{"expire_seconds": 1800,"action_name": "QR_SCENE","action_info": {"scene": {"scene_id":'.$scene_id.'}}}';       
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$this->access_token;       
        $result = $this->https_request($url,$qrcode);      
        $jsoninfo = json_decode($result,true);        
        return $jsoninfo["ticket"];
        
    }
    
    //https请求
    public function https_request($url, $data = null){   
        
        $curl = curl_init();       
        curl_setopt($curl, CURLOPT_URL, $url);      
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);       
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);       
        if (!empty($data)){           
            curl_setopt($curl, CURLOPT_POST, 1);            
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);          
        }        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);    
        $output = curl_exec($curl);       
        curl_close($curl);        
        return $output;
        
    } 
    
    
}
