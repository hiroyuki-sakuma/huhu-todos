<?php

namespace Backend\Database\Seeds;

use Backend\Database\Seeds\Seeder;
use Faker\Factory;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'housework',
            'application',
            'private'
        ];

        $sql = '
            INSERT INTO categories (category)
            VALUES (?)
        ';

        $stmt = $this->pdo->prepare($sql);
        foreach ($categories as $category) {
            $stmt->execute([$category]);
        }
    }
}
