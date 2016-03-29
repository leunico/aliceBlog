<?php namespace AliceFrameWork;
/*  
 *  框架初始化文件
 *  @leunico 
 */
 
class App
{
    
    private $Config = '';
    
    public function init()
    {
        
        //载入系统配置文件        
        $this->_loadSysFile();
        
        //设置头    
        $this->_setHeader();
        
        //自动载入函数        
        $this->_setAutoload();
        
        //设置路由        
        $this->_setRoute();
        
    }
    //载入系统配置文件
    private function _loadSysFile()
    {
        
        $GLOBALS['config'] = require_once __DIR__ . './../config/config.php';
        require_once __DIR__ . '/Function.php';
        
    }
    
    //头部
    private function _setHeader()
    {
        
        header('Content-type:text/html; charset=UTF-8');
        //开启Session
        session_start();
        //设置时区
        date_default_timezone_set(TIMEZONE);
        //开启PHP调试功能
        DEBUG ? error_reporting(E_ALL & ~E_STRICT) : error_reporting(0);
        
    }
    
    //自动载入函数
    private function _setAutoload()
    {
        
        require_once __DIR__ . '/Autoload.php';
        $autoload = new Autoload();
        $autoload->register();
        
    }
    
    //设置路由
    private function _setRoute()
    {
        
        $routeObj = new Route();
        $routeObj->parse();
        
    }
   
}
