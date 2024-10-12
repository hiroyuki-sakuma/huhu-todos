<?php
function connect_db()
{
    $host = 'db';
    $db = 'app_db';
    $charset = 'utf8';
    $dsn = "mysql:host=$host; dbname=$db; charset=$charset";

    //ユーザー名、パスワード
    $user = 'test';
    $pass = 'test';

    //オプション
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

    //PDOインスタンスを返す
    return $pdo;
}

//データベースと接続して、PDOインスタンスを取得
$pdo = connect_db();

//実行したいSQLを準備する
$sql = 'select * from test_table';
$stmt = $pdo->prepare($sql);

//SQLを実行
$stmt->execute();

//データベースの値を取得
$result = $stmt->fetchall();
var_dump($result);
