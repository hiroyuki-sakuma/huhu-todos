<?php
require_once 'vendor/autoload.php';

use Backend\Http\HttpResponse;

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['REQUEST_URI'];
$router = require 'routes/routes.php';

$result = $router->handle_request($method, $path);
echo HttpResponse::send_json_response($result, 200);
