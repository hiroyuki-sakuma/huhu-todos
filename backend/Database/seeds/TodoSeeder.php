<?php

namespace Backend\Database\Seeds;

use Backend\Database\Seeds\Seeder;
use Faker\Factory;

class TodoSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('ja_JP');

        $sql = '
            INSERT INTO todos (category_id, todo, completed, created_by, completed_by, created_at, completed_at)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ';

        $stmt = $this->pdo->prepare($sql);
        for ($i = 0; $i < 5; $i++) {
            $completed = $faker->boolean(50) ? 1 : 0;
            $completed_by = $completed ? $faker->numberBetween(1, 2) : null;
            $completed_at = $completed ? $faker->dateTime('now', 'Asia/Tokyo')->format('Y-m-d') : null;

            $stmt->execute([
                $faker->numberBetween(1, 3),
                $faker->sentence(2, false),
                $completed,
                $faker->numberBetween(1, 2),
                $completed_by,
                $faker->dateTime('now', 'Asia/Tokyo')->format('Y-m-d'),
                $completed_at
            ]);
        }
    }
}
