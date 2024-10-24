<?php

namespace Backend\Routes;

class Router
{
  private $routes = [];

  public function get($path, $handler)
  {
    $this->routes['GET'][$path] = $handler;
  }

  public function post($path, $handler)
  {
    $this->routes['POST'][$path] = $handler;
  }

  public function put($path, $handler)
  {
    $this->routes['PUT'][$path] = $handler;
  }

  public function delete($path, $handler)
  {
    $this->routes['DELETE'][$path] = $handler;
  }

  public function handle_request($method, $path)
  {
    $url_parts = parse_url($path);
    $path = ($url_parts['path']);

    if (isset($this->routes[$method][$path])) {
      $handler = $this->routes[$method][$path];
      $params = [];
      if (isset($url_parts['query'])) {
        parse_str($url_parts['query'], $params);
      }
      return $handler($params);
    }

    http_response_code(404);
    return ['status' => 'error', 'message' => 'Not Found'];
  }
}
