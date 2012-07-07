<?php
defined('TIMEZONE') OR define('TIMEZONE', 'Europe/Helsinki');
date_default_timezone_set(TIMEZONE);

defined('DS') OR define('DS', DIRECTORY_SEPARATOR);
defined('NL') OR define('NL', "\n");


function autoloadClass($className)
{

    $namespaceParts = explode('\\', $className);

    if ($namespaceParts[0] === 'keijoCMS')
    {
        array_shift($namespaceParts);
    }
    $pathToFile = __DIR__ . DS . 'Source' . DS . implode(DS, $namespaceParts) . '.php';

    if (!file_exists($pathToFile))
    {
        die ("Unable to find class '$className' from '$pathToFile'");
    }
    require $pathToFile;
}

spl_autoload_register("autoloadClass");

function D($value)
{
    var_dump($value);
}