<?php

/*  
 *  视图类
 *  @leunico 
 */
 
namespace AliceFrameWork;

class View {
	
	public static $showData = array();
	
	function __construct() {}
	
	public static function Transmit($file,$value=array()) {
        
		self::$showData = $value;
        View::showTPL($file);
	}
	
	public static function showTPL($file,$dir = TEMPLATE_PATH,$path = '/') {
		error_reporting(0);
        $filename = $dir . $path . $file . '.tpl.php'; //var_dump($filename);
		if (!file_exists($filename)) {
			exit("Template file '$file.tpl.php' not Exists!<br/>");
		}
		$data = self::$showData;
		@extract($data);

		if (preg_match("/\/([^\/]+)\/([^\/]+)\/([^\/\?]+)/",REQUEST_URI,$matches)) {
			$path = $matches[1];
			$file = $matches[2];
			$action = $matches['3'];
		} 
		include_once $filename;
		exit();
	}
	
	/**
	 * 返回API数据 ...
	 * @param string $data JSON序列化串
	 */
	public static function showJson($data) {
		if (empty($data['error_code'])) {
			$results = array('code' => 200, 'data' => $data);
		} else {
			$results = $data;
		}
		echo json_encode($results,JSON_NUMERIC_CHECK);
		exit();
	}

    /**
     * 管理后台 - 显示跳转信息页 ...
     * @param string $jumpurl 跳转URL
     * @param string $msg 显示信息
     * @param string $target 跳转目标 _blank _self _parent
     */
    public static function AdminMessage($jumpurl, $msg, $target="") {
        $ms = 5; //跳转间隔时间
        include_once  ROOT_PATH . '/templates/' . 'show_message.tpl.php';
        exit();
    }

    /**
     * 管理后台 - 显示错误信息页...
     * @param string $jumpurl 跳转URL
     * @param string $msg 显示信息
     * @param string $target 跳转目标 _blank _self _parent
     */
    public static function AdminErrorMessage($jumpurl, $msg, $target="") {
        $ms = 5; //跳转间隔时间
        include_once  ROOT_PATH . '/templates/' . 'show_error_message.tpl.php';
        exit();
    }
	
	/**
	 * JS页面跳转 ...
	 * @param string $url
	 * @param int $timeOut
	 */
	public static function jsJump($url, $timeOut=0) {
		if ($timeOut == 0) {
			exit('<script>location.href="'.$url.'"</script>');
		} else {
			exit('<script>setTimeout("location.href=\''.$url.'\'",'.$timeOut.')</script>');
		}
	}
}
