<?php

namespace Backend\Libs;

use Backend\Models\UserModel;
use PDO;

class Auth
{
    private static $instance = null;
    private $user = null;
    private $pdo;
    private const COOKIE_OPTIONS = [
        'path' => '/',
        'httponly' => true,
        'domain' => 'localhost'
    ];

    private function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $token = $_COOKIE['remember_token'] ?? null;

        if ($token) {
            $userModel = new UserModel($pdo);
            $this->user = $userModel->find_by_token($token);
        }
    }

    public static function get_instance(PDO $pdo)
    {
        if (!self::$instance) {
            self::$instance = new self($pdo);
        }
        return self::$instance;
    }

    public function login(string $email, string $password)
    {
        $userModel = new UserModel($this->pdo);
        $user = $userModel->find_by_email($email);

        if ($user && password_verify($password, $user['password'])) {
            $this->user = $user;
            $token = bin2hex(random_bytes(32));
            $expires_limit = time() + (30 * 24 * 60 * 60);
            $userModel->update_token($user['id'], $token, $expires_limit);

            $cookie_options = array_merge(
                self::COOKIE_OPTIONS,
                [
                    'expires' => $expires_limit,
                ]
            );
            setcookie('remember_token', $token, $cookie_options);

            return true;
        }
        return false;
    }

    public function logout()
    {
        if ($this->user) {
            $userModel = new UserModel($this->pdo);
            $userModel->update_token($this->user['id'], null, null);
        }

        $cookie_options = array_merge(
            self::COOKIE_OPTIONS,
            [
                'expires' => time() - 3600,
            ]
        );
        setcookie('remember_token', '', $cookie_options);
        $this->user = null;
    }

    public function user()
    {
        return $this->user;
    }

    public function check()
    {
        return $this->user !== null;
    }
}
