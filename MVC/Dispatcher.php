<?php
namespace Yang\MVC;

use Yang\Foundation\Interfaces\IRuntime;
use Yang\MVC\Interfaces\IApplication;

class Dispatcher
{
    /**
     * @var IRuntime
     */
    protected $_runtime;

    /**
     * @var Router
     */
    protected $_router;

    public function __construct(IRuntime $runtime)
    {
        $this->_runtime = $runtime;
    }

    public function __destruct()
    {
        unset($this->_router);
        unset($this->_runtime);
    }

    /**
     * 调度一个app
     * @param IApplication $app
     * @return mixed
     */
    public function dispatch(IApplication $app)
    {
        $router = $this->_router();
        $routes = $app->customRoutes();
        if ($routes && is_array($routes)) {
            foreach ($routes as $route) {
                $router->addRoute($route);
            }
        }
        $router->addRoute($this->_runtime->make('basicRoute'));

        /**
         * @var Interfaces\IRequest $request
         */
        $request = $this->_runtime->make('cli' === php_sapi_name() ? 'cliRequest' : 'httpRequest');

        do {
            if (false === $app->preRoute($request)) {
                break;
            }

            $routeResult = $router->route($request);
            $app->routed($request, $routeResult);
            if (null === $routeResult) {
                break;
            }

            $controllerClass = $app->ns() . $request->controllerName();
            if (!class_exists($controllerClass)) {
                $app->controllerNotFound($controllerClass);
                break;
            }

            if (!Controller::isSubClass($controllerClass)) {
                $app->invalidController($controllerClass);
                return System::EXIT_FAILURE;
            }

            if (false === $app->preInvokeControllers($request)) {
                break;
            }

            /**
             * @var Interfaces\IController $controller
             */
            $controller = new $controllerClass();
            $invokedControllers = array();
            $controllerResult = System::EXIT_SUCCESS;

            do {
                if (true !== $controller->access($request)) {
                    $controllerResult = System::EXIT_FAILURE;
                    break;
                }

                if (false === $app->preInvokeService($controller, $request)) {
                    break;
                }

                $ret = $controller->service($request);

                $invokedControllers[] = $controller;
                $app->invokedService($controller, $request);

                /**
                 * 如果返回的是对象本身，不死循环调用
                 */
                if ($ret == $controller) {
                    break;
                } else {
                    $controller = $ret;
                    $controllerResult = $ret;
                }
            } while (Controller::isSubClass($controller));

            $app->invokedControllers($invokedControllers, $request);
            return $controllerResult;
        } while (false);

        return System::EXIT_FAILURE;
    }

    /**
     * @return Router
     */
    protected function _router()
    {
        if (null === $this->_router) {
            $this->_router = $this->_runtime->make('router');
        }

        return $this->_router;
    }
}