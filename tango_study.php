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


$status = $stmt->execute(); //$status には実行結果が入るが，この時点ではまだデータ自体の取得はできていない点に注意
  
 if ($status == false) {
   $error = $stmt->errorInfo();
    exit('sqlError:'.$error[2]);
} else {
    // PHPではデータを取得するところまで実施
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
  <title>フラッシュカード</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="css/study.css">  
</head>

<body>
  <div id="card">
    <div id="card-front"></div>
    <div id="card-back"></div>
  </div>
  <div id="btn">次の単語へ</div>
  <a href="tango_input.php">登録画面</a>
  
	<script>
	
    (function () {
     
      // PHPのデータをJSに渡す
      let aryTango = <?=json_encode($result) ?>;
      console.log(aryTango);

      let card = document.getElementById('card');
      let cardFront = document.getElementById('card-front');
      let cardBack = document.getElementById('card-back');
      let btn = document.getElementById('btn');
      card.addEventListener('click', function () { //カードをクリックしたらflip関数適用
        flip();
      });
      btn.addEventListener('click', function () {  //ボタンをクリックしたらnext関数適用
        next();
      });

      function next() {
        if (card.className === 'open') {
          card.addEventListener('transitionend', setCard);
          flip();
        } else {
          setCard();
        }
      }
			
      function setCard() {
        let num = Math.floor(Math.random() * aryTango.length);
        cardFront.innerHTML = aryTango[num]["tango"];
        cardBack.innerHTML = aryTango[num]["nihongo"];
        card.removeEventListener('transitionend', setCard);
      }

      setCard();


      function flip() {
        card.className = card.className === '' ? 'open' : '';
      }
   })();



      window.addEventListener('keyup', function (e) {
        // console.log(e.keyCode);
        if (e.keyCode === 70) {                           //Fキー
          flip();
        } else if (e.keyCode === 78) {                    //Nキー
          next();
        }
      });

      


  </script>
</body>

</html>