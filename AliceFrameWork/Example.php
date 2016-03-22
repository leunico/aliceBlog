<?php

/*  
 *  实例化一个表类
 *  @leunico 
 */
 
namespace AliceFrameWork;

use AliceFrameWork\DB\Model;
use AliceFrameWork\Request;

class Example extends Model{
	
	public  $tablename = '';
	private $_sql = '';
	private $where_ = '';
	private $order_ = '';
	private $group_ = '';
	private $limit_ = '';
	public function __construct($table=''){
		
		$this->tablename = $table;
				
	}
	
	public function Find($type,$id,$value='*'){
		
		$this->_sql = sprintf('SELECT %s FROM %s WHERE %s LIMIT 0,1',$value,$this->tablename,$type."='".$id."'");
		$this->debug && print "sql = ".$this->_sql."<br/>";
        	$result = $this->select($this->_sql); 
		return $result ? $result[0]:'';
        
	}
	
	public function Data($value='*'){
		
		$this->_sql = sprintf('SELECT %s FROM %s',$value,$this->tablename);
		return $this;
        
	}
	
	public function Update($value){
		
		$set = $s = '';        
		foreach($value as $k=>$v){            
			$set .=  $s . "`$k`='".$this->escapeMysqlString($v)."'";            
			$s = ',';            
        	}
		$this->_sql = sprintf('UPDATE %s SET %s',$this->tablename,$set);
		return $this;
		
	}
	
	#>>修改多条数据<<#
	public function Updates($arykey,$aryval){
		
		$update_id = array();
		if(empty($arykey) || empty($aryval)) return false;
		$this->_sql = sprintf('UPDATE %s SET ',$this->tablename);
		foreach($arykey as $no=>$key){
			$this->_sql .= empty($no) ? "$key = CASE id " : "END,$key = CASE id ";
			foreach ($aryval[$no] as $k => $v) {
				$this->_sql .= sprintf("WHEN %s THEN '%s' ", $k, $v);
				$update_id[$k] = $k;
			}
		}
        	$update_id = implode(',', array_keys($update_id)); 
	 	$this->_sql .= "END WHERE id IN ($update_id)";
		return $this;
		
	}
	
	public function Delete(){
		
		$this->_sql = sprintf('DELETE FROM %s',$this->tablename);
		return $this;
        
	}
	
	public function Insert($fields){
		
		$fieldStr = "`" . implode("`,`", array_keys($fields)) . "`";        
		$valueStr = "";        
		$values = array_values($fields);        
		foreach ($values as $value) {            
			$valueStr .= "'".$this->escapeMysqlString($value)."',";	            
		}        
		$valueStr = substr($valueStr, 0, -1);
		$this->_sql = sprintf(self::_SQL_INSERT,$this->tablename,$fieldStr,$valueStr);
		return $this;
        
	}
	
	public function where($column,$value,$key='',$condition='AND'){
		
		if(empty($this->_sql) || $this->_sql == 'INSERT INTO %s' ) return false;
		if(is_array($column) && is_array($value)){		   		 
			 foreach($column as $k=>$val){	
			 	if(empty($k)){	
				        if(!empty($val) && !empty($value[$k])){
						$this->where_ = $key ? " `".$val."` ".$key[$k]." '".$value[$k]."'" : "`".$val."` = '".$value[$k]."'";
					}
				}else{
				        if(!empty($this->where_)){
						$this->where_ .= $key ? " $condition `".$val."` ".$key[$k]." '".$value[$k]."'" : " $condition `".$val."` = '".$value[$k]."'";
					}else{
						$this->where_ .= $key ? "`".$val."` ".$key[$k]." '".$value[$k]."'" : " $condition `".$val."` = '".$value[$k]."'";
					}
				}
			 }			
		}else{
			if(empty($column) && empty($value)){
				$this->where_ = 1;
			}else{
		        	$this->where_ = $key ? ( $key == 'IN' ? "`".$column."` IN ('".$value."')" : "`".$column."` ".$key." '".$value."'") : "`".$column."` = '".$value."'";	
			}
		}
		if(strstr($this->where_,'.')){
			$this->where_ = str_replace("`","",$this->where_);
                	$this->_sql .= ' WHERE '.$this->where_;
                	$this->tablename = $this->tablename." a"; //此处where还可以解析，用explode筛掉b.的条件，本系统暂不用。
		}else{
             		$this->_sql .= ' WHERE '.$this->where_;
        	}
		//$this->_sql .= ' WHERE '.$this->where_;
		return $this;
		
	}
	
	public function order($column,$value,$where=''){
		
		if(empty($this->_sql)) return false;
		if(is_array($column) && is_array($value)){
			foreach($column as $k=>$val){				
				$this->order_ .= empty($k) ? " `".$val."` ".$value[$k] : ",`".$val."` ".$value[$k];				
			}			
		}else{
			$this->order_ = "`".$column."` ".$value;
		}
		$this->_sql .= ' ORDER BY '.$this->order_;
		return $this;
		
	}
	
	public function group($value){
		
		if(empty($this->_sql)) return false;
		$this->group_ = $value.' ';
		$this->_sql .= ' GROUP BY '.$this->group_;
		return $this;
        
	}
	
	public function Join($table,$type,$on){
		
		if(empty($this->_sql)) return false;
		$this->_sql = $this->_sql.sprintf(" a $type JOIN %s b ON %s ",$table,$on);
		return $this;
        
	}
	
