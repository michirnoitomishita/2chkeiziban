<?php

$dbn = 'mysql:dbname=2ch_bbs;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd = '';

// DBと接続
try {
  $pdo = new
    PDO($dbn, $user, $pwd);
  // echo "DBとの接続に成功しました";
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}
