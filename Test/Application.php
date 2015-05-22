<?php
namespace Test;

class Application extends \Yang\MVC\Application
{

    public function path()
    {
        return __DIR__;
    }

    public function ns()
    {
        return __NAMESPACE__;
    }
}