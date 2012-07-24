<?php
defined('NL') OR define('NL', "\n");
defined('TIMEZONE') OR define('TIMEZONE', 'Europe/Helsinki');
date_default_timezone_set(TIMEZONE);

require 'testAutoloader.php';
loadMock('JSFramework\NativeFunctions');

function D()
{
    ob_end_flush();
    $arguments = func_get_args();
    echo "\n";
    foreach ($arguments as $arg)
        var_dump($arg);
    ob_start();
}

function DE()
{
    $arguments = func_get_args();
    echo "\n";
    foreach ($arguments as $arg)
        var_dump($arg);
    exit();
}

function loadMock($className)
{
    $mockName = preg_replace('/^JSFramework/', '', $className);
    $mockName = 'Mock/' . $mockName;
    $mockLocation = str_replace('\\', '/', $mockName) . '.php';

    if (!file_exists($mockLocation))
    {
        throw new Exception(sprintf(
            'Unable to load mock of %s from %s', $className, $mockLocation
        ));
    }
    else
    {
        require_once __DIR__ . DS . $mockLocation;
    }
}