<?php
defined('TIMEZONE') OR define('TIMEZONE', 'Europe/Helsinki');
date_default_timezone_set(TIMEZONE);

defined('DS') OR define('DS', DIRECTORY_SEPARATOR);


function autoloadClass($className)
{

    $pathToFile = str_replace('_', DS, $className) . '.php';
    if (!file_exists($pathToFile))
    {
        die ("Unable to find class '$className' from '$pathToFile'");
    }
    require $pathToFile;
}

spl_autoload_register("autoloadClass");