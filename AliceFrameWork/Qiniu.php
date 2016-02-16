<?php

/*  
 *  七牛云操作文件
 *  @leunico 
 */
 
namespace AliceFrameWork;

require_once ADMIN_QINIU_DIR.'autoload.php';

use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;

class Qiniu {
	
	private $accessKey = 'BfR2VxdEwZavgGM3kVChc6F0NKwGMTPMUdUsywtz';
    private $secretKey = 'jhifcIoBhyH_AQBsxAHChXaR9nWMed3F07pOI4JM';
	private $bucket = "";
	private $Auth = "";
	public function __construct($bucket = ''){	
	
	     $this->Auth = new Auth($this->accessKey, $this->secretKey);
		 $this->bucket = $bucket ? $bucket : "lzxya";
		 
	}
	
	public function Delete($filename){
		
		 $Bucket = new BucketManager($this->Auth);
		 $ret = $Bucket->delete($this->bucket,$filename);

	}
	
}