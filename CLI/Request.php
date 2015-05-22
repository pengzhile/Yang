<?php
namespace Yang\CLI;

use Yang\MVC\Interfaces\IRequest;

class Request implements IRequest
{
    /**
     * @var string
     */
    protected $_queryString;

    /**
     * @var string
     */
    protected $_controllerName;

    /**
     * @var array
     */
    protected $_servers;

    /**
     * @var array
     */
    protected $_params;

    public function isCLI()
    {
        return true;
    }

    /**
     * 返回本次请求的字符串
     * @return string
     */
    public function queryString()
    {
        return $this->_queryString;
    }

    public function controllerName()
    {
        return $this->_controllerName;
    }

    public function setControllerName($name)
    {
        $this->_controllerName = $name;
    }

    public function server($key, $default = null)
    {
        return isset($this->_servers[$key]) ? $this->_servers[$key] : $default;
    }

    public function servers()
    {
        return $this->_servers;
    }

    public function param($key, $default = null)
    {
        return isset($this->_params[$key]) ? $this->_params[$key] : $default;
    }

    public function setParam($key, $value)
    {
        $this->_params[$key] = $value;
    }

    public function params()
    {
        return $this->_params;
    }

    public function setParams(array $params)
    {
        $this->_params = $params + $this->_params;
    }

    public function __construct()
    {
        $this->_servers = $_SERVER;
        $this->_params = array();

        $args = $this->_servers['argv'];
        array_shift($args);
        $this->_queryString = implode('&', $args);
    }

    public function __destruct()
    {
        unset($this->_servers);
        unset($this->_params);
    }
}