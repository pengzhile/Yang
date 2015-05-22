<?php
namespace Test\Controllers\Admin;

use Yang\MVC\Controller;
use Yang\MVC\Interfaces\IRequest;

class Login extends Controller
{

    public function service(IRequest $request)
    {
        echo 'abc', PHP_EOL;
    }
}