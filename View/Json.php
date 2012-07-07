<?php
namespace keijoCMS\View;

class Json extends \keijoCMS\Core\View
{
    public $data;

    public function __toString()
    {
        return json_encode($this->data);
    }
}