<?php 

namespace app\Controller;

use AliceFrameWork\View;
use AliceFrameWork\Request;
use AliceFrameWork\Memcache;
use app\Model\TagModel;
use app\Model\ArticleModel;

class tagController{
    	
	 public function index($id=''){
        
        if($id == '') View::AdminErrorMessage('goback', '非法入口！Go Die');        
        $fields = Request::getRequest('page', 'int');
        $page = isset($fields) && $fields > 0 ? $fields : 1;          
        $mem = new Memcache();        
        $ret = $mem->get('tagController_index_'.$id.'_'.$page);
        if(empty($ret)){            
            $ret = array();
            $ret['tag'] = TagModel::getTagById($id);
            if(empty($ret['tag'])) NotFound();           
            $ret['tagarticleShow'] = ArticleModel::getArticleTagShow($ret['tag']['tag'],$page);
            $ret['pageNav'] = @array_pop($ret['tagarticleShow']);          
            $ret['pushArticleList'] = ArticleModel::getPushArticleList();            
            $ret['newArticleList'] = ArticleModel::getNewArticleList();            
            $ret['commentArticleList'] = ArticleModel::getCommentArticleList();
            $mem->set('tagController_index_'.$id.'_'.$page,$ret,12*3600);
        }      
        View::Transmit('tagshow',$ret);
		
	}
    
    #>>>标签展示页
    public function showall(){ 
        
        $mem = new Memcache();        
        $ret = $mem->get('tagController_showall');
        if(empty($ret)){                 
            $ret = array();
            $ret['Tagall'] = TagModel::getTagAll();
            $mem->set('tagController_showall',$ret,12*3600);            
        }   
        View::Transmit('tagallshow',$ret);

    }
    
    #>>>文章展示页文字入口
    public function articletag($tag=''){
        
        if(!empty($tag)){
            $tag = iconv("gbk","utf-8",urldecode($tag)); 
        }else{
            View::AdminErrorMessage('goback', '非法入口！Go Die'); 
        }                      
        $ret = TagModel::getTagByTag($tag);
        empty($ret) ? $this->index(1) : $this->index($ret['id']);
                
    }
    
    
    
	
}