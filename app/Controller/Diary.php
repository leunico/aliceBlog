<?php

namespace app\Controller;

use app\Model\DiaryModel;
use AliceFrameWork\View;
use AliceFrameWork\Request;

class Diary{ 
          
   public static function timewaits(){
       
	$ret = array();    
        $fields = Request::getRequest('page', 'int');        
        $page = isset($fields) && $fields > 0 ? $fields : 1;                      
        $ret['timewaitList'] = DiaryModel::getTimewaitList($page);           
        $ret['pageNav'] = array_pop($ret['timewaitList']);
	View::Transmit('admin/timewait',$ret);
          
   }
    
   public static function timewait_add(){
             
        if(Request::getRequest('dosubmit', 'str')){            
            $fields = array();            
            $fields['order'] = Request::getRequest('order', 'int');
            $fields['classfa'] = Request::getRequest('classfa', 'str');
            $fields['content'] = Request::getRequest('content', 'str');            
            $fields['time'] = Request::getRequest('time', 'str');            
            $fields['ctime'] = time();			           
	    $fields['img'] = DiaryModel::setTimewaitImg($_FILES['img']);
	    if($fields['img'] == false)  View::AdminErrorMessage('goback', '图片上传错误或没有上传图片！');           
            $result = DiaryModel::setTimewait($fields);           
            $result ? View::AdminMessage('admin/timewaits', '添加成功'): View::AdminErrorMessage('goback', '添加失败');           
        }
        View::Transmit('admin/timewait_add');
		              
   }
    
   public static function timewait_delete($id){
       
        $result = DiaryModel::delTimewait($id);       
        $result ? View::AdminMessage('admin/timewaits', '删除成功'):View::AdminErrorMessage('goback', '删除失败');          
                
   }
    
   public static function timewait_edit($id){
       
	$ret = $fields = array(); 
        $ret['timewaits'] = DiaryModel::getOneTimewait($id); 
        if(Request::getRequest('dosubmit', 'str')){                     
            $fields['order'] = Request::getRequest('order', 'int');
            $fields['classfa'] = Request::getRequest('classfa', 'str');
            $fields['content'] = Request::getRequest('content', 'str');            
            $fields['time'] = Request::getRequest('time', 'str');           
            if(!empty($_FILES['img']['name'])){
            	$fields['img'] = DiaryModel::setTimewaitImg($_FILES['img']);
		if($fields['img']){
			DiaryModel::delTimewaitImg($ret['timewaits']['img']);
		}else{
			View::AdminErrorMessage('goback','图片上传错误或没有上传图片！');
		}
            }          
            $result = DiaryModel::editTimewait($id,$fields);
            $result ? View::AdminMessage('admin/timewaits', '修改成功') : View::AdminErrorMessage('goback', '修改失败');           
        }
        View::Transmit('admin/timewait_edit',$ret);
        
    }
	
    public static function pushs(){
		 
	$ret = array();
	$ret['pushs'] = DiaryModel::getPushList();
	if(Request::getRequest('dosubmit', 'str')){                 
            $pushimg =  Request::getRequest('pushimg', 'array');            
            $pushurl =  Request::getRequest('pushurl', 'array');            
	    $result = DiaryModel::editPush($pushurl,$pushimg,$_FILES['doc']);             
	    $result ? View::AdminMessage('admin/pushs', '修改成功') : View::AdminErrorMessage('goback', '修改失败');           
        }          
	View::Transmit('admin/pushs',$ret);
		
    }
    
    public static function setorder(){
        
        $id = ( isset($_GET['id']) ) ? intval($_GET['id']) : null;
        $type = ( isset($_GET['type']) ) ? trim($_GET['type']) : null;
        if(isset($id) && isset($type)){            
            $order = DiaryModel::updateOrder($id,$type); 
            if($order){
               $neworder = DiaryModel::getOneTimewait($id); 
               return $neworder['order']; 
            }else{
               return "error";   
            }            
        }
    }
   
}
