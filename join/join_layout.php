<?php
  session_start();
  require('dbconnect.php');
  // 仮ログインデータ
  // DBのusersテーブルにid = 1のデータを登録しておく
  $_SESSION['id'] = 1;
  echo 'join_layout通過ほげ';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Cebroad</title>
  <!-- Bootstrap -->
    <link href="/cebroad/webroot/assets/css/bootstrap.css" rel="stylesheet">
    <link href="/cebroad/webroot/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/cebroad/webroot/assets/css/form.css" rel="stylesheet">
    <link href="/cebroad/webroot/assets/css/timeline.css" rel="stylesheet">
    <link href="/cebroad/webroot/assets/css/signup.css" rel="stylesheet">
    <link href="/cebroad/webroot/assets/css/main.css" rel="stylesheet">
</head>
<body>
  <?php
    require($resource.'/'.$action.'.php');
  ?>
</body>
</html>
