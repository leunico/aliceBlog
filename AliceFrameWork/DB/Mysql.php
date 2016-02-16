<?php

/*
 * 数据库基础操作中心
 * @leunico
 */

namespace AliceFrameWork\DB;

class Mysql implements DbInterface{
	
	private $_conn = null;	
	public function __construct(){
			
		$this->_conn = mysqli_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME,DB_PORT);       
        mysqli_query($this->_conn,"set names utf8");
			
	}
	
	public function close(){
		
		mysqli_close($this->_getInstance());
		
	}
	
	public function query($sql){
		
		$result = mysqli_query($this->_conn,$sql);		
		return $result;
			
	}
	
	public function fetchAssoc($resource){
		
		$rowList = array();		
		while($row = mysqli_fetch_assoc($resource)){
			
			$rowList[] = $row;
					
		}	
		return $rowList;
	}
	
	public function select($sql){
		
		$result = $this->query($sql);		
		$rowList = $this->fetchAssoc($result);		
		return $rowList;
			
	}
	
}