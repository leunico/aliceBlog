<?php namespace app\Controller;

use AliceFrameWork\View;
use AliceFrameWork\Request;

class Diary extends Controller
{
    public static function timewaits()
    {
        $ret = array();
        $fields = Request::getRequest('page', 'int');
        $page = isset($fields) && $fields > 0 ? $fields : 1;
        $diary = self::$models->Diary;
        $ret['timewaitList'] = $diary->getTimewaitList($page);
        $ret['pageNav'] = array_pop($ret['timewaitList']);
        View::Transmit('admin/timewait', $ret);
    }
    
    public static function timewait_add()
    {
        if (Request::getRequest('dosubmit', 'str')) {
            $fields = array();
            $diary = self::$models->Diary;
            $fields['order'] = Request::getRequest('order', 'int');
            $fields['classfa'] = Request::getRequest('classfa', 'str');
            $fields['content'] = Request::getRequest('content', 'str');
            $fields['time'] = Request::getRequest('time', 'str');
            $fields['ctime'] = time();
            $fields['img'] = $diary->setTimewaitImg(self::$models->make('Qiniu', array('alice')), $_FILES['img']);
            if (empty($fields['img'])) {
                View::AdminErrorMessage('goback', '图片上传错误或没有上传图片！');
            }
            $result = $diary->setTimewait($fields);
            $result ? View::AdminMessage('admin/timewaits', '添加成功') : View::AdminErrorMessage('goback', '添加失败');
        }
        View::Transmit('admin/timewait_add');
    }
    
    public static function timewait_delete($id)
    {
        $diary = self::$models->Diary;
        $result = $diary->delTimewait(self::$models->make('Qiniu', array('alice')), $id);
        $result ? View::AdminMessage('admin/timewaits', '删除成功') : View::AdminErrorMessage('goback', '删除失败');
    }
    
    public static function timewait_edit($id)
    {
        $ret = $fields = array();
        $diary = self::$models->Diary;
        $image = self::$models->make('Qiniu', array('alice'));
        $ret['timewaits'] = $diary->getOneTimewait($id);
        if (Request::getRequest('dosubmit', 'str')) {
            $fields['order'] = Request::getRequest('order', 'int');
            $fields['classfa'] = Request::getRequest('classfa', 'str');
            $fields['content'] = Request::getRequest('content', 'str');
            $fields['time'] = Request::getRequest('time', 'str');
            if (!empty($_FILES['img']['name'])) {
                $fields['img'] = $diary->setTimewaitImg($image, $_FILES['img']);
                $fields['img'] ? $diary->delTimewaitImg($image, $ret['timewaits']['img']) : View::AdminErrorMessage('goback', '图片上传失败！');
            } else {
                View::AdminErrorMessage('goback', '请添加图片！');
            }
            $result = $diary->editTimewait($id, $fields);
            $result ? View::AdminMessage('admin/timewaits', '修改成功') : View::AdminErrorMessage('goback', '修改失败');
        }
        View::Transmit('admin/timewait_edit', $ret);
    }
    
    public static function pushs()
    {
        $ret = array();
        $diary = self::$models->Diary;
        $ret['pushs'] = $diary->getPushList();
        if (Request::getRequest('dosubmit', 'str')) {
            $pushimg = Request::getRequest('pushimg', 'array');
            $pushurl = Request::getRequest('pushurl', 'array');
            $result = $diary->editPush(self::$models->make('Qiniu', array('alice')), $pushurl, $pushimg, $_FILES['doc']);
            $result ? View::AdminMessage('admin/pushs', '修改成功') : View::AdminErrorMessage('goback', '修改失败');
        }
        View::Transmit('admin/pushs', $ret);
    }
    
    public static function setorder()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : null;
        $type = isset($_GET['type']) ? trim($_GET['type']) : null;
        $diary = self::$models->Diary;
        if (isset($id) && isset($type)) {
            $order = $diary->updateOrder($id, $type);
            if ($order) {
                $neworder = $diary->getOneTimewait($id);
                return $neworder['order'];
            } else {
                return 'error';
            }
        }
    }
    
}
