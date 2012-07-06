<?php

namespace keijoCMS\Controller;

class Index extends \keijoCMS\Core\Controller
{
    public function setup()
    {
        $this->setView(new \keijoCMS\View\Index());
    }

    public function main()
    {
        $message = &$this->bindView('message', 'Abba');

        $message = 'H3ll0 W0r1d!';
    }

}
