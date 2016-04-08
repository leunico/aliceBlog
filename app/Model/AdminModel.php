<?php namespace app\Model;

use AliceFrameWork\Example;
use AliceFrameWork\Request;
use AliceFrameWork\View;

class AdminModel
{
    private $example;
    
    public function __construct()
    {
        $this->example = new Example('admin_user');
    }
    
    public function getByUser($email)
    {
        return $this->example->Find('email', $email);
    }
    
    public function getByUserId($id)
    {
        return $this->example->Find('id', $id);
    }
    
    public function getByArticleId($id)
    {
        return $this->example->setBind('info_article')->Find('id', $id, 'uid');
    }
    
    public function MemUpdata($mem)
    {
        $lasttime = Request::getSession('MemacheData') ? Request::getSession('MemacheData') : 1444895435;
        if (time() < $lasttime + 5) {
            View::AdminErrorMessage('goback', '操作过于频繁');
        } else {
            if (MEMCACHE == TRUE) {
                $mem->clear();
            } else {
                View::AdminErrorMessage('goback', '网站未开启缓存');
            }
            Request::setSession('MemacheData', time());
        }
        View::AdminMessage('goback', '缓存更新成功!');
    }
    
    public function MemClear($mem)
    {
        if (MEMCACHE == TRUE) {
            $mem->clear();
        } else {
            return FALSE;
        }
    }
    
}
