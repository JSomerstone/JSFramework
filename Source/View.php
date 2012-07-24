<?php
namespace JSomerstone\JSFramework;

abstract class View
{
    const ERROR_CODE_OK = 200;
    const ERROR_CODE_INTERNAL_ERROR = 500;
    const ERROR_CODE_VALIDATION_ERROR = 409;
    const ERROR_CODE_AUTHORIZATION_ERROR = 406;
    const ERROR_CODE_NOT_FOUND = 404;

    protected $errorMessages = array();
    protected $errorCode = self::ERROR_CODE_OK;

    protected $data = array();

    /**
     * Set views property $property to value $value
     * @param string $property
     * @param misc $value
     */
    public function set($property, $value)
    {
        $this->data[$property] = $value;
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
        $this->data[$property] = &$value;
    }

    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }

    public function addErrorMessage($message)
    {
        $this->errorMessages[] = $message;
    }

    public function output()
    {
        $this->_setHeaderAccordingToErrorCode();
        echo $this->printOutput();
    }

    public abstract function printOutput();

    protected function _setHeaderAccordingToErrorCode()
    {
        switch ($this->errorCode)
        {
            case self::ERROR_CODE_NOT_FOUND :
                NativeFunctions::header('HTTP/1.1 404 Not Found');
                break;

            case self::ERROR_CODE_INTERNAL_ERROR :
                NativeFunctions::header('HTTP/1.1 500 Internal Server Error');
                break;

            case self::ERROR_CODE_OK :
            default :
                NativeFunctions::header('HTTP/1.1 200 Ok');
                break;
        }
    }
}