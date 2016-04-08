<?php namespace AliceFrameWork;
/*  
 *  模型容器文件
 *  @leunico 
 */

use ReflectionClass;

class Container
{
    private $app = array();
    
    private $instances = array();
    
    public function __set($key, $concrete)
    {
        $this->app[$key] = $concrete;
    }
    
    public function __get($key)
    {
        return $this->build($this->app[$key]);
    }
    
    public function make($abstract, $parameters)
    {
        $this->instances = $parameters;
        return $this->build($this->app[$abstract]);
    }
    
    public function build($className)
    {
        if ($className instanceof Closure) {
            return $className($this);
        }
        $reflector = new ReflectionClass($className);
        if (!$reflector->isInstantiable()) {
            throw new Exception('Error:Can\'t instantiate this.');
        }
        $constructor = $reflector->getConstructor();
        if (is_null($constructor)) {
            return new $className();
        }
        if ($this->instances) {
            return $reflector->newInstanceArgs($this->instances);
        } else {
            $parameters = $constructor->getParameters();
            $dependencies = $this->getDependencies($parameters);
            return $reflector->newInstanceArgs($dependencies);
        }
    }
    
    public function getDependencies($parameters)
    {
        $dependencies = array();
        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();
            if (is_null($dependency)) {
                $dependencies[] = $this->resolveNonClass($parameter);
            } else {
                $dependencies[] = $this->build($dependency->name);
            }
        }
        return $dependencies;
    }
    
    public function resolveNonClass($parameter)
    {
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }
        throw new Exception('Error:Missing parameter.');
    }
    
}
