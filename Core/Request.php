<?php
namespace keijoCMS\Core;

class Request
{
    /**
     * Placeholder for both POST and GET params
     * @var array
     */
    protected $requestParams = array();

    /**
     * Placeholder for POST params
     * @var array
     */
    protected $postParams = array();

    /**
     * Placeholder for GET params
     * @var array
     */
    protected $getParams = array();

    /**
     * Will initialize Request object and clear possible $_GET and $_POST parameters
     */
    public function __construct()
    {
        $this->postParams = $_POST;
        $this->getParams = $_GET;

        $this->requestParams = array_merge($this->getParams, $this->postParams);

        $_GET = array();
        $_POST = array();
    }

    /**
     * Get POST param with or without index
     * if $param not given, will return all POST-params as an array
     * @param string $param POST-parameter to return, optional
     * @return string
     */
    public function getPost($param = null)
    {
        if (null === $param)
        {
            return $this->postParams;
        }
        else if (isset($this->postParams[$param]))
        {
            return $this->postParams[$param];
        }
        else
        {
            return null;
        }
    }

    /**
     * Get GET param with or without index
     * if $param not given, will return all GET-params as an array
     * @param string $param GET-parameter to return, optional
     * @return string
     */
    public function getGet($param = null)
    {
        if (null === $param)
        {
            return $this->getParams;
        }
        else if (isset($this->getParams[$param]))
        {
            return $this->getParams[$param];
        }
        else
        {
            return null;
        }
    }

    /**
     * Get POST or GET param with or without index
     * if $param not given, will return all GET & POST-params as single array
     * @param string $param request parameter to return, optional
     * @return string
     */
    public function getRequest($param = null)
    {
        if (null === $param)
        {
            return $this->requestParams;
        }
        else if (isset($this->requestParams[$param]))
        {
            return $this->requestParams[$param];
        }
        else
        {
            return null;
        }
    }

    /**
     * Unset given POST parameter
     * @param string $parameter
     * @return void
     */
    public function unsetPost($parameter)
    {
        if (isset($this->postParams[$parameter]))
        {
            unset($this->postParams[$parameter]);
            unset($this->requestParams[$parameter]);
        }
    }

    /**
     * Unset given GET parameter
     * @param string $parameter
     * @return void
     */
    public function unsetGet($parameter)
    {
        if (isset($this->getParams[$parameter]))
        {
            unset($this->getParams[$parameter]);
            unset($this->requestParams[$parameter]);
        }
    }
}