	//后台分页
	public function Paginate($page,$pagesize=10,$scree=array()){

		$total = $this->getCounter($this->tablename,$this->where_);
		$url = Request::getFullPath();
		$postfix = '';
        	$strpos = strpos($url, '?');        
        	if($strpos !== false){            
            		$postfix = substr($url, $strpos);            
            		$url = substr($url, 0, $strpos);
        	}
        	if(substr($url, -1, 1) == '/'){$s = '';}else{$s = '/';}        
		$s = strpos($url, '-') === FALSE ? $s : '-';        
		$pages = ceil($total/$pagesize);        
		$page = min($pages,$page);        
		$prepg = $page-1;             
		if($total < 1) return FALSE;        
        	$key = $this->screeStrgo($scree);      
        	$pagenav = '<div class="pagination"><ul>';        
		$pagenav .= $prepg ? "<li><a href='$url?page=1".$key."'>首页</a></li>" : '';        
        	for($i=-10; $i<=10; $i++){            
            		$pageTmp = $page+$i;            
            		if($pageTmp < 1 || $pageTmp > $pages){                
                		continue;               
            		}
            		if($i != 0){                
                		$pagenav .= "<li><a href='$url?page=$pageTmp".$key."'>$pageTmp</a></li>";                
        	 	}else if($i == 0){                
                		$pagenav .= "<li class='active'><a href='$url?page=$pageTmp".$key."'>$pageTmp</a></li>";                
        	 	}            
        	}
        	$pagenav .= $page == $pages ? '</ul></div>':"<li><a href='$url?page=$pages".$key."'>尾页</a></li></ul></div>";
        	if($total<=$pagesize) $pagenav = ''; 
		$result = $this->get($pagesize,($page-1)*$pagesize);
		$result['page'] = $pagenav;    
		return $result;	
		
	}
	
	//前台分页
	public function Pageindex($page,$pagesize=10,$comment=false) { 
		
		$total = $this->getCounter($this->tablename,$this->where_);                 
		$url = preg_replace("/([-]*page-[0-9]*)/i", "",Request::getFullPath());        
        	$postfix = '';
        	$strpos = strpos($url, '?');        
	 	if($strpos !== false){            
            		$postfix = substr($url, $strpos);            
            		$url = substr($url, 0, $strpos);
        	}
        	if(substr($url, -1, 1) == '/'){$s = '';}else{$s = '/';}         
		$s = strpos($url, '-') === FALSE ? $s : '-';        
		$pages = ceil($total/$pagesize);        
		$page = min($pages,$page);        
		$prepg = $page-1;                
		if($total < 1) return FALSE;                
        	if($comment){            
            		$pagenav = '<div class="pagenav">';                       
            		for($i=-10; $i<=10; $i++){                
                		$pageTmp = $page+$i;                
                		if($pageTmp < 1 || $pageTmp > $pages){                    
                    			continue;                    
                		}
                		if($i != 0){                    
                			$pagenav .= "<a class=\"page-numbers\" href='$url?page=$pageTmp#comments'>$pageTmp</a>";
                		}else if($i == 0){                    
                    			$pagenav .= "<span class=\"page-numbers current\">$pageTmp</span>";                    
                		}                
            		}            
            		$pagenav .= "</div>";            
        	}else{       
            		$pagenav = '<div class="pagination"><ul>';            
            		$pagenav .= $prepg ? "<li class=\"prev-page\"><a href='$url'>首页</a></li>" : '';            
            		for($i=-10; $i<=10; $i++){                
                		$pageTmp = $page+$i;                
                		if($pageTmp < 1 || $pageTmp > $pages){                    
                			continue;                    
                		}
                		if($i != 0){                    
                    			$pagenav .= ($pageTmp == 1 ? "<li><a href='$url'>$pageTmp</a></li>" : "<li><a href='$url?page=$pageTmp'>$pageTmp</a></li>");                    
                		}else if($i == 0){                    
                    			$pagenav .= "<li class='active'><a href='$url?page=$pageTmp'>$pageTmp</a></li>";                    
                		}                
            		}            
            		$pagenav .= $page == $pages ? "<li><span>共".$pages."页</span></li></ul></div>":"<li class=\"next-page\"><a href='$url?page=$pages'>尾页</a></li><li><span>共 ".$pages." 页</span></li></ul></div>";
        	}
		if($total<=$pagesize) $pagenav = '';        
		$result = $this->get($pagesize,($page-1)*$pagesize);
		$result['page'] = $pagenav;
        	if($comment == true) $result['counts'] = $total;
		return $result;
			
	}
	
	public function change(){
		
		if(empty($this->_sql)) return false;
		$this->debug && print "sql = ".$this->_sql."<br/>";
		$change = $this->query($this->_sql);
		if(MEMCACHE == TRUE && !empty($change)){
		   $mem = new Memcache();               
		   $mem->clear(); 
	    	}
		return $change;
        
	}	
	
	public function get($value='',$limit=0){
		
		if(empty($this->_sql)) return false;
		if($value){		
		    $this->limit_ = $limit.",".$value;
		    $this->_sql .= ' LIMIT '.$this->limit_;
		}
		$this->debug && print "sql = ".$this->_sql."<br/>";
        	$result = $this->select($this->_sql);
        	return $value == 1 ? @$result[0] : $result;
	
	}
	
	public function SqlError(){
		
		echo "<pre>";
	    	print "SqlError = ".$this->_sql."<br/>";
		echo "</pre>";
		
	}

}
