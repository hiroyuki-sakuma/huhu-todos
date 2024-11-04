<?php

namespace Backend\Database\Migrations;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $sql = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL UNIQUE,
            name VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
            remember_token VARCHAR(100) DEFAULT NULL,
            token_expires_at DATE DEFAULT NULL
        )";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }

    public function down()
    {
        $this->pdo->exec('DROP TABLE IF EXISTS users');
    }
}
