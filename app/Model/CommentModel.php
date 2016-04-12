<?php namespace app\Model;

use AliceFrameWork\Example;
use AliceFrameWork\Request;

class CommentModel
{
    private $example;
    
    public function __construct()
    {
        $this->example = new Example('info_comment');
    }
    
    public function getCommentList($page, $scree = array())
    {
        if (empty($scree)) {
            return $this->example->Data('a.*,b.title')->Join('info_article', 'LEFT', 'a.aid=b.id')->where('', '')->order('ctime', 'DESC')->Paginate($page, 15);
        } else {
            if ($scree['keyword_type'] == 'aid') {
                $whereleft = 'aid';
                $whereright = intval($scree['keyword']);
                $key = '=';
            } else {
                $whereleft = $scree['keyword_type'];
                $whereright = '%' . $scree['keyword'] . '%';
                $key = 'LIKE';
            }
            return $this->example->Data('a.*,b.title')->Join('info_article', 'INNER', 'a.aid=b.id')->where($whereleft, $whereright, $key)->order('ctime', 'DESC')->Paginate($page, 15);
        }
    }
    
    public function getArticleCommentList($id, $page)
    {
        $pagesize = 10;
        $result = $this->example->Data()->where(array('aid', 'cid'), array($id, 0))->order('ctime', 'DESC')->Pageindex($page, $pagesize, true);
        return $result ? $this->CommentArray($result, $page, $pagesize) : '';
    }
    
    private function CommentArray($ret, $page, $pagesize)
    {
        $pagenav = $ret['page'] ? $ret['page'] : '';
        unset($ret['page']);
        $counts = $ret['counts'] ? $ret['counts'] : 0;
        unset($ret['counts']);
        $kidid = $data = array();
        $i = $counts - ($page - 1) * $pagesize;
        foreach ($ret as $k => $v) {
            $kidid[] = $v['id'];
            $v['louc'] = $i--;
            $data[$v['id']] = $v;
        }
        $cidid = implode('\',\'', $kidid);
        $kid = self::getCommentInCid('cid', $cidid);
        foreach ($kid as $key => $val) {
            if (!empty($val['parent'])) {
                $parents = explode(',', $val['parent']);
                $val['pid'] = $parents[0];
                $val['pnickname'] = $parents[1];
            }
            unset($val['parent']);
            foreach ($data as $k => $v) {
                if ($val['cid'] == $k) {
                    $data[$k]['son'][] = $val;
                }
            }
        }
        $data['page'] = $pagenav;
        $data['counts'] = $counts;
        return $data;
    }
    
    public function getCommentInCid($type, $value)
    {
        return $this->example->Data()->where($type, $value, 'IN')->order('ctime', 'DESC')->get();
    }
    
    public function getOneComment($type, $id)
    {
        return $this->example->Find($type, $id);
    }
    
    public function InsertComment($fields)
    {
        return $this->example->Insert($fields)->change();
    }
    
    public function editComment($id, $fields)
    {
        return $this->example->Update($fields)->where('id', $id)->change();
    }
    
    public function delComment($id)
    {
        return $this->example->Delete()->where('id', $id)->change();
    }
    
    public function SelfXssattack($content)
    {
        //$content = htmlspecialchars_decode($content);这是简单处理...
        preg_replace('#script>#', 'xsscript>', $content);
    }
    
    public function SendMail($smtp, $commentcon, $comment)
    {
        if (!Is_email($comment['email'])) {
            return FALSE;
        }
        $url = HTTP_ROOT . 'articleshow/' . $comment['aid'] . '#comments-' . $comment['id'];
        $title = 'Hi，您在 【' . PROJECT_NAME . '】 的留言有人回复啦！';
        $content = $comment['nickname'] . ', 您好!</br>
	        您曾在' . PROJECT_NAME . '博客上的评论：' . $comment['contents'] . '</br>
	        有人给您的回应： ' . $commentcon . '</br>
	        点击查看回应完整內容：<a herf="' . htmlspecialchars($url) . '">点我跳转</a></br>
	        欢迎再次来访!</br>
	        (此邮件由系统自动发出，请勿回复！)';
        $smtp->send($comment['email'], $title, $content);
    }
    
    public function Ifuser($nickname, $email, $url)
    {
        $auth = $this->Usercookie($nickname, $email, $url);
        if (empty($auth)) {
            Request::setCookie('comment_author_username', $nickname, time() + 86400 * 3);
            Request::setCookie('comment_author_email', $email, time() + 86400 * 3);
            Request::setCookie('comment_author_url', $url, time() + 86400 * 3);
        }
    }
    
    public function Usercookie($nickname, $email, $url)
    {
        $comment = array();
        $comment['Au'] = Request::getCookie('comment_author_username');
        $comment['Em'] = Request::getCookie('comment_author_email');
        $comment['Ur'] = Request::getCookie('comment_author_url');
        if (empty($comment['Au']) || empty($comment['Em'])) {
            return '';
        }
        if ($comment['Au'] !== $nickname || $comment['Em'] !== $email || $comment['Ur'] !== $url) {
            return '';
        } else {
            return $comment;
        }
    }
    
    public function IpLimit($ip)
    {
        //Cookie伪验证，如果要真实验证需配合数据库或Memcache
        $addComment = Request::getCookie('comment_ip');
        if (isset($addComment)) {
            $count = Request::getCookie('comment_ip_comments');
            if ($count > 20) {
                AjaxError('sorry..每天评论不能超过12条');
            } else {
                Request::setCookie('comment_ip_comments', $count + 1, time() + 86400);
            }
        } else {
            Request::setCookie('comment_ip', $ip, time() + 86400);
            Request::setCookie('comment_ip_comments', 1, time() + 86400);
        }
    }
    
}
