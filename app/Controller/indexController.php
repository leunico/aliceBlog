<?php namespace app\Controller;

use AliceFrameWork\View;
use AliceFrameWork\Request;

class indexController extends Controller
{
    public function index()
    {
        $fields = Request::getRequest('page', 'int');
        $page = isset($fields) && $fields > 0 ? $fields : 1;
        $mem = self::$models->Memcache;
        $index = self::$models->Index;
        $ret = $mem->get('indexController_index_' . $page);
        if (empty($ret)) {
            $ret = array();
            $ret['articleList'] = $index->getArticleList($page);
            $ret['pushArticleList'] = $index->getPushArticleList();
            $ret['tagList'] = $index->getTagList();
            $ret['pushIndex'] = $index->getPushIndex();
            $ret['pageNav'] = array_pop($ret['articleList']);
            $mem->set('indexController_index_' . $page, $ret);
        }
        $ret['commentList'] = $index->getCommentList();
        View::Transmit('newindex', $ret);
    }
    
    public function search()
    {
        if (Request::getRequest('dosubmit', 'str')) {
            $mem = self::$models->Memcache;
            $index = self::$models->Index;
            $article = self::$models->Article;
            $ret = $mem->get('indexController_search');
            if (empty($ret)) {
                $ret = array();
                $ret['pushArticleList'] = $article->getPushArticleList();
                $ret['newArticleList'] = $article->getNewArticleList();
                $ret['commentArticleList'] = $article->getCommentArticleList();
                $mem->set('indexController_search', $ret, 12 * 3600);
            }
            $ret['keyword'] = Request::getRequest('search', 'str');
            $ret['searchList'] = $index->getSearchList($ret['keyword']);
            View::Transmit('search', $ret);
        } else {
            View::AdminErrorMessage('goback', '没有输入关键词！');
        }
    }
    
    public function weixin()
    {
        //微信入口
        $wechatObj = self::$models->WeixinClass;
        if (!isset($_GET['echostr'])) {
            $wechatObj->responseMsg();
        } else {
            $wechatObj->valid();
        }
    }
    
}
