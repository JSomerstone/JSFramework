<?php
namespace keijoCMS\Core;

abstract class Controller
{
    /**
     * Placeholder for View-object
     * @var Core_View
     */
    public $view;

    /**
     * Set View for controller
     * @param Core_View $viewObject as reference
     * @throws Core_Exception
     */
    protected function setView(&$viewObject)
    {
        if (! $viewObject instanceof Core_View)
        {
            throw new Core_Exception('Invalid View-object given');
        }
        else
        {
            $this->view = $viewObject;
        }
    }

}