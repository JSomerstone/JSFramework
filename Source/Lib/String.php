<?php
namespace JSomerstone\JSFramework\Lib;

abstract class String
{
    public static function toRegexp($string)
    {
        return '/' . self::escapeSpecials($string) . '/';
    }

    public static function escapeSpecials($string)
    {
        $searchSpecials = array('/', '?', '.');
        $replacements = array('\/', '\?', '\.');
        return str_replace($searchSpecials, $replacements, $string);
    }
}