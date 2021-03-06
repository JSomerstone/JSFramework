<?php
namespace JSomerstone\JSFramework;

abstract class Controller
{
    /**
     * Placeholder for View-object
     * @var JSFramework\View
     */
    public $view;

    /**
     * Request-object
     * @var JSFramework\Request
     */
    protected $request;

    public function __construct(Request $requestObject, View $viewObject = null)
    {
        $this->request = $requestObject;
        $this->view = $viewObject;
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
        return $this->request->getAction() ?: 'index';
    }


    /**
     * Run controllers action
     */
    public function run()
    {
        ob_start();
        try
        {
            $this->setup();

            $this->commitAction($this->getRequestedAction());

            $this->teardown();
        }
        catch (\JSomerstone\JSFramework\Exception\NotFoundException $e)
        {
            $this->view && $this->view->setErrorCode(View::ERROR_CODE_NOT_FOUND);
        }
        catch (\JSomerstone\JSFramework\Exception\RootException $e)
        {
            $this->view && $this->view->set('errorMessage', 'Well, someone f****ed up : '. $e->getMessage());
            $this->view && $this->view->setErrorCode(View::ERROR_CODE_INTERNAL_ERROR);
        }
        catch (\Exception $fatal)
        {
            fwrite(STDERR, $fatal->getMessage() . NL . $fatal->getTraceAsString() . NL);
            $this->view && $this->view->set('errorMessage', 'WTF just happened?!?');
            $this->view && $this->view->setErrorCode(View::ERROR_CODE_INTERNAL_ERROR);
        }

        //TODO: log this shit
        $unexpectedOutput = ob_get_clean();
        echo $unexpectedOutput;

        $this->view && $this->view->output();
    }

    /**
     * Commit given action
     * @param string $actionName
     */
    protected function commitAction($actionName)
    {
        // Requested method must be public in order to be commited via commitAction
        $refl = new \ReflectionMethod($this, $actionName);
        if (method_exists($this, $actionName) && $refl->isPublic())
        {
            $this->$actionName();
        }
        else
        {
            throw new \JSomerstone\JSFramework\Exception\NotFoundException(sprintf(
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
        if (! $viewObject instanceof \JSFramework\View)
        {
            throw new RootException('Invalid View-object given');
        }
        else
        {
            $this->view = $viewObject;
        }
    }

}