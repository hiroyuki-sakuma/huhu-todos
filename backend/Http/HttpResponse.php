<?php

namespace Backend\Http;

require_once 'bootstrap.php';

class HttpResponse
{
    public static function send_json_response($data, $status_code = 200)
    {
        http_response_code($status_code);
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Origin: " . $_ENV['BASE_URL']);
        header('Access-Control-Max-Age: 3600');
        header('Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS');
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        echo json_encode($data);
        exit;
    }
}
