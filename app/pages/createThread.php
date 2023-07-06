<!-- <?php

      include_once("../database/connect.php");

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

          try {
            $statement->execute();
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
      <td>{$record["deadline"]}</td>
      <td>{$record["todo"]}</td>
    </tr>
  ";
      }

      ?> -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>新規スレッド作成ページ</title>
  <link rel="stylesheet" href="../../assets/css/style.css">

</head>

<body>
  <?php include("../../app/parts/header.php"); ?>

  <!-- バリデーションチェック -->
  <?php include("../parts/validation.php"); ?>

  <div>
    <h2>新規スレッド立ち上げ場</h2>
  </div>
  <form method="POST" class="formWrapper">
    <div>
      <label>スレッド名</label>
      <input type="text" name="title">
    </div>
  </form>

</body>

</html>