<?php

require_once "../vendor/autoload.php";
require '../MiniBlogApplication.php';
require '../routes/routes.php';

$routes = new Routes();

$app = new MiniBlogApplication(true, dirname(__DIR__), $routes);
$app->run();

