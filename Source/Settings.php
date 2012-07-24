<?php
namespace JSomerstone\JSFramework;

abstract class Settings
{
    static $pageSettings = array();

    public static function readIniFile($pathToIniFile)
    {
        if (!file_exists($pathToIniFile))
        {
            throw new Exception\RootException('Unable to read settings from : '.$pathToIniFile);
        }
        $parsed = @parse_ini_file($pathToIniFile, true);
        if (!$parsed)
        {
            throw new Exception\RootException('Unable to parse settings from : '.$pathToIniFile);
        }
        self::$pageSettings = $parsed;
    }


    public static function get($context, $setting = null)
    {
        return
            is_null($setting)
                ? self::$pageSettings[$context]
                : self::$pageSettings[$context][$setting];
    }
}