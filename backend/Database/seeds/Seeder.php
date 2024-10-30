<?php

namespace Backend\Database\Seeds;

use PDO;

abstract class Seeder
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    abstract public function run();
}
