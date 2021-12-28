<?php

require_once "../vendor/autoload.php";
use core\Application;
use routes\Routes;

$routes = new Routes();
$app = new Application(true, dirname(__DIR__), $routes);
$app->run();

