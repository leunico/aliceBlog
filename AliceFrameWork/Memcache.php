<?php namespace AliceFrameWork;
/*  
 *  Memcache操作文件
 *  @leunico 
 */

class Memcache
{
    
    private $local_cache = array();
    private $mem;
    private $memcache_type;
    
    public function __construct()
    {
        
        if (MEMCACHE === FALSE) return FALSE;
        $this->mem = new \Memcache();
        $this->mem->connect(MEMCACHE_HOST, MEMCACHE_PORT) or die('ERROR: Could not connect to the server named ' . MEMCACHE_HOST);
        
    }
    
    public function set($key = NULL, $value = NULL, $expiration = NULL)
    {
        
        if (is_null($expiration)) $expiration = MEMCACHE_EXPIRATION;
        $this->local_cache[$this->key_name($key)] = $value;
        $add_status = $this->mem ? $this->mem->set($this->key_name($key), $value, MEMCACHE_COMPRESSION, $expiration) : FALSE;
        return $add_status;
        
    }
    
    public function get($key = NULL)
    {
        
        if ($this->mem) {
            if (isset($this->local_cache[$this->key_name($key)])) return $this->local_cache[$this->key_name($key)];
            if (is_null($key)) return FALSE;
            return @$this->mem->get($this->key_name($key));
        } else {
            return FALSE;
        }
        
    }
    
    public function delete($key, $expiration = NULL) //这里$expiration是服务端等待删除该元素的总时间
    {
        
        if (is_null($key)) return FALSE;
        if (is_null($expiration)) $expiration = MEMCACHE_EXPIRATION;
        unset($this->local_cache[$this->key_name($key)]);
        return $this->mem->delete($this->key_name($key), $expiration);
    }
    
    private function key_name($key)
    {
        
        return md5(strtolower(MEMCACHE_PREFIX . $key));
        
    }
    
    public function clear()
    {
        
        return $this->mem->flush();
        
    }
    
}
