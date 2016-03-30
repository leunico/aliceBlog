<?php namespace AliceFrameWork;
/*  
 *  Http请求和响应分析类
 *  @leunico 
 */

class Request
{
    public function __construct(){}
    
    public static function getHost()
    {
        return $_SERVER['HTTP_HOST'];
    }
    
    public static function getServerName()
    {
        return isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
    }
    
    public static function getClientIP()
    {
        if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $onlineip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $onlineip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $onlineip = getenv('REMOTE_ADDR');
        } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $onlineip = $_SERVER['REMOTE_ADDR'];
        } else {
            $onlineip = '';
        }
        preg_match('/[\\d\\.]{7,15}/', $onlineip, $onlineipmatches);
        return isset($onlineipmatches[0]) ? $onlineipmatches[0] : 'unknown';
    }
    
    public static function getFullPath()
    {
        return isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    }
    
    public static function getScriptUrl()
    {
        return $_SERVER['SCRIPT_URL'];
    }
    
    public static function getController()
    {
        return substr($_SERVER['PATH_INFO'], 7);
    }
    
    public static function getRefererUrl()
    {
        return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : Request::getFullPath();
    }
    
    public static function getRequest($key, $type, $default = '', $method = '')
    {
        if ($method == 'post') {
            $value = empty($_POST[$key]) || empty($_POST[$key]) && $_POST[$key] != 0 ? $default : $_POST[$key];
        } elseif ($method == 'get') {
            $value = empty($_GET[$key]) || empty($_GET[$key]) && $_GET[$key] != 0 ? $default : $_GET[$key];
        } else {
            $value = empty($_REQUEST[$key]) || empty($_REQUEST[$key]) && $_REQUEST[$key] != 0 ? $default : $_REQUEST[$key];
        }
        if ($type == 'str') {
            $value = EscapeString($value);
        } elseif ($type == 'int') {
            $value = intval($value);
        } elseif ($type == 'array') {
            $value = is_array($value) ? $value : array();
        }
        return $value;
    }
    
    public static function getCookie($key, $default = '')
    {
        return isset($_COOKIE[COOKIE_PRE . $key]) ? $_COOKIE[COOKIE_PRE . $key] : $default;
    }
    
    public static function getSession($key, $default = '')
    {
        return isset($_SESSION[SESSION_PRE . $key]) ? $_SESSION[SESSION_PRE . $key] : $default;
    }
    
    public static function getSessionId()
    {
        return session_id();
    }
    
    public static function setSession($key, $value)
    {
        $_SESSION[SESSION_PRE . $key] = $value;
    }
    
    public static function delSession($key)
    {
        unset($_SESSION[SESSION_PRE . $key]);
    }
    
    public static function setCookie($key, $value, $expires = 0)
    {
        setcookie(COOKIE_PRE . $key, $value, $expires, '/');
    }
    
}


