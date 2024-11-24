<?php

namespace Backend\Models;

use Exception;
use PDO;

class UserModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function find_by_email(string $email)
    {
        try {
            $sql = 'SELECT * FROM users WHERE email = :email';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } catch (Exception $e) {
            throw new Exception('emailによるユーザー情報の取得に失敗しました: ' . $e->getMessage());
        }
    }

    public function find_by_token(string $token)
    {
        try {
            $sql = 'SELECT * FROM users WHERE remember_token = :remember_token';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':remember_token', $token, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } catch (Exception $e) {
            throw new Exception('tokenによるユーザー情報の取得に失敗しました: ' . $e->getMessage());
        }
    }

    public function find_by_reset_token(string $token)
    {
        try {
            $sql = 'SELECT * FROM users WHERE reset_token = :reset_token';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':reset_token', $token, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } catch (Exception $e) {
            throw new Exception('リセットトークンの検証に失敗しました: ' . $e->getMessage());
        }
    }

    public function update_token(int $id, ?string $token, ?int $expires_limit)
    {
        try {
            $sql = 'UPDATE users SET remember_token = :remember_token, remember_token_expires_at = :remember_token_expires_at WHERE id = :id';
            $stmt = $this->pdo->prepare($sql);

            $expires_date = ($expires_limit ? date('Y-m-d H:i:s', $expires_limit) : null);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':remember_token', $token, PDO::PARAM_STR);
            $stmt->bindValue(':remember_token_expires_at', $expires_date, $expires_limit ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception('認証トークンの上書きに失敗しました: ' . $e->getMessage());
        }
    }

    public function save_reset_token(int $id, string $expiry, string $reset_token)
    {
        try {
            $sql = 'UPDATE users SET reset_token = :reset_token, reset_token_expires_at = :reset_token_expires_at WHERE id = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', intval($id), PDO::PARAM_INT);
            $stmt->bindValue(':reset_token', $reset_token, PDO::PARAM_STR);
            $stmt->bindValue(':reset_token_expires_at', $expiry, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function update_password(int $id, string $password)
    {
        try {
            $sql = 'UPDATE users SET
                    password = :password,
                    reset_token = NULL,
                    reset_token_expires_at = NULL
                    WHERE id = :id';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_STR);
            $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception('パスワードの更新に失敗しました: ' . $e->getMessage());
        }
    }
}
