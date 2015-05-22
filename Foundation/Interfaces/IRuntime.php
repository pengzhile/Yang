<?php
namespace Yang\Foundation\Interfaces;

interface IRuntime
{
    /**
     * 根据$key来获取一个对应的$value
     * 如果没找到对应$key，应该返回$default指定的值
     * @param string $key
     * @param mixed $default
     * @return null|mixed
     */
    public function get($key, $default = null);

    /**
     * 根据$key来存储指定的$value
     * @param string $key
     * @param mixed  $value
     */
    public function set($key, $value);

    /**
     * 该方法应该返回一个已缓存的对象
     * @param string $name
     * @param array $args
     * @return null|mixed
     */
    public function fetch($name, array $args = array());

    /**
     * 该方法应该总是返回一个由$context制定的maker制造出来的对象
     * 简单的说就是每次都是一个new对象
     * @param string $name
     * @param array $args
     * @return null|mixed
     */
    public function make($name, array $args = array());

    /**
     * 注册一个运行时上下文，传递一个上下文数组，格式如下：
     * array(
     *      '名字' => function () {
     *          //这里面返回new出的对象
     *      }
     *      'subject' => function () {
     *          return new Subject();
     *      }
     * )
     * @param array $context
     * @return void
     */
    public function register(array $context);
}