<?php
  session_start();
  require('dbconnect.php');
  // 仮ログインデータ
  // DBのusersテーブルにid = 1のデータを登録しておく
  //$_SESSION['id'] = 1;

  echo '<br>';
  echo 'application.phpを通過';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Cebroad</title>
      <!-- Bootstrap -->
    <link href="../webroot/assets/css/bootstrap.css" rel="stylesheet">
    <link href="../webroot/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../webroot/assets/css/form.css" rel="stylesheet">
    <link href="../webroot/assets/css/timeline.css" rel="stylesheet">
    <link href="../webroot/assets/css/signup.css" rel="stylesheet">
    <link href="../webroot/assets/css/main.css" rel="stylesheet">
</head>
<body>
  <?php
    require($resource.'/'.$action.'.php');
  ?>
</body>
</html>
