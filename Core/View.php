<?php
namespace keijoCMS\Core;

abstract class View
{
    protected $errorMessage = null;

    /**
     * Set views property $property to value $value
     * @param string $property
     * @param misc $value
     */
    public function set($property, $value)
    {
        if (isset($this->$property) || property_exists($this, $property))
        {
            $this->$property = $value;
        }
        else
        {
            throw new \keijoCMS\View\Exception(
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
    public function &bind($property, $value = null)
    {
        if (isset($this->$property) || property_exists($this, $property))
        {
            $this->$property = $value;
            return $this->$property;
        }
        else
        {
            throw new \keijoCMS\View\Exception(
                "Unable to bind non-existing view property '$property'"
            );
        }
    }


    public function output()
    {
        if (null !== $this->errorMessage)
        {
            echo $this->errorMessage, "\n";
        }
        else
        {
            echo $this;
        }
    }
}