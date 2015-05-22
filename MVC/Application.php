<?php
namespace Yang\MVC;

use Yang\MVC\Interfaces\IApplication;
use Yang\MVC\Interfaces\IController;
use Yang\MVC\Interfaces\IRequest;
use Yang\MVC\Interfaces\IRoute;

abstract class Application implements IApplication
{
    /**
     * @var string
     */
    private $__path;

    final public function __construct()
    {
        $this->__path = $this->path();
        spl_autoload_register(array($this, '_loader'));

        $this->init();
    }

    public function init()
    {
    }

    public function attached()
    {
    }

    public function preDispatch()
    {
        return true;
    }

    public function preRoute(IRequest $request)
    {
        return true;
    }

    public function routed(IRequest $request, IRoute $route = null)
    {
    }

    public function preInvokeControllers(IRequest $request)
    {
        return true;
    }

    public function preInvokeService(IController $controller, IRequest $request)
    {
        return true;
    }

    public function invokedService(IController $controller, IRequest $request)
    {
    }

    public function invokedControllers(array $controllers, IRequest $request)
    {
    }

    public function dispatched()
    {
    }

    public function atExit()
    {
    }

    public function customRoutes()
    {
        return null;
    }

    public function customRequest()
    {
        return null;
    }

    public function invalidController($controllerName)
    {
    }

    public function controllerNotFound($controllerName)
    {
        echo $controllerName, PHP_EOL;
    }

    /**
     * autoload的默认实现，支持namespace
     * 如果不想使用namespace，需要自己实现其他方式
     * @param string $class
     * @throws \RuntimeException
     */
    protected function _loader($class)
    {
        $file = $this->__path . strtr(substr($class, strpos($class, '\\')), '\\', DIRECTORY_SEPARATOR) . '.php';
        is_file($file) && require $file;
    }
}