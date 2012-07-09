<?php

namespace JSFramework\Test\Unit;

class TestCase extends \PHPUnit_Framework_TestCase
{
    protected function fakeRequest(
            $controller,
            $method,
            $getParams = array(),
            $postParams = array(),
            $traditinalGet = array()
    )
    {
        $fakeUri = sprintf('/%s/%s', $controller, $method);
        if (!empty($getParams))
        {
            foreach ($getParams as $param => $value)
            {
                $fakeUri .= "/$param:$value";
            }
        }

        if (!empty($traditinalGet))
        {
            $fakeUri .= '?';
            foreach ($traditinalGet as $param => $value)
            {
                $fakeUri .= "$param=$value&";
            }
            $fakeUri = trim($fakeUri, '&'); //remove the last "&"
        }

        $_SERVER['REQUEST_URI'] = $fakeUri;
        $_GET = $traditinalGet;
        $_POST = $postParams;
    }

    public function assertType($variable, $expectedType)
    {
        if (gettype($variable) !== $expectedType)
        {
            $this->fail(sprintf(
                'Failed asserting that type "%s" was "%s"',
                gettype($variable),
                $expectedType
            ));
        }
        else { $this->assertTrue(true); }
    }
}