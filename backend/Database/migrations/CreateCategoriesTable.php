<?php

namespace Backend\Database\Migrations;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        $this->pdo->exec('DROP TABLE IF EXISTS categories, users, todos');

        $sql = "CREATE TABLE categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            category ENUM('housework', 'application', 'private') NOT NULL DEFAULT 'housework'
        )";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }

    public function down()
    {
        $this->pdo->exec('DROP TABLE IF EXISTS categories');
    }
}
