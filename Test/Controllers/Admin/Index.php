<?php
namespace Test\Controllers\Admin;

use Yang\MVC\Controller;
use Yang\MVC\Interfaces\IRequest;

class Index extends Controller
{
    public function __construct()
    {
    }

    public function service(IRequest $request)
    {
        return new Login();
    }
}