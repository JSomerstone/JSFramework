<?php

namespace keijoCMS\View;

class Index extends \keijoCMS\Core\View
{
    public $message = 'unset';

    public function __toString()
    {

        return $this->message;
    }
}