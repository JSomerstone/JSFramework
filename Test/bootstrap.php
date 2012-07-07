<?php

defined('NL') OR define('NL', "\n");

function D()
{
    $arguments = func_get_args();
    echo "\n";
    foreach ($arguments as $arg)
        var_dump($arg);
}