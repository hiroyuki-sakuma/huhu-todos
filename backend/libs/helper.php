<?php

namespace Backend\Libs;

class Helper
{
    public static function generate_csrf_token()
    {
        $token = bin2hex(random_bytes(32));
        setcookie('XSRF-TOKEN', $token, [
            'path' => '/',
            'httponly' => false,
        ]);
    }

    public static function validate_csrf_token()
    {
        $token = $_SERVER['HTTP_X_XSRF_TOKEN'] ?? null;
        return $token && $token === $_COOKIE['XSRF-TOKEN'];
    }
}
