<?php namespace app\Model;

use AliceFrameWork\Example;

class DiaryModel
{
    private $example;
    
    public function __construct()
    {
        $this->example = new Example('info_time');
    }
    
    public function getTimewaitList($page)
    {
        return $this->example->Data()->where('', '')->order('order', 'ASC')->Paginate($page, 10);
    }
    
    public function getOneTimewait($id)
    {
        return $this->example->Find('id', $id);
    }
    
    public function setTimewait($fields)
    {
        return $this->example->Insert($fields)->change();
    }
    
    public function editTimewait($id, $fields)
    {
        return $this->example->Update($fields)->where('id', $id)->change();
    }
    
    public function setTimewaitImg($Img, $image)
    {
        $category = YUN_IMAGE ? '?imageView2/1/w/120/h/120' : '@base@tag=imgScale&q=85&w=120';
        if (empty($image['error'])) {
            $name = 'tw_' . rand(100, 999) . time() . '.jpg';
            return $Img->PutImgFile($name, $image['tmp_name'], $category);
        } else {
            return false;
        }
    }
    
    public function delTimewait($Img, $id)
    {
        $Timg = $this->getOneTimewait($id);
        $this->delTimewaitImg($Img, $Timg['img']);
        return $this->example->Delete()->where('id', $id)->change();
    }
    
    public function getTimewiatIndex()
    {
        return $this->example->Data()->where('', '')->order('order', 'ASC')->get(30);
    }
    
    public function delTimewaitImg($thumb, $fileurl)
    {
        if (YUN_IMAGE) {
            $qiniuimg = explode('/', $fileurl);
            $img = explode('?', $qiniuimg[3]);
            $thumb->Delete($img[0]);
        } else {
            $jinshanimg = explode('/', $fileurl);
            $img = explode('@', $jinshanimg[3]);
            $thumb->Delete(array($img[0]));
        }
    }
    
    public function getPushList()
    {
        return $this->example->setBind('info_indexpush')->Data()->where('', '')->order('utime', 'DESC')->get(4);
    }
    
    public function editPush($Img, $pushurl, $pushimg, $doc)
    {
        $category = YUN_IMAGE ? '?imageView2/1/w/810/h/200' : '@base@tag=imgScale&q=85&w=810&h=200&m=0&c=1';
        foreach ($doc['name'] as $k => $file) {
            if (empty($doc['error'][$k]) && !empty($file)) {
                $filename = explode('.', $file);
                $filename[0] = 'push_' . date('ymdHis');
                $giftpicname = implode('.', $filename);
                $tmp_name = $doc['tmp_name'][$k];
                $pushimg[$k] = $Img->PutImgFile($giftpicname, $tmp_name, $category);
            }
        }
        return $this->example->setBind('info_indexpush')->Updates(array('pushurl', 'pushimg'), array($this->UArray($pushurl), $this->UArray($pushimg)))->change();
    }
    
    public function UArray($array = array())
    {
        $new = array();
        foreach ($array as $k => $v) {
            $new[$k + 1] = $v;
        }
        return $new;
    }
    
    public function updateOrder($id, $type)
    {
        return $this->example->query('UPDATE info_time SET `order` = `order` ' . $type . " 1 WHERE id={$id}");
    }
    
}
