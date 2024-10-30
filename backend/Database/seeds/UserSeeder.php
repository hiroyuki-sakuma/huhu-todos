<?php

namespace Backend\Database\Seeds;

use Backend\Database\Seeds\Seeder;
use Faker\Factory;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('ja_JP');

        $sql = '
            INSERT INTO users (email, name, password, role)
            VALUES (?, ?, ?, ?)
        ';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'admin@example.com',
            '管理者',
            password_hash('password', PASSWORD_DEFAULT),
            'admin'
        ]);

        for ($i = 0; $i < 5; $i++) {
            $stmt->execute([
                $faker->unique()->safeEmail(),
                $faker->name(),
                $faker->password(),
                'user'
            ]);
        }
    }
}
