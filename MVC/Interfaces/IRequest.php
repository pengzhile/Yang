<?php
namespace Yang\MVC\Interfaces;

interface IRequest
{
    /**
     * 判断是否是一个cli请求
     * @return bool
     */
    public function isCLI();

    /**
     * 返回本次请求的字符串
     * @return string
     */
    public function queryString();

    /**
     * 返回当前请求的控制器名
     * @return string
     */
    public function controllerName();

    /**
     * 设置请求的控制器名
     * @param string $name
     * @return void
     */
    public function setControllerName($name);

    /**
     * 获取系统（$_SERVER）配置
     * 如果没找到对应$key，应该返回$default指定的值
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function server($key, $default = null);

    /**
     * 返回所有系统配置
     * @return array
     */
    public function servers();

    /**
     * 获取系统请求的指定key参数
     * 如果没找到对应$key，应该返回$default指定的值
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function param($key, $default = null);

    /**
     * 设置一个参数，供路由使用
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setParam($key, $value);

    /**
     * 返回系统请求的所有参数
     * @return array
     */
    public function params();

    /**
     * 设置一组参数，供路由使用
     * @param array $params
     * @return void
     */
    public function setParams(array $params);
}