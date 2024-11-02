<?php

namespace Backend\Database\Migrations;

class CreateTodosTable extends Migration
{
    public function up()
    {
        $sql = "CREATE TABLE todos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            category_id INT NOT NULL DEFAULT 1,
            todo TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            created_by INT NOT NULL,
            completed BOOLEAN NOT NULL DEFAULT false,
            completed_at Date DEFAULT NULL,
            completed_by INT DEFAULT NULL,
            FOREIGN KEY (category_id) REFERENCES categories(id),
            FOREIGN KEY (created_by) REFERENCES users(id),
            FOREIGN KEY (completed_by) REFERENCES users(id)
        )";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }

    public function down()
    {
        $this->pdo->exec('DROP TABLE IF EXISTS todos');
    }
}
