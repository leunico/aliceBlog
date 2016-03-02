<?php

namespace app\Model;

use AliceFrameWork\Example;
// use AliceFrameWork\Qiniu;
use AliceFrameWork\JinShan;

class ArticleModel{
	
	private static $_table = 'info_article';
	
	public static function getArticleList($page,$scree=array()){
	   	
	    $ret = new Example(self::$_table);
	    if(empty($scree)){	
		     return $ret->Data('a.* ,COUNT(b.id) AS count')->Join('info_comment','LEFT','a.id=b.aid')->where('','')->group('a.id')->order('ctime','DESC')->Paginate($page,10);
	    }else{
		 $order = $scree['num'] ? $scree['num']: "ctime";
		 $key = array();
		 if($scree['recommend_type'] ==1 || $scree['recommend_type']==2){             
                     $whereleft = "recommend_type";
		     $whereright = $scree['recommend_type'];            
                 }else if($scree['recommend_type'] ==3){
		     $whereleft = "top";
		     $whereright = 1;                       
                 }else{
                     $whereleft = "";
		     $whereright = "";         
                 }
		 if($scree['keyword'] !== ''){
		     $whereleft = array($whereleft,'title');
		     $whereright = array($whereright,"%".$scree['keyword']."%");
		     $key = array('=','LIKE');
		 }
		 return $ret->Data('a.* ,COUNT(b.id) AS count')->Join('info_comment','LEFT','a.id=b.aid')->where($whereleft,$whereright,$key)->group('a.id')->order($order,'DESC')->Paginate($page,10,$scree);
            }
		
	}
	
	public static function getArticleList_My($page,$id){
		
            $ret = new Example(self::$_table);
            return $ret->Data('a.* ,COUNT(b.id) AS count')->Join('info_comment','LEFT','a.id=b.aid')->where('uid',$id)->group('a.id')->order('ctime','DESC')->Paginate($page,10);
		
	}
	
	public static function getArticleClassList($class,$page){
		
            $ret = new Example(self::$_table);
            if(is_array($class)){
                return $ret->Data('a.* ,COUNT(b.id) AS comcount')->Join('info_comment','LEFT','a.id=b.aid')->where('a.mid',implode('\',\'',$class),'IN')->group('a.id')->order('ctime','DESC')->Pageindex($page,10);
            }else{
                return $ret->Data('a.* ,COUNT(b.id) AS comcount')->Join('info_comment','LEFT','a.id=b.aid')->where('a.mid',$class)->group('a.id')->order('ctime','DESC')->Pageindex($page,10);
            }            
       		
	}
    
        public static function getArticleTagShow($tag,$page){
        
            $ret = new Example(self::$_table);
            return $ret->Data('a.* ,COUNT(b.id) AS comcount')->Join('info_comment','LEFT','a.id=b.aid')->where('tag',$tag,'LIKE')->group('a.id')->order('ctime','DESC')->Pageindex($page,10);
        
        }
    
        public static function getNewArticleList(){
        
            $ret = new Example(self::$_table);
            return $ret->Data('ctime,image,title,id')->where('','')->order('ctime','DESC')->get(6);
        
        }
    
        public static function getCommentArticleList(){
        
            $ret = new Example(self::$_table);
            return $ret->Data('a.ctime,a.image,a.title,a.id,COUNT(b.id) AS count')->Join('info_comment','INNER','a.id=b.aid')->group('b.aid')->order('count','DESC')->get(6);
        
        }
    
        public static function getArticleShow($id){
        
            $ret = new Example(self::$_table);
            $result = self::getOneArticle('id',$id);
            if(empty($result)) return FALSE;
            $result['next'] = $ret->Data('title,id')->where('ctime',$result['ctime'],'>')->order('ctime','ASC')->get(1);
            $result['oneone'] = $ret->Data('title,id')->where('ctime',$result['ctime'],'<')->order('ctime','DESC')->get(1);
            return $result;
        
        }
    
        public static function getPushArticleList(){
        
            $ret = new Example(self::$_table);
            return $ret->Data('ctime,image,title,id')->where('recommend_type',2,'<')->order(array('recommend_type','ctime'),array('DESC','DESC'))->get(6);
        
        }
    
        public static function getArticleRelevant($mid,$id){
        
            $ret = new Example(self::$_table);
            return $ret->Data('image,title,id')->where(array('mid','id'),array($mid,$id),array('=','!='))->order('good_num','DESC')->get(4);
        
        }
	
	public static function InsertArticle($fields){
		
            $ret = new Example(self::$_table);
            return $ret->Insert($fields)->change();
				
	}
    
        public static function updatePlus($id,$type){

            $ret = new Example();
            return $ret->query("UPDATE ".self::$_table." SET `".$type."` = `".$type."` + 1 WHERE id=$id");
        
        }
	
	public static function editArticle($id,$fields){
		
            $ret = new Example(self::$_table);
            return $ret->Update($fields)->where('id',$id)->change();
		
 	}
	
	public static function getOneArticle($type,$value){
		
            $ret = new Example(self::$_table);
            return $ret->Find($type,$value);
		
	}
	
	public static function delArticle($id){
	
	    $ret = new Example(self::$_table);
	    $article = $ret->Find('id',$id);
	    $image = self::getarticleImage($article['content'],'ALL');
	    if(!empty($image)) self::delArticleImage($image);
	    return $ret->Delete()->where('id',$id)->change();	
		
	}
	
	public static function delArticleImage($image){
		
	    $jinshan = new JinShan('lzxya'); //'lzxya'是保存文章图片的bucket
	    $imgs = array();
	    foreach($image as $val){
		$jinshanimg = explode('/',$val);
		$img = explode('@',$jinshanimg[3]);
		$imgs[] = $img[0];
	    }
	    $jinshan->Delete($imgs);
        
	}
	
	public static function getArticleImage($content,$order='ALL'){
        
            $pattern="/<img.*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/";        
            preg_match_all($pattern,$content,$match);        
            if(isset($match[1]) && !empty($match[1])){            
            if($order==='ALL'){                
                return $match[1];
            }            
            if(is_numeric($order) && isset($match[1][$order])){ 
		$jinshanimg = explode('@',$match[1][$order]);             
                return $jinshanimg[0]."@base@tag=imgScale&q=100&w=230";
            }
        }
        return '';
        
    }
    
    public static function getArticleBox(){
        
        $ret = new Example(self::$_table);
        $resulta = $ret->Data("FROM_UNIXTIME( ctime,'%Y-%m' ) AS pubtime, COUNT( * ) AS count")->group('pubtime')->order('ctime','DESC')->get(); 
        $resultb = $ret->Data("FROM_UNIXTIME( a.ctime,'%Y-%m' ) AS pubtime, COUNT( b.id ) AS count, a.title, a.id, a.ctime")->Join('info_comment','LEFT','a.id = b.aid')->group('a.id')->get();
        $result = array();
        foreach($resulta as $ret){         
            foreach($resultb as $val){            
                if( $ret['pubtime'] == $val['pubtime']){                 
                    $result[$ret['pubtime']][] = $val;
                }            
            } 
        }
	return $result;
        
    }
    
}
