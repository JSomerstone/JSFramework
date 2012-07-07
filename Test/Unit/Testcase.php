<?php

namespace JSFramework\Test\Unit;

class TestCase extends \PHPUnit_Framework_TestCase
{
    protected function fakeRequest($controller, $method, $getParams = array(), $postParams = array())
    {
        $fakeUri = sprintf('/%s/%s/', $controller, $method);
        if (!empty($getParams))
        {
            foreach ($getParams as $param => $value)
            {
                $fakeUri .= "$param:$value/";
            }
        }
        $_SERVER['REQUEST_URI'] = $fakeUri;
        $_POST = $postParams;
    }
}