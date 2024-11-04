<?php

namespace Backend\Controllers;

use Backend\Libs\Auth;
use Backend\Libs\Helper;
use Backend\Http\HttpResponse;
use PDO;
use Exception;

class AuthController
{
    private $auth;

    public function __construct(PDO $pdo)
    {
        $this->auth = Auth::get_instance($pdo);
    }

    public function login(array $data)
    {
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        try {
            if ($this->auth->login($email, $password)) {
                Helper::generate_csrf_token();
                $data = [
                    'status' => 'success',
                    'message' => 'ログインに成功しました'
                ];
                HttpResponse::send_json_response($data, 200);
            }

            $data = [
                'status' => 'error',
                'message' => 'メールアドレスまたはパスワードが正しくありません'
            ];
            HttpResponse::send_json_response($data, 401);
        } catch (Exception $e) {
            $data = [
                'status' => 'error',
                'message' => 'サーバーエラーが発生しました'
            ];
            HttpResponse::send_json_response($data, 500);
        }
    }

    public function logout()
    {
        try {
            $this->auth->logout();
            $data = [
                'status' => 'success',
                'message' => 'ログアウトしました'
            ];
            HttpResponse::send_json_response($data, 200);
        } catch (Exception $e) {
            $data = [
                'status' => 'error',
                'message' => 'サーバーエラーが発生しました'
            ];
            HttpResponse::send_json_response($data, 500);
        }
    }

    public function check_auth()
    {
        try {
            $isAuthenticated = $this->auth->check();
            $user = $this->auth->user();

            if ($isAuthenticated && $user) {
                unset($user['password']);
                unset($user['remember_token']);
                $data = [
                    'authenticated' => true,
                    'user' => $user
                ];
                HttpResponse::send_json_response($data, 200);
            }

            $data = [
                'authenticated' => false,
                'user'
            ];
            HttpResponse::send_json_response($data, 401);
        } catch (Exception $e) {
            $data = [
                'status' => 'error',
                'message' => '認証に失敗しました'
            ];
            HttpResponse::send_json_response($data, 401);
        }
    }
}
