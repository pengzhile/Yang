<?php
namespace Yang\MVC\Routes;

use Yang\MVC\Interfaces\IRequest;
use Yang\MVC\Interfaces\IRoute;

class Basic implements IRoute
{
    public function name()
    {
        return get_class($this);
    }

    public function parse(IRequest $request)
    {
        parse_str($request->queryString(), $params);

        $controllerName = 'Index';

        if (isset($params['r'])) {
            $sections = explode('.', strtolower($params['r']));
            array_filter($sections);
            $controllerName = implode('\\', array_map('ucfirst', $sections));
        }

        $request->setParams($params);
        $request->setControllerName('\\Controllers\\' . $controllerName);
        return true;
    }
}