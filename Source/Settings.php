<?php
namespace JSFramework;

abstract class Settings
{
    static $pageSettings = array();

    public static function readIniFile($pathToIniFile)
    {
        if (!file_exists($pathToIniFile))
        {
            throw new RootException('Unable to read settings from : '.$pathToIniFile);
        }
        $parsed = parse_ini_file($pathToIniFile, true);
        if (!$parsed)
        {
            throw new RootException('Unable to parse settings from : '.$pathToIniFile);
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