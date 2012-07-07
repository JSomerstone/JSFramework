<?php
include __DIR__.'/../autoloader.php';


$mainController = new keijoCMS\Controller\Index(
    new keijoCMS\Core\Request()
);
$mainController->run();