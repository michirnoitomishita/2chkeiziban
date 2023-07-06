<?php

include_once("./app/database/connect.php");

$error_massage = array();


if (isset($_POST["submitButton"])) {
  // 名前の入力チェック
  if (empty($_POST["username"])) {
    $error_massage["username"] = "お名前を入直してください";
  }
  // コメントチェック
  if (empty($_POST["body"])) {
    $error_massage["body"] = "コメントを入直してください";
  }
  // エラーメッセージがない場合のみデータベースに挿入
  if (empty($error_massage)) {

    $post_date = date("Y-m-d H:i:s");
    $sql = "INSERT INTO `comment` ( `username`, `body`, `post_date`) VALUES (:username,:body,:post_date);";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(":username", $_POST["username"], PDO::PARAM_STR);
    $statement->bindParam(":body", $_POST["body"], PDO::PARAM_STR);
    $statement->bindParam(":post_date", $post_date, PDO::PARAM_STR);
    $statement->bindParam(":parent_id", $parent_id, PDO::PARAM_INT); // parent_idの値をバインドします。

    try {
      $statement->execute();
      header("Location: ./index.php");  // ここを追加します
      exit();
    } catch (PDOException $e) {
      echo json_encode(["sql error" => "{$e->getMessage()}"]);
      exit();
    }
  }
}
// コメントデータをテーブルから取得してくる。
// $sql = "SELECT * FROM comment";
$sql = "SELECT * FROM comment ORDER BY post_date DESC";
$stmt = $pdo->prepare($sql);


try {
  $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

// SQL実行の処理

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$output = "";
foreach ($result as $record) {
  $output .= "
    <tr>
      <td>{$record["username"]}</td>
      <td>{$record["body"]}</td>
    </tr>
  ";

  // 子コメント（返信）を取得して表示します。
  $sql = "SELECT * FROM comment WHERE parent_id = :parent_id ORDER BY post_date DESC";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(":parent_id", $record["id"], PDO::PARAM_INT);
  try {
    $stmt->execute();
    $replies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($replies as $reply) {
      $output .= "
        <tr>
          <td style='padding-left: 20px;'>{$reply["username"]}</td>
          <td>{$reply["body"]}</td>
        </tr>
      ";
    }
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>〇〇店とお客様の掲示板</title>
</head>

<body>
  <?php include("app/parts/header.php"); ?>

  <!-- バリデーションチェック -->
  <?php include("app/parts/validation.php"); ?>

  <!-- スレッドエリア -->
  <?php include("app/parts/thread.php"); ?>

  <!-- スレッドエリア -->
  <?php include("app/parts/newThreadButton.php"); ?>

</body>

</html>