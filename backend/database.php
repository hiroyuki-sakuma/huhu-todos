<?php

namespace Backend;

require_once 'bootstrap.php';

use PDO;
use PDOException;
use Exception;

class Database
{
    public static function connect_db()
    {
        $host = $_ENV['MYSQL_HOST'];
        $db = $_ENV['MYSQL_DATABASE'];
        $charset = $_ENV['MYSQL_CHARSET'];
        $dsn = "mysql:host=$host; dbname=$db; charset=$charset";
        $user = $_ENV['MYSQL_USER'];
        $pass = $_ENV['MYSQL_PASSWORD'];

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            return $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            throw new Exception('データベース接続エラーが発生しました。' . $e->getMessage());
        }
    }
}
