<?php
namespace keijoCMS\Core;

class Request
{
    protected $requestParams = array();
    protected $postParams = array();
    protected $getParams = array();

    public function __construct()
    {
        $this->postParams = $_POST;
        $this->getParams = $_GET;

        $this->requestParams = array_merge($this->getParams, $this->postParams);
        $_GET = array();
        $_POST = array();
    }


    public function post($param = null)
    {
        if (null === $param)
        {
            return $this->postParams;
        }
        else if (isset($this->postParams[$param]))
        {
            return $this->postParams[$param];
        }
    }
}