<?php
namespace JSFramework;

abstract class View
{
    const ERROR_CODE_OK = 200;
    const ERROR_CODE_INTERNAL_ERROR = 500;
    const ERROR_CODE_VALIDATION_ERROR = 409;
    const ERROR_CODE_AUTHORIZATION_ERROR = 406;
    const ERROR_CODE_NOT_FOUND = 404;

    protected $errorMessage = null;
    protected $errorCode = self::ERROR_CODE_OK;

    public abstract function __toString();

        /**
     * Set views property $property to value $value
     * @param string $property
     * @param misc $value
     */
    public function set($property, $value)
    {
        if (isset($this->$property) || property_exists($this, $property))
        {
            $this->$property = $value;
        }
        else
        {
            throw new \JSFramework\View\Exception(
                "Unable to set non-existing view property '$property'"
            );
        }
    }

    /**
     * Returns reference to requested property $property
     * That property can be set to initial value $value
     *
     * @param string $property
     * @param misc $value optional
     */
    public function bind($property, &$value = null)
    {
        if (isset($this->$property) || property_exists($this, $property))
        {
            $this->$property = &$value;
        }
        else
        {
            throw new \JSFramework\View\Exception(
                "Unable to bind non-existing view property '$property'"
            );
        }
    }

    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }

    public function output()
    {
        $this->_setHeaderAccordingToErrorCode();
        if (null !== $this->errorMessage)
        {
            echo $this->errorMessage, "\n";
        }
        else
        {
            echo $this;
        }
    }

    private function _setHeaderAccordingToErrorCode()
    {
        switch ($this->errorCode)
        {
            default :
            case self::ERROR_CODE_OK :
                header('HTTP/1.1 200 Ok');
                break;

            case self::ERROR_CODE_INTERNAL_ERROR :
                header('HTTP/1.1 500 Internal Server Error');
                break;
        }
    }
}