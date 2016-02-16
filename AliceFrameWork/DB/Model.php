<?php

/*
 * 基础Model类
 * @leunico
 */

namespace AliceFrameWork\DB;

class Model implements DbInterface{
    
     //定义sql语句    
	 const _SQL_SELECT_PAGE_LIST = "SELECT %s from %s WHERE %s ORDER BY %s LIMIT %s;";//查询分页信息   
	 const _SQL_SELECT_LIST = "SELECT %s from %s WHERE %s ORDER BY %s";//查询信息    
	 const _SQL_SELECT_ONE = "SELECT %s from %s WHERE %s LIMIT 0,1;";//查询信息    
	 const _SQL_COUNT = "SELECT COUNT(*) AS num FROM %s WHERE %s;";//查询合条件的记录数    
	 const _SQL_UPDATE = "UPDATE %s SET %s WHERE %s;";//更新SQL    
	 const _SQL_DELETE = "DELETE FROM %s WHERE %s;"; //删除信息    
	 const _SQL_INSERT = "INSERT INTO %s (%s) VALUES (%s);";//插入单条记录SQL    
	 //const _SQL_INSERT_LIST = "INSERT INTO %s (%s) VALUES %s;";//插入d多条记录SQL\    
	 //const _SQL_INSERT_DUPLICATE_UPDATE = "INSERT INTO %s (%s) VALUES (%s) ON DUPLICATE KEY UPDATE %s;";//插入同时有重复的执行UPDATE    
	 //const _SQL_REPLACE = "REPLACE INTO %s SET %s;"; //REPLACE插入或更新    
     //const _SQL_SELECT_INNER = "SELECT %s FROM %s a INNER JOIN %s b ON %s WHERE %s ORDER BY %s LIMIT %s"; //两表关联查询信息INNER    
     //const _SQL_SELECT_LEFT = "SELECT %s FROM %s a LEFT JOIN %s b ON %s WHERE %s ORDER BY %s LIMIT %s"; //两表关联查询信息LEFT
    
     public  $debug = SQLDEBUG; //输出调试信息     
	 private $_db = null;	 
	 private function _getInstance(){
		
		if(is_null($this->_db)){		
		 			
			$this->_db = Db::factor();				
		
		}		
		return $this->_db; 
		
	 }	 
	 public function close(){
		 
		 $this->_getInstance()->close();
		 
	 }	 
	 public function query($sql){

		 return $this->_getInstance()->query($sql);
		 
	 }	 
	 public function fetchAssoc($resource){
		 
		 return $this->_getInstance()->fetchAssoc($resource);
		 
	 }	 
	 public function select($sql){
		
         return $this->_getInstance()->select($sql);
		
     }
	 
	 public function getCounter($table, $where) {
        
		$sql = sprintf(self::_SQL_COUNT, $table, $where);
        
		$this->debug && print "sql = ".$sql."<br/>";
        
		$data = $this->select($sql);
        
        return $data[0]['num'];
         
	 }
	 
	 public function screeStrgo($scree){
        
        $key = '';        
        if(empty($scree)){              
            return '';                    
        }else{             
            foreach($scree as $k=>$v){                                               
                if(!empty($v)){                   
                    $key.= "&$k=$v";                    
                }                             
            }  
             return $key;  
        }
         
    }
	 	   
    public function escapeMysqlString($sqlString) {
        
		if (function_exists('mysql_escape_string')) {
            
			return @mysql_escape_string($sqlString);
            
		} else {
            
			return @mysql_real_escape_string($sqlString);
            
		} 
        
   }
}