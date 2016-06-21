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
    <link href="/cebroad/webroot/assets/css/styles.css" rel="stylesheet">
    <link href="../webroot/assets/css/users_show.css" rel="stylesheet">
    <link href="../webroot/assets/css/bootstrap.css" rel="stylesheet">
  <?php
    function h($value){
      return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
  ?> 
</head>
<body>
  <?php
    require($resource.'/'.$action.'.php');
  ?>
</body>
</html>
