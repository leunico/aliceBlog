<?php

namespace app\Model;

use AliceFrameWork\Example;

class UserModel{
	
	private static $_table = 'admin_user';
	
	public static function getUserList($page){
		
		$ret = new Example(self::$_table);
		return $ret->Data('a.* ,COUNT(b.id) AS count')->Join('info_article','LEFT','a.id=b.uid')->where('','')->group('a.id')->order(array('count','ctime'),array('DESC','DESC'))->Paginate($page,10);				
		
	}
	
	public static function setUserBlock($id,$fields){
		
		$ret = new Example(self::$_table);
		return $ret->Update($fields)->where('id',$id)->change();
		
	}
	
	public static function InsertUser($fields){
		
		$ret = new Example(self::$_table);
		return $ret->Insert($fields)->change();	
			
	}
	
	public static function delUser($id){
		
		$ret = new Example(self::$_table);
		return $ret->Delete()->where('id',$id)->change();
		
	}
	
	public static function getOneUser($type,$val){
		
		$ret = new Example(self::$_table);
		return $ret->Find($type,$val);
		
	}
	
	public static function editUser($id,$fields){
		
		$ret = new Example(self::$_table);
		return $ret->Update($fields)->where('id',$id)->change();
		
	}
	
	public static function editArticleAuthor($username,$id){
		
		$ret = new Example('info_article');
		return $ret->Update(array('author'=>$username))->where('uid',$id)->change();
						
	}
    
    public static function getweixinUser($scene_id){
        
        $ret = new Example('weixin_user');
		return $ret->Find('scene_id',$scene_id);
        
    }
    
    public static function delweixinUser($scene_id){
        
        $ret = new Example('weixin_user');
		return $ret->Delete()->where('scene_id',$scene_id)->change();
        
    }	
	
	
}