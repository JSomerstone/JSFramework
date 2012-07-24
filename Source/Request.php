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

    public function getController()
    {
        return isset($this->requestPath[0])
                    ? $this->requestPath[0]
                    : null;
    }

    public function getAction()
    {
        return isset($this->requestPath[1])
                    ? $this->requestPath[1]
                    : null;
    }

    public function getRequestPath()
    {
        return $this->requestPath;
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

    private function _parseHttpRequest($url)
    {
        // Remove possible '/' sign from the beginning of the URL
        $url = ltrim($url, '/');

        if (defined('SITE_PATH_PREFIX') && SITE_PATH_PREFIX)
        {
            $sitePrefix = SITE_PATH_PREFIX;
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
                break;
            } else {
                $this->requestPath[] = $value;
                unset ($urlParts[$level]);
            }
        }
        if (count($urlParts))
        {
            foreach ($urlParts as $uriParam)
            {
                if (!empty($uriParam))
                {
                    $this->_parseUriParameters($uriParam);
                }
            }
        }
    }

    private function _parseUriParameters($uriParamValuePair)
    {
        $parts = explode(':', $uriParamValuePair, 2);
        $this->uriParams[$parts[0]] = $parts[1];
    }
}