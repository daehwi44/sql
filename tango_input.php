<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>単語学習アプリ</title>
</head>

<body>
  <form action="tango_create.php" method="POST">          <!--action,method-->
    <fieldset>
      <legend>単語登録画面（入力画面）</legend>
      <a href="tango_read.php">一覧画面</a>
      <a href="tango_study.php">学習画面</a>
      <div>
        単語: <input type="text" name="tango">      
      </div>
      <div>
        日本語: <input type="text" name="nihongo">  
      </div>
      <div>
        <button>登録</button>
      </div>
    </fieldset>
  </form>

</body>

</html>