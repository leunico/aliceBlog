<?php namespace app\Model;

use AliceFrameWork\Example;

class TagModel
{
    private $example;
    
    public function __construct()
    {
        $this->example = new Example('info_tag');
    }
    
    public function getTagList($page)
    {
        return $this->example->Data()->where('', '')->order('num', 'DESC')->Paginate($page, 10);
    }
    
    public function getTagAll()
    {
        return $this->example->Data()->where('', '')->order('num', 'DESC')->get();
    }
    
    public function getTagByTag($tag)
    {
        return $this->example->Find('tag', $tag);
    }
    
    public function getTagById($id)
    {
        return $this->example->Find('id', $id);
    }
    
    public function editTag($id, $fields, $oldtag)
    {
        $tag = $this->example->Update($fields)->where('id', $id)->change();
        return $oldtag ? $this->editArticleTag($oldtag, $fields['tag']) : false;
    }
    
    public function setTag($fields)
    {
        return $this->example->Insert($fields)->change();
    }
    
    public function editArticleTag($oldtag, $newtag)
    {
        //可优化
        $result = $this->example->setBind('info_article')->Data('id')->where('tag', $oldtag, 'LIKE')->get();
        return $result ? $ret->Updates(array('tag'), array($this->UArray($result, $newtag)))->change() : true;
    }
    
    private function UArray($array, $newkey)
    {
        $new = array();
        foreach ($array as $k => $v) {
            $new[$v['id']] = $newkey;
        }
        return $new;
    }
    
    public function delTag($id)
    {
        $tag = $this->getTagById($id);
        $result = $this->example->Delete()->where('id', $id)->change();
        return $tag ? $this->editArticleTag($tag['tag'], '杂文') : false;
    }
    
}
