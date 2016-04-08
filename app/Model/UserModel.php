<?php namespace app\Model;

use AliceFrameWork\Example;

class UserModel
{
    private $example;
    
    public function __construct()
    {
        $this->example = new Example('admin_user');
    }
    
    public function getUserList($page)
    {
        return $this->example->Data('a.* ,COUNT(b.id) AS count')->Join('info_article', 'LEFT', 'a.id=b.uid')->where('', '')->group('a.id')->order(array('count', 'ctime'), array('DESC', 'DESC'))->Paginate($page, 10);
    }
    
    public function setUserBlock($id, $fields)
    {
        return $this->example->Update($fields)->where('id', $id)->change();
    }
    
    public function InsertUser($fields)
    {
        return $this->example->Insert($fields)->change();
    }
    
    public function delUser($id)
    {
        return $this->example->Delete()->where('id', $id)->change();
    }
    
    public function getOneUser($type, $val)
    {
        return $this->example->Find($type, $val);
    }
    
    public function editUser($id, $fields)
    {
        return $this->example->Update($fields)->where('id', $id)->change();
    }
    
    public function editArticleAuthor($username, $id)
    {
        return $this->example->setBind('info_article')->Update(array('author' => $username))->where('uid', $id)->change();
    }
    
    public function getweixinUser($scene_id)
    {
        return $this->example->setBind('weixin_user')->Find('scene_id', $scene_id);
    }
    
    public function delweixinUser($scene_id)
    {
        return $this->example->setBind('weixin_user')->Delete()->where('scene_id', $scene_id)->change();
    }
    
}
