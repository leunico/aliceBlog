<?php

namespace app\Model;

use AliceFrameWork\Example;
use AliceFrameWork\Memcache;
use AliceFrameWork\Request;
use AliceFrameWork\View;

class AdminModel{
		
	public static function getByUser($email){
	   
		$ret = new Example('admin_user');
		return $ret->Find('email',$email);
	}
	
	public static function getByUserId($id){
	   
		$ret = new Example('admin_user');
		return $ret->Find('id',$id);
	}
	
	public static function getByArticleId($id){
	   
		$ret = new Example('info_article');
		return $ret->Find('id',$id,'uid');
	}
	
	public static function MemUpdata(){
		
		$lasttime = Request::getSession('MemacheData') ? Request::getSession('MemacheData'):1444895435;       
        if(time() < ($lasttime + 5)){            
            View::AdminErrorMessage('goback', '操作过于频繁');           
        }else{                     
            if(MEMCACHE == TRUE){
                $mem = new Memcache();               
                $mem->clear(); 
            }else{
                View::AdminErrorMessage('goback', '网站未开启缓存');	   
            }
            Request::setSession('MemacheData', time());
       }
       View::AdminMessage('goback', "缓存更新成功!"); 
		
	}
	
	public static function MemClear(){
		
	   if(MEMCACHE == TRUE){
		   $mem = new Memcache();               
		   $mem->clear(); 
	   }else{
		   return FALSE;
	   }
		
    }
	
}