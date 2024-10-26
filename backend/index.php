<?php

require_once __DIR__ . '/vendor/autoload.php';

use Backend\Routes\Router;
use Backend\Http\HttpRequest;

$request = new HttpRequest();
$router = new Router();
$router->handle($request);
