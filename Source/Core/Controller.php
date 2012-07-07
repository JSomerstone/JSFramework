<?php
namespace keijoCMS\Core;

abstract class Controller
{
    /**
     * Placeholder for View-object
     * @var keijoCMS\Core\View
     */
    public $view;

    /**
     * Request-object
     * @var keijoCMS\Core\Request
     */
    protected $request;
    protected $requestedAction = 'index';

    public function __construct(Request $requestObject)
    {
        $this->request = $requestObject;
    }

    protected function setup()
    {

    }


    protected function teardown()
    {

    }

    /**
     * Returns and unsets 'action' parameter from Request if any
     * If 'action' GET-parameter is not given, will return 'index' as default
     *
     * @return string
     */
    protected function getRequestedAction()
    {
        $this->requestedAction = $this->request->getGet('action') ?: 'index';
        return $this->requestedAction;
    }


    /**
     * Run controllers action
     */
    public function run()
    {
        try
        {
            $this->setup();

            $this->commitAction($this->getRequestedAction());

            $this->teardown();
        }
        catch (\keijoCMS\View\Exception $e)
        {
            $this->view->set('errorMessage', 'View reported an error : ' . $e->getMessage());
            $this->view->setErrorCode(View::ERROR_CODE_INTERNAL_ERROR);
        }
        catch (\keijoCMS\Core\RootException $e)
        {
            $this->view->set('errorMessage', 'Well, someone f****ed up : '. $e->getMessage());
            $this->view->setErrorCode(View::ERROR_CODE_INTERNAL_ERROR);
        }
        catch (\Exception $fatal)
        {
            $errorHandle = fopen(STDERR, 'a');
            fwrite($errorHandle, $fatal->getMessage() . NL . $fatal->getTraceAsString() . NL);
            $this->view->set('errorMessage', 'WTF just happened?!?');
            $this->view->setErrorCode(View::ERROR_CODE_INTERNAL_ERROR);
        }

        $this->view->output();
    }

    /**
     * Returns reference of View's proparty $propartyName
     * Shortcut to $this->view->bind()
     *
     * @param string $propertyName
     * @param misc $initialValue, optional
     * @return misc
     */
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
                get_class($this),
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