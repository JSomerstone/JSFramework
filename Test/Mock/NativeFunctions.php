<?php
namespace JSFramework;

class NativeFunctions
{
    private static $headers = array();
    public static function header($headerString)
    {
        self::$headers[] = $headerString;
        return true;
    }

    public static function getHeaders()
    {
        return self::$headers;
    }

    public static function resetHeaders()
    {
        self::$headers = array();
    }
}
