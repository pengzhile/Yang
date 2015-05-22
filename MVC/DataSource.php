<?php
namespace Yang\MVC;

use Yang\Foundation\Interfaces\IRuntime;
use Yang\Foundation\Runtime;
use Yang\MVC\Routes\Basic as BasicRoute;
use Yang\CLI\Request as CLIRequest;
use Yang\HTTP\Request as HTTPRequest;

class DataSource
{
    /**
     * @return IRuntime
     */
    static public function makeRuntime()
    {
        return new Runtime();
    }

    /**
     * @return array
     */
    static public function systemObjectContexts()
    {
        return array(
            'dispatcher' => function (IRuntime $runtime) {
                return new Dispatcher($runtime);
            },
            'router' => function () {
                return new Router();
            },
            'cliRequest' => function () {
                return new CLIRequest();
            },
            'httpRequest' => function () {
                return new HTTPRequest();
            },
            'basicRoute' => function () {
                return new BasicRoute();
            },
        );
    }
}