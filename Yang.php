<?php
require 'MVC/System.php';

use Yang\MVC\System;

/**
 * 如何提升开发速度？框架对IDE友好也是一个很重要的因素。
 * Class Yan
 */
class Yan extends System
{
    /**
     * @return System
     */
    static public function g()
    {
        return System::instance();
    }
}