<?php namespace AliceFrameWork;
/*  
 *  七牛云操作文件
 *  @leunico 
 */

require_once ADMIN_QINIU_DIR . 'autoload.php';

use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;

class Qiniu
{
    
    private $accessKey = 'BfR2VxdEwZavgGM3kVChc6F0NKwGMTPMU****';
    private $secretKey = 'jhifcIoBhyH_AQBsxAHChXaR9nWMed3F0****';
    private $bucket;
    private $Auth;
    public function __construct($bucket = '')
    {
        
        $this->auth = new Auth($this->accessKey, $this->secretKey);
        $this->bucket = $bucket ? $bucket : "lzxya";
        
    }
    
    public function Delete($filename)
    {
        
        $Bucket = new BucketManager($this->auth);
        $err = $Bucket->delete($this->bucket, $filename);
        return ($err !== null) ? '' : true;
        
    }
    
    public function PutImgFile($filename, $filePath, $category)
    {
        
        // 生成上传Token
        $token = $this->auth->uploadToken($this->bucket);
        $uploadMgr = new UploadManager();
        list($ret, $err) = $uploadMgr->putFile($token, $filename, $filePath);
        return ($err !== null) ? '' : QINIU_DIR_THUMB . $ret['key'] . $category;
        
    }
    
}
