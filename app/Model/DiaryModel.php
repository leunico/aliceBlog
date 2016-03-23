<?php

namespace app\Model;

use AliceFrameWork\Example;
use AliceFrameWork\JinShan;

class DiaryModel{
	
	private static $_table = 'info_time';
	
	public static function getTimewaitList($page){
		
		$ret = new Example(self::$_table);
		return $ret->Data()->where('','')->order('order','ASC')->Paginate($page,10);
		
	}
	
	public static function getOneTimewait($id){
		
		$ret = new Example(self::$_table);
		return $ret->Find('id',$id);
		
	}
	
	public static function setTimewait($fields){
		
		$ret = new Example(self::$_table);
		return $ret->Insert($fields)->change();		
	}
	
	public static function editTimewait($id,$fields){
		
		$ret = new Example(self::$_table);
		return $ret->Update($fields)->where('id',$id)->change();
		
	}
	
	public static function setTimewaitImg($image){
		
		if(empty($image['error'])){
		   $Img = new JinShan();
		   $name = "Timewait_".rand(100,999).time().'.jpg';
		   return $Img->PutImgFile($name,$image['tmp_name'],120);
		}else{
		   return false;	
		}
		
	}
	
	public static function delTimewait($id){
	
	        $ret = new Example(self::$_table);
		$Timg = self::getOneTimewait($id);
		self::delTimewaitImg($Timg['img']);
		return $ret->Delete()->where('id',$id)->change();	
		
	}
    
        public static function getTimewiatIndex(){
        
         	$ret = new Example(self::$_table);
        	return $ret->Data()->where('','')->order('order','ASC')->get(30);
        
        }
	
	public static function delTimewaitImg($fileurl){
	
	    	$Img = new JinShan();
		$jinshanimg = explode('/',$fileurl);
		$img = explode('@',$jinshanimg[3]);
		return $Img->Delete(array($img[0]));	
		
	}
	
	public static function getPushList(){
		
		$ret = new Example('info_indexpush');
		return $ret->Data()->where('','')->order('utime','DESC')->get(4);
		
	}
	
	public static function editPush($pushurl,$pushimg,$doc){
		
		$ret = new Example('info_indexpush');
		$Img = new JinShan();
		foreach($doc['name'] as $k=>$file){
			if(empty($doc['error'][$k]) && !empty($file)){
			    $filename = explode(".",$file);
                   	    $filename[0]="Push_".date("ymdHis");
                            $giftpicname=implode(".",$filename);
                            $tmp_name = $doc['tmp_name'][$k]; 	 
			    $pushimg[$k] = $Img->PutImgFile($giftpicname,$tmp_name,'810&h=200&m=0&c=1');
			}		
		}
		return $ret->Updates(array('pushurl','pushimg'),array(self::UArray($pushurl),self::UArray($pushimg)))->change();		
	}
	
	public static function UArray($array=array()){
		
		$new = array();
		foreach($array as $k=>$v){
			$new[$k+1] = $v;			
		}
		return $new;
	}
    
	public static function updateOrder($id,$type){

        	$ret = new Example();
        	return $ret->query("UPDATE ".self::$_table." SET `order` = `order` ".$type." 1 WHERE id=$id");
        
     	}
	
}
