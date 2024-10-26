<?php

namespace Backend\Http;

require_once 'bootstrap.php';

class HttpRequest
{
    private string $method;
    private string $path;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Origin: " . $_ENV['BASE_URL']);
        header('Access-Control-Max-Age: 3600');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }

    public function parse_body()
    {
        if ($this->method === 'POST') {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            return $data ?? [];
        }
        return [];
    }

    public function get_method()
    {
        return $this->method;
    }

    public function get_path()
    {
        return $this->path;
    }
}
