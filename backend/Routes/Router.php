<?php

namespace Backend\Routes;

use Backend\Http\HttpRequest;
use Backend\Http\HttpResponse;
use Backend\Database;

class Router
{
  private array $routes;

  public function __construct()
  {
    $this->routes = require 'Routes.php';
  }

  public function handle(HttpRequest $request)
  {
    $method = $request->get_method();
    $path = $request->get_path();

    if ($method === 'OPTIONS') {
      HttpResponse::send_json_response(null);
    }

    if (($method === 'PUT' || $method === 'DELETE' || $method === 'GET') && preg_match('/\/(\d+)$/', $path, $matches)) {
      $id = (int)$matches[1];
      $path = '/{id}';
    }

    if (!isset($this->routes[$method][$path])) {
      HttpResponse::send_json_response(['error' => 'Not Found'], 404);
    }

    [$controller_class, $method_name] = $this->routes[$method][$path];
    $pdo = Database::connect_db();
    $controller = new $controller_class($pdo);

    if ($method === 'PUT') {
      $body = $request->parse_body();
      $result = $controller->$method_name($body, $id);
    } elseif ($method === 'POST') {
      $body = $request->parse_body();
      $result = $controller->$method_name($body);
    } elseif ($method === 'DELETE') {
      $result = $controller->$method_name($id);
    } elseif ($method === 'GET') {
      $result = $controller->$method_name();
    } else {
      $result = $controller->$method_name();
    }

    HttpResponse::send_json_response($result);
  }
}
