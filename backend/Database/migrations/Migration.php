<?php

namespace Backend\Database\Migrations;

use PDO;

abstract class Migration
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    abstract public function up();
    abstract public function down();
}
