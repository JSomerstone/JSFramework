<?php

namespace keijoCMS\View;

class EmptyView extends \keijoCMS\Core\View
{
    public function __toString()
    {

        return '';
    }
}