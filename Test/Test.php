<?php
/**
 * Created by PhpStorm.
 * User: neo
 * Date: 15-5-15
 * Time: 上午10:36
 */
$start = microtime(true);

require '/home/neo/htdocs/app/Yang/Yang.php';

Yan::g()->loadApp(function () {
    require 'Application.php';
    return new \Test\Application();
})->runApp();

echo microtime(true) - $start, PHP_EOL;