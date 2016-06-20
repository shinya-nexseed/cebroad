<?php
  session_start();
  require('dbconnect.php');
  // 仮ログインデータ
  // DBのusersテーブルにid = 1のデータを登録しておく
  // $_SESSION['id'] = 1;
  echo 'アプリケーション通過';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Cebroad</title>
</head>
<body>
  <?php
    require($resource.'/'.$action.'.php');
  ?>
</body>
</html>
