<?php namespace app\Model;

use AliceFrameWork\Example;

class IndexModel
{
    private $example;
    
    public function __construct()
    {
        $this->example = new Example('info_article');
    }
    
    public function getArticleList($page)
    {
        return $this->example->Data('a.* ,COUNT(b.id) AS comcount')->Join('info_comment', 'LEFT', 'a.id=b.aid')->where('', '')->group('a.id')->order(array('top', 'ctime'), array('DESC', 'DESC'))->Pageindex($page, 10);
    }
    
    public function getPushArticleList()
    {
        return $this->example->Data('id,image,title,mid,author')->where('recommend_type', 2)->order(array('good_num', 'ctime'), array('DESC', 'DESC'))->get(6);
    }
    
    public function getSearchList($fields)
    {
        return $this->example->Data()->where(array('title', 'description'), array("%{$fields}%", "%{$fields}%"), array('LIKE', 'LIKE'), 'OR')->order('ctime', 'DESC')->get(20);
    }
    
    public function getTagList()
    {
        return $this->example->setBind('info_tag')->Data()->where('', '')->order('num', 'DESC')->get(15);
    }
    
    public function getPushIndex()
    {
        return $this->example->setBind('info_indexpush')->Data()->where('', '')->order('utime', 'DESC')->get(4);
    }
    
    public function getCommentList()
    {
        return $this->example->setBind('info_comment')->Data('a.*,b.title')->Join('info_article', 'INNER', 'a.aid=b.id')->where('', '')->order('ctime', 'DESC')->get(5);
    }
    
}
