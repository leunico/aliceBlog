<?php

/*  
 *  金山云操作文件
 *  @leunico 
 */
define("DEFAULT_STORAGE","JinShan"); //为空是设置关闭金山云
define("KS3_API_VHOST",FALSE); //是否使用VHOST)
define("KS3_API_LOG",FALSE); //是否开启日志(写入日志文件
define("KS3_API_DISPLAY_LOG", FALSE); //是否显示日志(直接输出日志)
define("KS3_API_LOG_PATH",""); //定义日志目录(默认是该项目log下)
define("KS3_API_USE_HTTPS",FALSE); //是否使用HTTPS
define("KS3_API_DEBUG_MODE",FALSE); //是否开启curl debug模式

require_once '/home/wwwroot/htdocs/public/plug/ks/Ks3Client.class.php'; //金山云SDK路径，建议绝对路径

class JinShan {
	
	private $accessKey = 'TlFlO8u2ygMzT******';
    	private $secretKey = 'RAUfkjLesP6CilncuugZXuSYQhKVMTY1******';
	private $bucket = "";
	private $Client = "";
	public function __construct($bucket = ''){
	
	     $this->Client = new \Ks3Client($this->accessKey,$this->secretKey);
	     $this->bucket = $bucket ? $bucket : "nextimg";
		 
	}
	
	public function Delete($img){
		
	    $args = is_array($img) ? array("Bucket"=>$this->bucket,"DeleteKeys"=>$img) : array("Bucket"=>$this->bucket,"Key"=>$img);
	    return $this->Client->deleteObjects($args);
		 
	}
	
	public function PutImgFile($filename,$filepath){
		
	    $content = fopen($filepath, "r");
	    $args = array(
		"Bucket"=>$this->bucket,
		"Key"=>$filename,
		"Content"=>array(         //要上传的内容
			"content"=>$content,  //可以是文件路径或者resource,如果文件大于2G，请提供文件路径
			"seek_position"=>0    //跳过文件开头?个字节
			),
		"ACL"=>"public-read",     //可以设置访问权限,合法值,private、public-read
		"ObjectMeta"=>array(      //设置object的元数据,可以设置"Cache-Control","Content-Disposition","Content-Encoding","Content-Length","Content-MD5","Content-Type","Expires"。当设置了Content-Length时，最后上传的为从seek_position开始向后Content-Length个字节的内容。当设置了Content-MD5时，系统会在服务端进行md5校验。
			"Content-Type"=>"binay/ocet-stream"
				//"Content-Length"=>4
		),
		"UserMeta"=>array(        //可以设置object的用户元数据，需要以x-kss-meta-开头
			"x-kss-meta-test"=>"test"
		)
	    );
	    $ret = $this->Client->putObjectByFile($args);
	    return $ret['ETag'] ? $this->CombinationUrl($filename) : false;
	}
	
	public function CombinationUrl($filename){
		
	    return "http://".$this->bucket.".kssws.ks-cdn.com/".$filename."@base@tag=imgScale&q=100&w=690"; //后缀控制图片大小	
		
	}
	
}
