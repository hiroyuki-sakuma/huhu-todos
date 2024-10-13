<?php
function connect_db()
{
    $host = 'db';
    $db = 'app_db';
    $charset = 'utf8';
    $dsn = "mysql:host=$host; dbname=$db; charset=$charset";
    $user = 'test';
    $pass = 'test';

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    return $pdo;
}

$pdo = connect_db();

$sql = 'select * from test_table';
$stmt = $pdo->prepare($sql);
$stmt->execute();

$result = json_encode($stmt->fetchAll());

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

echo $result;
