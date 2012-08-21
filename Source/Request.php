<?php
namespace JSomerstone\JSFramework;

class Request
{
    private $controllerName = '';
    private $actionName = '';

    protected $requestPath = array();

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
     * Placeholder for URI params
     * @var array
     */
    protected $uriParams = array();

    /**
     * Will initialize Request object and clear possible $_GET and $_POST parameters
     */
    public function __construct()
    {
        $this->_parseHttpRequest(
            isset($_SERVER['REQUEST_URI'])
                ? $_SERVER['REQUEST_URI']
                : null
        );

        $this->postParams = $_POST;
        $this->getParams = $_GET;

        $this->requestParams = array_merge($this->getParams, $this->uriParams, $this->postParams);

        $_GET = array();
        $_POST = array();
    }

    /**
     * Get controller-part of request path
     * If request did not contain controller-part, returns null
     * @return string|null
     */
    public function getController()
    {
        return isset($this->requestPath[0])
                    ? $this->requestPath[0]
                    : null;
    }

    /**
     * Get action-part of request path
     * If request did not contain action-part, returns null
     * @return string|null
     */
    public function getAction()
    {
        return isset($this->requestPath[1])
                    ? $this->requestPath[1]
                    : null;
    }

    /**
     * Return full request path as array starting from index $fromIndex
     * @param int $fromIndex Index to start request paht parts from, optional default "0"
     * @return array
     */
    public function getRequestPath($fromIndex = 0)
    {
        $request = array();
        foreach ($this->requestPath as $index => $value)
        {
            if ($index >= $fromIndex)
            {
                $request[] = $value;
            }
        }
        return $request;
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
     * Get URI param with or without index
     * if $param not given, will return all URI-params as an array
     * @param string $param URI-parameter to return, optional
     * @return string|array
     */
    public function getUri($param = null)
    {
        if (null === $param)
        {
            return $this->uriParams;
        }
        else if (isset($this->uriParams[$param]))
        {
            return $this->uriParams[$param];
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

    private function _parseHttpRequest($url)
    {
        // Remove possible '/' sign from the beginning of the URL
        $url = ltrim($url, '/');

        if (defined('SITE_PATH_PREFIX') && SITE_PATH_PREFIX)
        {
            $sitePrefix = Lib\String::escapeSpecials(SITE_PATH_PREFIX);
            $url = preg_replace("/^$sitePrefix\/?/", '', $url);
        }
        //Ignore traditional GET-parameters indicated with "?"
        if (strpos($url, '?'))
        {
            $url = strstr($url, '?', true);
        }

        $urlParts = explode('/', $url);

        $uriParamRegexp = '/^[a-z0-9_.]+:.+$/';

        foreach ($urlParts as $level => $value)
        {
            if (empty($value)) {
                continue;
            } elseif ( preg_match($uriParamRegexp, $value)) {
                $this->_parseUriParameters($value);
            } else {
                $this->requestPath[] = $value;
                unset ($urlParts[$level]);
            }
        }
    }

    private function _parseUriParameters($uriParamValuePair)
    {
        $parts = explode(':', $uriParamValuePair, 2);
        $this->uriParams[$parts[0]] = $parts[1];
    }
}