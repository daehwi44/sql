<?php
// POSTデータ確認
//var_dump($_POST);
//exit();

// データの受け取り
$tango = $_POST["tango"];
$nihongo = $_POST["nihongo"];

// 各種項目設定
$dbn ='mysql:dbname=gsacy_d02_01;charset=utf8mb4;port=3306;host=localhost'; //dbnameは対象のDBの名前
$user = 'root';
$pwd = '';

// DB接続   *ここは基本変えなくて良いらしい
try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

// SQL作成&実行
$sql = 'INSERT INTO tango_table (id, tango, nihongo, created_at, updated_at) VALUES (NULL, :tango, :nihongo, now(), now())';

$stmt = $pdo->prepare($sql);

// バインド変数を設定
$stmt->bindValue(':tango', $tango, PDO::PARAM_STR);
$stmt->bindValue(':nihongo', $nihongo, PDO::PARAM_STR);

// SQL実行（実行に失敗すると `sql error ...` が出力される）
try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

//データ入力画面へ移行
header('Location:tango_input.php');
exit();