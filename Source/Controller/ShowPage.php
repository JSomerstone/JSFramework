<?php
namespace keijoCMS\Controller;

class ShowPage extends \keijoCMS\Core\Controller
{
    public $pageID = null;

    protected function setup()
    {
        $this->view = new \keijoCMS\View\ShowPage();
    }

    public function index()
    {
        $this->pageID = $this->request->getGet('pageID') ?: 0;
        $this->view->bind('pageID', $this->pageID);
    }
}