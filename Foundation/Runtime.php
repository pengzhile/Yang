<?php
namespace Yang\Foundation;

use Yang\Foundation\Interfaces\IRuntime;

class Runtime implements IRuntime
{
    /**
     * 用来存储一些共享的对象
     * @var array
     */
    protected $_instances = array();

    /**
     * 存储已注册的上下文
     * @var array
     */
    protected $_contexts = array();

    /**
     * 一个MAP，用来存储一些get set的数据
     * @var array
     */
    protected $_map = array();

    public function get($key, $default = null)
    {
        return isset($this->_map[$key]) ? $this->_map[$key] : $default;
    }

    public function set($key, $value)
    {
        $this->_map[$key] = $value;
    }

    public function fetch($name, array $args = array())
    {
        if (isset($this->_contexts[$name])) {
            if (isset($this->_instances[$name])) {
                return $this->_instances[$name];
            }
            return $this->_instances[$name] = $this->_make($this->_contexts[$name], $args);
        }

        return null;
    }

    public function make($name, array $args = array())
    {
        if (isset($this->_contexts[$name])) {
            return $this->_make($this->_contexts[$name], $args);
        }

        return null;
    }

    public function register(array $context)
    {
        foreach ($context as $name => $maker) {
            if (is_string($name) && is_callable($maker)) {
                $this->_contexts[$name] = $maker;
            } else {
                throw new \InvalidArgumentException('Invalid context item: ' . $name);
            }
        }
    }

    public function __destruct()
    {
        unset($this->_contexts);
        unset($this->_map);
        unset($this->_instances);
    }

    /**
     * @param \Closure $maker
     * @param array    $args
     * @return mixed
     */
    protected function _make(\Closure $maker, array $args)
    {
        switch (count($args)) {
            case 0: return $maker();
            case 1: return $maker($args[0]);
            case 2: return $maker($args[0], $args[1]);
            case 3: return $maker($args[0], $args[1], $args[2]);
            case 4: return $maker($args[0], $args[1], $args[2], $args[3]);
        }

        return call_user_func_array($maker, $args);
    }
}