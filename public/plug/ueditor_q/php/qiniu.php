<?php

define("DEFAULT_STORAGE", TRUE); // FALSE是不启用七牛云储存
define("DEFAULT_URL", 'http://7xq09h.com1.z0.glb.clouddn.com/');
require_once '/home/wwwroot/htdocs/public/plug/qiniu/autoload.php';
//dirname(dirname(__FILE__)).'/qiniu/autoload.php';

use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;

class Qiniu {
	
	private $accessKey = 'BfR2VxdEwZavgGM3kVChc6F0NKwGMTPMUdUsywtz';
    private $secretKey = 'jhifcIoBhyH_AQBsxAHChXaR9nWMed3F07pOI4JM';
	private $bucket = "";
	private $Auth = "";
	public function __construct($bucket = ''){
	
	     $this->auth = new Auth($this->accessKey, $this->secretKey);
		 $this->bucket = $bucket ? $bucket : "lzxya";
		 
	}
    
    public function PutImgFile($filename,$filePath){
        
        // 生成上传Token
        $token = $this->auth->uploadToken($this->bucket);
        $uploadMgr = new UploadManager();
        list($ret, $err) = $uploadMgr->putFile($token, $filename, $filePath);
        return ($err !== null) ? false : DEFAULT_URL.$ret['key'];
        
    }
	
}