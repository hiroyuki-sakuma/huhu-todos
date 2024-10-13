<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function connect_db()
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
    throw new Exception('データベース接続エラーが発生しました。');
  }
}

function send_json_response($data, $status_code = 200)
{
  http_response_code($status_code);
  header('Content-Type: application/json');
  header('Access-Control-Allow-Origin: http://localhost:5173');
  header('Access-Control-Max-Age: 3600');
  header('Access-Control-Allow-Methods: GET, OPTIONS');
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  echo json_encode($data);
  exit;
}

try {
  if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    send_json_response(null, 204);
  }

  $pdo = connect_db();
  $sql = 'select * from test_table';
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $results = $stmt->fetchAll();

  send_json_response(['status' => 'success', 'data' => $results]);
} catch (Exception $e) {
  send_json_response(['status' => 'error', 'message' => 'サーバーエラーが発生しました。'], 500);
}
