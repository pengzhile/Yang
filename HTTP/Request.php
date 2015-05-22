<?php
namespace Yang\HTTP;

use Yang\MVC\Interfaces\IRequest;

class Request implements IRequest
{
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

    /**
     * @var array
     */
    protected $_gets;

    /**
     * @var array
     */
    protected $_posts;

    /**
     * @var array
     */
    protected $_files;

    /**
     * @var array
     */
    protected $_cookies;

    public function isCLI()
    {
        return false;
    }

    public function queryString()
    {
        return $this->_servers['QUERY_STRING'];
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

    /**
     * 返回某个post项内容
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function post($key, $default = null)
    {
        return isset($this->_posts[$key]) ? $this->_posts[$key] : $default;
    }

    /**
     * 返回所有post内容
     * @return array
     */
    public function posts()
    {
        return $this->_posts;
    }

    /**
     * 返回某个get项内容
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return isset($this->_gets[$key]) ? $this->_gets[$key] : $default;
    }

    /**
     * 返回所有get内容
     * @return array
     */
    public function gets()
    {
        return $this->_gets;
    }

    /**
     * 返回某个file项内容
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function file($key, $default = null)
    {
        return isset($this->_files[$key]) ? $this->_files[$key] : $default;
    }

    /**
     * 返回所有files内容
     * @return array
     */
    public function files()
    {
        return $this->_files;
    }

    /**
     * 返回某个cookie项内容
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function cookie($key, $default = null)
    {
        return isset($this->_cookies[$key]) ? $this->_cookies[$key] : $default;
    }

    /**
     * 返回所有cookie内容
     * @return array
     */
    public function cookies()
    {
        return $this->_cookies;
    }

    /**
     * 返回某个session项内容
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function session($key, $default = null)
    {
        $this->_initSession();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    /**
     * 返回所有session内容
     * @return array
     */
    public function sessions()
    {
        $this->_initSession();
        return $_SESSION;
    }

    public function __construct()
    {
        /**
         * for ready only
         */
        $this->_servers = $_SERVER;
        $this->_gets = $_GET;
        $this->_posts = $_POST;
        $this->_files = $_FILES;
        $this->_cookies = $_COOKIE;
        $this->_params = $_REQUEST;
    }

    public function __destruct()
    {
        unset($this->_servers);
        unset($this->_params);
        unset($this->_gets);
        unset($this->_posts);
        unset($this->_files);
        unset($this->_cookies);
    }

    /**
     * 判断并使用session_start
     */
    protected function _initSession()
    {
        isset($_SESSION) || session_start();
    }
}