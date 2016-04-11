<?php namespace app\Controller;

use AliceFrameWork\View;
use AliceFrameWork\Request;

class articleshowController extends Controller
{
    public function index($id = '')
    {
        if ($id == '') {
            View::AdminErrorMessage('goback', '木有选择文章哦！');
        }
        $fields = Request::getRequest('page', 'int');
        $page = isset($fields) && $fields > 0 ? $fields : 1;
        $article = self::$models->Article;
        $comment = self::$models->Comment;
        $mem = self::$models->Memcache;
        $ret = $mem->get('articleshowController_index_id_' . $id);
        if (empty($ret)) {
            $ret = array();
            $ret['articleShow'] = $article->getArticleShow($id);
            if (empty($ret['articleShow'])) {
                NotFound();
            }
            $ret['articleShow']['tag'] = explode('|', $ret['articleShow']['tag']);
            $ret['articleRelevant'] = $article->getArticleRelevant($ret['articleShow']['mid'], $ret['articleShow']['id']);
            $ret['pushArticleList'] = $article->getPushArticleList();
            $ret['newArticleList'] = $article->getNewArticleList();
            $ret['commentArticleList'] = $article->getCommentArticleList();
            $mem->set('articleshowController_index_id_' . $id, $ret);
        }
        $ret['comments'] = $comment->getArticleCommentList($id, $page);
        if (!empty($ret['comments']['counts'])) {
            $ret['articleShow']['counts'] = array_pop($ret['comments']);
        }
        if (isset($ret['comments']['page'])) {
            $ret['articleShow']['commentPage_nav'] = array_pop($ret['comments']);
        }
        $article->updatePlus($id, 'clicks');
        //文章的点击数+1
        View::Transmit('articleshow', $ret);
    }
    
    public function addcomment()
    {
        if ('POST' != $_SERVER['REQUEST_METHOD']) {
            //这里做一个csrf攻击的防范，当然还可以加Referer的验证，如果要最安全还是得用token令牌
            header('Allow: POST');
            header('HTTP/1.1 405 Method Not Allowed');
            header('Content-Type: text/plain');
            die('Illegal request!');
        }
        $fields = array();
        $fields['contents'] = isset($_POST['comment']) ? trim($_POST['comment']) : null;
        $fields['cid'] = $tomail = isset($_POST['comment_parent']) ? trim($_POST['comment_parent']) : null;
        $fields['aid'] = isset($_POST['comment_post_ID']) ? intval($_POST['comment_post_ID']) : null;
        $fields['nickname'] = isset($_POST['author']) ? trim(strip_tags($_POST['author'])) : null;
        $fields['email'] = isset($_POST['email']) ? trim($_POST['email']) : null;
        $fields['website'] = isset($_POST['url']) ? trim($_POST['url']) : null;
        $fields['ctime'] = time();
        $fields['ip'] = Request::getClientIP();
        if (6 > strlen($fields['email']) || '' == $fields['nickname']) {
            AjaxError('请填写昵称和邮箱！');
        }
        if (!Is_email($fields['email'])) {
            AjaxError('请填写有效的邮箱地址！');
        }
        if ('' == $fields['contents']) {
            AjaxError('请写点评论！');
        }
        $comment = self::$models->Comment;
        //$comment->IpLimit($fields['ip']); //防止评论灌水攻击
        $comment->SelfXssattack(& $fields['contents']);
        //防止Xss攻击
        if (strstr($fields['cid'], '-')) {
            $parents = explode('-', $fields['cid']);
            $fields['cid'] = $parents[0];
            $tomail = $parents[1];
            $commentp = $comment->getOneComment('id', $tomail);
            $fields['parent'] = $commentp ? $commentp['id'] . ',' . $commentp['nickname'] : '';
            $fidname = '<a href="#comment-' . $commentp['id'] . '" rel="nofollow" class="cute">@' . $commentp['nickname'] . '</a>';
        } elseif (!empty($fields['cid'])) {
            $commentp = $comment->getOneComment('id', $fields['cid']);
            $fields['parent'] = $commentp ? $commentp['id'] . ',' . $commentp['nickname'] : '';
            $fidname = '<a href="#comment-' . $commentp['id'] . '" rel="nofollow" class="cute">@' . $commentp['nickname'] . '</a>';
        } else {
            $fields['parent'] = '';
            $fidname = '';
        }
        $result = $comment->InsertComment($fields);
        if (!$result) {
            AjaxError('评论添加失败，多次失败请联系站长！');
        } else {
            $comment->Ifuser($fields['nickname'], $fields['email'], $fields['website']);
            //记录游客信息
            if (EMAIL_SENT_FOR_REPLY && $fields['cid'] > 0 && !empty($commentp)) {
                $comment->SendMail(self::$models->SmtpMail, $tomail, $fields['contents'], $commentp);
            }
            //邮件
            $toid = empty($commentp) ? '#' : $commentp['id'];
            echo '<li class="comment even thread-even depth-1 clearfix" id="comment-' . $toid . '><span class="comt-f"></span> ';
            echo '  <div class="c-avatar"><img alt=\'\' src=\'' . IMG_TXING . '\' class=\'avatar avatar-50 photo\' height=\'50\' width=\'50\' /><div class="c-main" id="div-comment-' . $toid . '>';
            echo '     <p style="color:#8c8c8c;"><span class="c-author">' . $fields['nickname'] . '</span></p><p>' . $fidname . EmojiH($fields['contents']) . '</p>';
            echo '        <div class="c-meta">' . wordTime($fields['ctime']) . ' (' . date('Y-m-d H:i:s', $fields['ctime']) . ')';
            echo '</div></div></div></li>';
        }
    }
    
    public function scoreajax()
    {
        if ('POST' != $_SERVER['REQUEST_METHOD']) {
            header('Allow: POST');
            header('HTTP/1.1 405 Method Not Allowed');
            header('Content-Type: text/plain');
            die('Illegal request!');
        }
        $fields = array();
        $fields['action'] = isset($_POST['action']) ? intval($_POST['action']) : null;
        $fields['um_action'] = isset($_POST['um_action']) ? trim($_POST['um_action']) : null;
        $fields['um_id'] = isset($_POST['um_id']) ? intval($_POST['um_id']) : null;
        $data = array();
        $addScore = Request::getCookie('add_score_' . $fields['um_id']);
        //判断是否24小时内已经投过了。cookie判断，伪验证!安全点就使用ip验证。
        if (!empty($addScore) && $addScore - time() <= 86400) {
            AjaxError('24小时内只能投一次');
        }
        Request::setCookie('add_score_' . $fields['um_id'], time(), time() + 86400);
        $article = self::$models->Article;
        if ($fields['um_action'] == 'ding') {
            $result = $article->updatePlus($fields['um_id'], 'good_num');
        } elseif ($fields['um_action'] == 'xu') {
            $result = $article->updatePlus($fields['um_id'], 'bad_num');
        }
        echo $result ? $fields['action'] + 1 : '不明所以的失败了...';
    }
    
}
