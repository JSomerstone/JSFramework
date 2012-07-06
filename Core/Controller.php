<?php
namespace keijoCMS\Core;

abstract class Controller
{
    /**
     * Placeholder for View-object
     * @var keijoCMS\Core\View
     */
    public $view;


    protected function setup()
    {

    }


    protected function teardown()
    {

    }

    /**
     * Run controllers action
     */
    public function run()
    {
        try
        {
            $this->setup();

            $this->commitAction('main');

            $this->teardown();
        }
        catch (\keijoCMS\View\Exception $e)
        {
            $this->view->set('errorMessage', 'View reported an error : ' . $e->getMessage());
        }
        catch (\keijoCMS\Core\RootException $e)
        {
            $this->view->set('errorMessage', 'WTF just happened?!?');
        }

        $this->view->output();
    }

    protected function &bindView($propertyName, $initialValue = null)
    {
        return $this->view->bind($propertyName, $initialValue);
    }
    
    /**
     * Commit given action
     * @param string $actionName
     */
    public function commitAction($actionName)
    {

        if (method_exists($this, $actionName))
        {
            $this->$actionName();
        }
        else
        {
            throw new \keijoCMS\Controller\Exception(sprintf(
                'Controller %s method %s is not callable',
                __CLASS__,
                $actionName
            ));
        }
    }


    /**
     * Set View for controller
     * @param Core_View $viewObject as reference
     * @throws Core_Exception
     */
    protected function setView(&$viewObject)
    {
        if (! $viewObject instanceof \keijoCMS\Core\View)
        {
            throw new RootException('Invalid View-object given');
        }
        else
        {
            $this->view = $viewObject;
        }
    }

}