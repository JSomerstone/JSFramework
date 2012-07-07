<?php
namespace keijoCMS\View;

class ShowPage extends \keijoCMS\Core\View
{
    public $pageID = null;

    public function __toString()
    {
        return "Showing page #$this->pageID";
    }
}