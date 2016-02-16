<?php

namespace app\Controller;

use app\Model\TagModel;
use AliceFrameWork\View;
use AliceFrameWork\Request;

class Tag{ 

   public static function tags(){
       
	    $ret = array();    
        $fields = Request::getRequest('page', 'int');        
        $page = isset($fields) && $fields > 0 ? $fields : 1;                      
        $ret['tagList'] = TagModel::getTagList($page);           
        $ret['pageNav'] = array_pop($ret['tagList']);
		View::Transmit('admin/tags',$ret);
          
   }
   
   public static function tag_edit($id){
	   
	    $ret = $fields =array();
	    $ret['tags'] = TagModel::getTagById($id);        
        if(Request::getRequest('dosubmit', 'str')){         
            $fields['tag'] = Request::getRequest('username', 'str');                       
            if($ret['tags']['tag'] == $fields['tag']) View::AdminErrorMessage('goback', '你未做修改！');           
			$result = TagModel::editTag($id,$fields,$ret['tags']['tag']);
			$result ? View::AdminMessage('admin/tags', '修改成功'): View::AdminErrorMessage('goback', '修改失败');
       }
	   View::Transmit('admin/tag_edit',$ret);      

   }
   
   public static function tag_delete($id){
	   
	    $result = TagModel::delTag($id);       
        $result ? View::AdminMessage('admin/tags', '删除成功'):View::AdminErrorMessage('goback', '删除失败');    
	   
   }








}