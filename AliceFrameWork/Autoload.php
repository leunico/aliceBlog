<?php

/*  
 *  自动载入函数文件
 *  @leunico 
 */
 
namespace AliceFrameWork;

class Autoload{
	
	public function register(){
	
		spl_autoload_register(array($this,'autoload'));
			
	}
	
	public function autoload($className){
	
		$pathArr = explode('\\',$className);
	        
		$filename = array_pop($pathArr);
        
		$dir = implode(DIRECTORY_SEPARATOR,$pathArr);
        
        	$filename = $dir.'/'.$filename.'.php'; //var_dump($filename.'--==--'.$className.'</br>');
        
		if(file_exists($filename)){	
            
			require_once $filename;	
            
		}else{
            
			#exit('Error:'.$className.' loading Failed'); // 调试模式
			#echo "Error:".$className." loading Failed <br/>"; // 兼容模式
			NotFound(); //运营
            
		}
				
	}
	
}
