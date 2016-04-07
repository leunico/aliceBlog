<?php namespace app\Controller;

use AliceFrameWork\View;
use AliceFrameWork\Request;

class tagController extends Controller
{
    public function index($id = '')
    {
        if ($id == '') {
            View::AdminErrorMessage('goback', '非法入口！Go Die');
        }
        $fields = Request::getRequest('page', 'int');
        $page = isset($fields) && $fields > 0 ? $fields : 1;
        $article = self::$models->Article;
        $tag = self::$models->Tag;
        $mem = self::$models->Memcache;
        $ret = $mem->get('tagController_index_' . $id . '_' . $page);
        if (empty($ret)) {
            $ret = array();
            $ret['tag'] = $tag->getTagById($id);
            if (empty($ret['tag'])) {
                NotFound();
            }
            $ret['tagarticleShow'] = $article->getArticleTagShow($ret['tag']['tag'], $page);
            $ret['pushArticleList'] = $article->getPushArticleList();
            $ret['newArticleList'] = $article->getNewArticleList();
            $ret['commentArticleList'] = $article->getCommentArticleList();
            $ret['pageNav'] = @array_pop($ret['tagarticleShow']);
            $mem->set('tagController_index_' . $id . '_' . $page, $ret, 12 * 3600);
        }
        View::Transmit('tagshow', $ret);
    }
    
    #>>>标签展示页
    public function showall()
    {
        $mem = self::$models->Memcache;
        $tag = self::$models->Tag;
        $ret = $mem->get('tagController_showall');
        if (empty($ret)) {
            $ret = array();
            $ret['Tagall'] = $tag->getTagAll();
            $mem->set('tagController_showall', $ret, 12 * 3600);
        }
        View::Transmit('tagallshow', $ret);
    }
    
    #>>>文章展示页文字入口
    public function articletag($tagurl = '')
    {
        $tag = self::$models->Tag;
        if (!empty($tagurl)) {
            $tagurl = iconv('gbk', 'utf-8', urldecode($tag));
        } else {
            View::AdminErrorMessage('goback', '非法入口！Go Die');
        }
        $ret = $tag->getTagByTag($tagurl);
        empty($ret) ? $this->index(1) : $this->index($ret['id']);
    }
    
}
