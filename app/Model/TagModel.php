<?php

namespace app\Model;

use AliceFrameWork\Example;

class TagModel{
	
	private static $_table = 'info_tag';
	
	public static function getTagList($page){
		
		$ret = new Example(self::$_table);
		return $ret->Data()->where('','')->order('num','DESC')->Paginate($page,10);
		
	}
    
    public static function getTagAll(){
        
        $ret = new Example(self::$_table);
		return $ret->Data()->where('','')->order('num','DESC')->get();
        
    }
	
	public static function getTagByTag($tag){
		
		$ret = new Example(self::$_table);
		return $ret->Find('tag',$tag);
		
	}
	
	public static function getTagById($id){
		
		$ret = new Example(self::$_table);
		return $ret->Find('id',$id);
		
	}
	
	public static function editTag($id,$fields,$oldtag){
	    	
		$ret = new Example(self::$_table);		
		$tag = $ret->Update($fields)->where('id',$id)->change();
		return $tag ? self::editArticleTag($oldtag,$fields['tag']) : false;
	}
	
	public static function setTag($fields){
		
		$ret = new Example(self::$_table);
		return $ret->Insert($fields)->change();
		
	}
	
	public static function editArticleTag($oldtag,$newtag){ //待修复
		
		$ret = new Example('info_article');
		$result = $ret->Data('id')->where('tag',$oldtag,'LIKE')->get();
		return $result ? $ret->Updates(array('tag'),array(self::UArray($result,$newtag)))->change() : true;
		
	}
	
	private static function UArray($array,$newkey){
		
		$new = array();
		foreach($array as $k=>$v){
			   $new[$v['id']] = $newkey;			
		}
		return $new;
	}
	
	public static function delTag($id){
		
		$ret = new Example(self::$_table);
		$tag = self::getTagById($id);
		$result = $ret->Delete()->where('id',$id)->change();
		return $tag ? self::editArticleTag($tag['tag'],'杂文') : false;
		
	}
	
	
}