<?php
namespace Yang\Foundation;

abstract class Registry
{
    /**
     * @var Interfaces\IRuntime
     */
    static protected $_runtime;

    static public function get($key, $default = null)
    {
        return static::_runtime()->get($key, $default);
    }

    static public function set($key, $value)
    {
        static::_runtime()->set($key, $value);
    }

    static public function fetch($name, array $args = array())
    {
        return static::_runtime()->fetch($name, $args);
    }

    static public function make($name, array $args = array())
    {
        return static::_runtime()->make($name, $args);
    }

    static public function register(array $context)
    {
        static::_runtime()->register($context);
    }

    /**
     * @return Interfaces\IRuntime
     */
    static protected function _runtime()
    {
        if (null === static::$_runtime) {
            static::$_runtime = new Runtime();
        }

        return static::$_runtime;
    }
}