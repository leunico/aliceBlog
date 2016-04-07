<?php namespace app\Controller;

use AliceFrameWork\View;
use AliceFrameWork\Request;

class Comment extends Controller
{
    public static function comment_delete($id)
    {
        $comment = self::$models->Comment;
        $result = $comment->delComment($id);
        $result ? View::AdminMessage('admin/comments', '删除成功') : View::AdminErrorMessage('goback', '删除失败');
    }
    
    public static function comment_edit($id)
    {
        $ret = $fields = array();
        $comment = self::$models->Comment;
        $ret['comments'] = $comment->getOneComment('id', $id);
        if (Request::getRequest('dosubmit', 'str')) {
            $fields['nickname'] = Request::getRequest('nickname', 'str');
            $fields['contents'] = Request::getRequest('contents', 'str');
            $fields['website'] = Request::getRequest('website', 'str');
            if ($ret['comments']['contents'] == $fields['contents'] && $ret['comments']['website'] == $fields['website'] && $ret['comments']['nickname'] == $fields['nickname']) {
                View::AdminErrorMessage('goback', '你未做修改！');
            }
            $result = $comment->editComment($id, $fields);
            $result ? View::AdminMessage('admin/comments', '修改成功') : View::AdminErrorMessage('goback', '修改失败');
        }
        View::Transmit('admin/comment_edit', $ret);
    }
    
    public static function comments()
    {
        $fields = Request::getRequest('page', 'int');
        $page = isset($fields) && $fields > 0 ? $fields : 1;
        $ret = $scree = array();
        $comment = self::$models->Comment;
        if (Request::getRequest('keyword', 'str') && Request::getRequest('keyword_type', 'str')) {
            $scree['keyword'] = Request::getRequest('keyword', 'str');
            $scree['keyword_type'] = Request::getRequest('keyword_type', 'str');
            $ret['CommentList'] = $comment->getCommentList($page, $scree);
        } elseif (!empty(Request::getRequest('aid', 'int'))) {
            $scree['keyword'] = Request::getRequest('aid', 'int');
            $scree['keyword_type'] = 'aid';
            $ret['CommentList'] = $comment->getCommentList($page, $scree);
        } else {
            $ret['CommentList'] = $comment->getCommentList($page);
        }
        $ret['scree'] = $scree;
        $ret['pageNav'] = @array_pop($ret['CommentList']);
        View::Transmit('admin/comments', $ret);
    }
    
}
