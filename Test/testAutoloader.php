<?php
defined('DS') OR define('DS', DIRECTORY_SEPARATOR);

add_include_path(dirname(__DIR__));

function autoloadTestClass($className)
{

    $namespaceParts = explode('\\', $className);
    if ( isset($namespaceParts[0]) && $namespaceParts[0] === 'JSFramework')
    {
        unset($namespaceParts[0]);
    }

    if (isset($namespaceParts[1]) && $namespaceParts[1] != 'Test')
    {
        array_unshift($namespaceParts, 'Source');
    }


    $pathToFile = dirname(__DIR__) . '/' . implode(DS, $namespaceParts) . '.php';

    if (!file_exists($pathToFile))
    {
        die (sprintf(
                "Unable to find class '%s' from '%s' with include path '%s'",
                $className, $pathToFile, get_include_path()
        ));
    }
    require_once $pathToFile;
}

spl_autoload_register("autoloadTestClass");

function add_include_path ($path)
{
    foreach (func_get_args() AS $path)
    {
        if (!file_exists($path) OR (file_exists($path) && filetype($path) !== 'dir'))
        {
            trigger_error("Include path '{$path}' not exists", E_USER_WARNING);
            continue;
        }

        $paths = explode(PATH_SEPARATOR, get_include_path());

        if (array_search($path, $paths) === false)
            array_push($paths, $path);

        set_include_path(implode(PATH_SEPARATOR, $paths));
    }
}

function remove_include_path ($path)
{
    foreach (func_get_args() AS $path)
    {
        $paths = explode(PATH_SEPARATOR, get_include_path());

        if (($k = array_search($path, $paths)) !== false)
            unset($paths[$k]);
        else
            continue;

        if (!count($paths))
        {
            trigger_error("Include path '{$path}' can not be removed because it is the only", E_USER_NOTICE);
            continue;
        }

        set_include_path(implode(PATH_SEPARATOR, $paths));
    }
}
