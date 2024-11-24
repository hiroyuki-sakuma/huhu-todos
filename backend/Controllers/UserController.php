<?php

namespace Backend\Controllers;

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use Backend\Http\HttpResponse;
use Backend\Models\UserModel;
use PDO;
use Exception;

class UserController
{
    private $user_model;

    public function __construct(PDO $pdo)
    {
        $this->user_model = new UserModel($pdo);
    }

    public function get_user_by_token()
    {
        $token = $_COOKIE['remember_token'];
        try {
            $data = $this->user_model->find_by_token($token);
            HttpResponse::send_json_response($data, 200);
        } catch (Exception $e) {
            HttpResponse::send_json_response([
                'status' => 'error',
                'message' => 'ユーザー取得に失敗しました'
            ], 400);
        }
    }

    public function email_reset_password_link(array $data)
    {
        try {
            $user = $this->user_model->find_by_email($data['email']);
            if (!$user) {
                HttpResponse::send_json_response([
                    'status' => 'email not found',
                    'message' => 'メールアドレスが見つかりません'
                ], 400);
            }

            $reset_token = bin2hex(random_bytes(32));

            $mail = new PHPMailer(true);
            $mail->CharSet = 'UTF-8';
            $mail->IsSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;
            $mail->Username = $_ENV['GMAIL_USERNAME'];
            $mail->Password = $_ENV['GMAIL_APP_PASS'];
            $mail->setFrom($_ENV['GMAIL_USERNAME'], '管理人');
            $mail->addAddress($data['email']);
            $mail->Subject = 'パスワードリセットフォームへのリンクです。';
            $mail->Body = "
            パスワードリセットのリクエストを受け付けました。
            以下のリンクをクリックして新しいパスワードを設定してください。

            {$_ENV['FRONTEND_URL']}/password-reset?token={$reset_token}

            このリンクの有効期限は1時間です。
            ";

            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $user_data = $this->user_model->find_by_email($data['email']);
            $this->user_model->save_reset_token($user_data['id'], $expiry, $reset_token);

            $mail->send();

            HttpResponse::send_json_response([
                'status' => 'success',
                'message' => 'リセットメールを送信しました'
            ]);
        } catch (Exception $e) {
            HttpResponse::send_json_response([
                'status' => 'error',
                'message' => 'パスワードリセットのためのメール送信に失敗しました'
            ], 500);
        }
    }

    public function verify_reset_token()
    {
        try {
            $user = $this->user_model->find_by_reset_token($_GET['token']);

            if (!$user) {
                return HttpResponse::send_json_response([
                    'status' => 'error',
                    'message' => '無効なリセットリンクです。',
                ], 400);
            }

            if (strtotime($user['reset_token_expires_at']) < time()) {
                return HttpResponse::send_json_response([
                    'status' => 'error',
                    'message' => 'リセットリンクの有効期限が切れています。',
                ], 400);
            }

            return HttpResponse::send_json_response([
                'status' => 'success',
                'message' => '有効なリセットリンクです。',
                'email' => $user['email']
            ], 200);
        } catch (Exception $e) {
            return HttpResponse::send_json_response([
                'status' => 'error',
                'message' => 'トークンの検証に失敗しました。',
            ], 500);
        }
    }

    public function update_password(array $data)
    {
        try {
            $user = $this->user_model->find_by_reset_token($data['token']);
            $this->user_model->update_password($user['id'], $data['new_password']);

            return HttpResponse::send_json_response([
                'status' => 'success',
                'message' => 'パスワードの更新に成功しました。'
            ], 200);
        } catch (Exception) {
            return HttpResponse::send_json_response([
                'status' => 'error',
                'message' => 'パスワードの更新に失敗しました。',
            ], 500);
        }
    }
}
