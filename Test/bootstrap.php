<?php

defined('NL') OR define('NL', "\n");

function D()
{
    $arguments = func_get_args();
    echo "\n";
    foreach ($arguments as $arg)
        var_dump($arg);
}

function loadMock($className)
{
    $mockName = preg_replace('/^JSFramework/', '', $className);
    $mockName = 'Mock/' . $mockName;
    $mockLocation = str_replace('\\', '/', $mockName) . '.php';

    D('Loading', $mockLocation);
    if (!file_exists($mockLocation))
    {
        throw new Exception(sprintf(
            'Unable to load mock of %s from %s', $className, $mockLocation
        ));
    }
    else
    {
        require __DIR__ . DS . $mockLocation;
    }
}