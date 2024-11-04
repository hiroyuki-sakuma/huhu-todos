<?php

namespace Backend\Database\Seeds;

require_once 'bootstrap.php';


use Backend\Database\Seeds\Seeder;
use Faker\Factory;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('ja_JP');

        $sql = '
            INSERT INTO users (email, name, password, role, remember_token, token_expires_at)
            VALUES (?, ?, ?, ?, ?, ?)
        ';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $_ENV['ADMIN_EMAIL'],
            '管理者',
            password_hash($_ENV['DEFAULT_PASSWORD'], PASSWORD_DEFAULT),
            'admin',
            null,
            null
        ]);
        $stmt->execute([
            $_ENV['SECOND_EMAIL'],
            'セカンドユーザー',
            password_hash($_ENV['DEFAULT_PASSWORD'], PASSWORD_DEFAULT),
            'user',
            null,
            null
        ]);
    }
}
