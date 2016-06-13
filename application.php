<?php
  session_start();
  require('dbconnect.php');
  // 仮ログインデータ
  // DBのusersテーブルにid = 1のデータを登録しておく
  $_SESSION['id'] = 1;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Cebroad</title>
  <link href="../webroot/assets/css/users_show.css" rel="stylesheet">
  <link href="../webroot/assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php
    echo 'application通過';
    echo '<br>';
    require($resource.'/'.$action.'.php');
  ?>
</body>
</html>
