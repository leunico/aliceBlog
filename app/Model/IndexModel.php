<?php

namespace app\Model;

use AliceFrameWork\Example;

class IndexModel{
	
	private static $_table = 'info_article';
	
	public static function getArticleList($page){
		
		$ret = new Example(self::$_table);
		return $ret->Data('a.* ,COUNT(b.id) AS comcount')->Join('info_comment','LEFT','a.id=b.aid')->where('','')->group('a.id')->order(array('top','ctime'),array('DESC','DESC'))->Pageindex($page,10);
	
	}
	
	public static function getPushArticleList(){
		
		$ret = new Example(self::$_table);
		return $ret->Data('id,image,title,mid,author')->where('recommend_type',2)->order(array('good_num','ctime'),array('DESC','DESC'))->get(6);
		
	}
    
        public static function getSearchList($fields){
        
        	$ret = new Example(self::$_table);
        	return $ret->Data()->where(array('title','description'),array("%$fields%","%$fields%"),array('LIKE','LIKE'),'OR')->order('ctime','DESC')->get(20);
        
        }
	
	public static function getTagList(){
		
		$ret = new Example('info_tag');
		return $ret->Data()->where('','')->order('num','DESC')->get(15);
		
	}
	
	public static function getPushIndex(){
		
		$ret = new Example('info_indexpush');
		return $ret->Data()->where('','')->order('utime','DESC')->get(4);
		
	}
	
	public static function getCommentList(){
		
		$ret = new Example('info_comment');
		return $ret->Data('a.*,b.title')->Join(self::$_table,'INNER','a.aid=b.id')->where('','')->order('ctime','DESC')->get(5);
		
	}	
	
}
