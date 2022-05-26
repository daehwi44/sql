<?php

// 各種項目設定
$dbn ='mysql:dbname=gsacy_d02_01;charset=utf8mb4;port=3306;host=localhost';  //dbnameは対象のDBの名前
$user = 'root';
$pwd = '';

// DB接続
try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

// SQL作成&実行
$sql = 'SELECT * FROM tango_table';  //SELECTでDBからデータを取り出す
$stmt = $pdo->prepare($sql);

try {
  $status = $stmt->execute(); //$status には実行結果が入るが，この時点ではまだデータ自体の取得はできていない点に注意
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetchAll() 関数でデータ自体を取得する
  // echo "<pre>";            //var_dumpの結果をきれいに見せるHTMLのタグ
  // var_dump($result);
  // echo "</pre>";
  // exit();
  $output = "";               //空の箱を作って
  foreach ($result as $record) {
   $output .= "<tr><td>{$record["tango"]}</td><td>{$record["nihongo"]}</td></tr>";
  }
  } catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>登録済単語一覧（一覧画面）</title>
</head>

<body>
  <fieldset>
    <legend>登録済単語一覧（一覧画面）</legend>
    <a href="tango_input.php">入力画面</a>
    <table>
      <thead>
        <tr>
          <th>単語</th>
          <th>日本語</th>
        </tr>
      </thead>
      <tbody>
        <!-- ここに<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
          <?= $output ?>
      </tbody>
    </table>
  </fieldset>
</body>

</html>