<?php

/*
 * 数据库扩展脚本
 * @leunico
 */

namespace AliceFrameWork\DB;

class Db{

   public static function factor(){
	     
	  $dbType = strtolower(DB_TYPE);	  
	  switch($dbType){
		  
		  case 'mysql':		  
		     $className = 'Mysql';			 
			 break;			 
		  default:		  
		     exit('Error: Database Type');  
		  
	  }
	  
	  $className = 'AliceFrameWork\DB\\'.$className;	  
	  return new $className();
	   
   }
	
	
}