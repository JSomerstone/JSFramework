<?php

namespace keijoCMS\Controller;

class Index extends \keijoCMS\Core\Controller
{
    public function index()
    {
        $this->setView(new \keijoCMS\View\EmptyView());
        $controller = sprintf(
                '\\keijoCMS\\Controller\\%s',
                $this->request->getGet('controller') ?: 'ShowPage'
        );
        if (class_exists($controller))
        {
            $subController = new $controller($this->request);
            $subController->run();
        }
    }

}
