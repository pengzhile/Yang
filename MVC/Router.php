<?php
namespace Yang\MVC;

use Yang\MVC\Interfaces\IRequest;
use Yang\MVC\Interfaces\IRoute;

class Router
{
    /**
     * @var array
     */
    protected $_routes = array();

    /**
     * 向路由规则列表中添加一条规则
     * @param IRoute $route
     */
    public function addRoute(IRoute $route)
    {
        $this->_routes[$route->name()] = $route;
    }

    /**
     * 从路由规则列表中移除一条规则
     * @param IRoute $route
     */
    public function removeRoute(IRoute $route)
    {
        unset($this->_routes[$route->name()]);
    }

    /**
     * 开始解析请求，如果成功返回当前生效的规则，失败返回null
     * @param IRequest $request
     * @return null|IRoute
     */
    public function route(IRequest $request)
    {
        /**
         * @var IRoute $route
         */
        foreach ($this->_routes as $route) {
            if (true === $route->parse($request)) {
                return $route;
            }
        }

        return null;
    }

    public function __destruct()
    {
        unset($this->routes);
    }
}