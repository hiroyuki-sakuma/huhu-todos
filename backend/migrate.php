<?php

use Backend\Database\Migrations\CreateUsersTable;
use Backend\Database\Migrations\CreateCategoriesTable;
use Backend\Database\Migrations\CreateTodosTable;
use Backend\Database\Seeds\UserSeeder;
use Backend\Database\Seeds\CategorySeeder;
use Backend\Database\Seeds\TodoSeeder;
use Backend\Database;

require_once 'vendor/autoload.php';
require_once 'bootstrap.php';

$pdo = Database::connect_db();

$migrations = [
    new CreateCategoriesTable($pdo),
    new CreateUsersTable($pdo),
    new CreateTodosTable($pdo),
];

foreach ($migrations as $migration) {
    $migration->up();
    echo "Migrated: " . get_class($migration) . PHP_EOL;
}

$seeders = [
    new UserSeeder($pdo),
    new CategorySeeder($pdo),
    new TodoSeeder($pdo)
];


foreach ($seeders as $seeder) {
    $seeder->run();
    echo "Seeded: " . get_class($seeder) . PHP_EOL;
}
