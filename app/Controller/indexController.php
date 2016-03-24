<?php

namespace app\Controller;

use AliceFrameWork\View;
use AliceFrameWork\Request;
use AliceFrameWork\Memcache;
use AliceFrameWork\weixin\WeixinClass;
use app\Model\IndexModel;
use app\Model\ArticleModel;

class indexController{
	
    public function index(){
		
	$fields = Request::getRequest('page', 'int');
        $page = isset($fields) && $fields > 0 ? $fields : 1;                    
        $mem = new Memcache();        
        $ret = $mem->get('indexController_index_'.$page);
        if(empty($ret)){	        
            $ret = array();                       
            $ret['articleList'] = IndexModel::getArticleList($page);
	    $ret['pushArticleList'] = IndexModel::getPushArticleList();
	    $ret['tagList'] = IndexModel::getTagList();
	    $ret['pushIndex'] = IndexModel::getPushIndex();               
            $ret['pageNav'] = array_pop($ret['articleList']);                                         
            $mem->set('indexController_index_'.$page,$ret);
        }        
        $ret['commentList'] = IndexModel::getCommentList();
	View::Transmit('newindex',$ret);        
			
    }
    
    public function search(){
        
        if(Request::getRequest('dosubmit', 'str')){
            $mem = new Memcache();        
            $ret = $mem->get('indexController_search');
            if(empty($ret)){
                 $ret = array();
                 $ret['pushArticleList'] = ArticleModel::getPushArticleList();            
                 $ret['newArticleList'] = ArticleModel::getNewArticleList();            
                 $ret['commentArticleList'] = ArticleModel::getCommentArticleList();
                 $mem->set('indexController_search',$ret,12*3600);
            }
            $ret['keyword'] = Request::getRequest('search', 'str'); 
            $ret['searchList'] = IndexModel::getSearchList($ret['keyword']);
            View::Transmit('search',$ret);
        }else{
            View::AdminErrorMessage('goback',"没有输入关键词！");
        }
        
    }
    
    public function weixin(){ //微信入口
        
        $wechatObj = new WeixinClass();
        if (!isset($_GET['echostr'])) {
            $wechatObj->responseMsg();
        }else{
            $wechatObj->valid();
        }
        
    }

}
