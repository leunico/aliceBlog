<?php

/*  
 *  路由文件
 *  @leunico 
 */
 
namespace AliceFrameWork;

class Route{

     //解析URL    
     public function parse(){
		 
		$pathInfo = !empty($_SERVER['PATH_INFO']) ? explode('/',$_SERVER['PATH_INFO']) : array(); 
         
		$className = !empty($pathInfo[1]) ? $pathInfo[1] : DEFAULT_CONTROLLER;
         
		$methodName = !empty($pathInfo[2]) ? $pathInfo[2] : DEFAULT_METHOD;  
         
        $c = DEFAULT_APP_NAME.'\Controller\\'.$className.'Controller';  //var_dump($pathInfo);echo '</br>'.$_SERVER['PATH_INFO']; 
         
        //$obj = new $c();    
        if (!class_exists($c)){ // 跳转到404页面，正式运营用。
           
            NotFound();
            
        }
         
        $obj = new $c();
         
        if(!empty($pathInfo[2]) && is_numeric($pathInfo[2]) && empty($pathInfo[3])){
                
            method_exists($obj,'index') ? $obj->index($pathInfo[2]) : NotFound();
                
        }
         
        if( !empty($pathInfo[3]) && empty($pathInfo[4])){
                            
            method_exists($obj,$methodName) ? $obj->$methodName($pathInfo[3]) : NotFound();
                   
        }else{   
            
            method_exists($obj,$methodName) ? $obj->$methodName() : NotFound();
            
        }
		 
    }	
	
}