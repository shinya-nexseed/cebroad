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
  <link href="/cebroad/webroot/assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="/cebroad/webroot/assets/css/users_show.css" rel="stylesheet">
  <link href="/cebroad/webroot/assets/css/main.css" rel="stylesheet">

  <style type="text/css">
    #target {
      background-color: #ccc;
      width: 500px;
      height: 330px;
      font-size: 24px;
      display: block;
    }
  </style>
    <?php
    // function h($value){
    //   return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    // }
  ?>
</head>
<body>
  <?php
    // echo 'application通過';
    // echo '<br>';
    require($resource.'/'.$action.'.php');
  ?>
</body>
</html>
<script src="/cebroad/webroot/assets/js/jquery.min.js"></script>
<script src="/cebroad/webroot/assets/js/jquery.Jcrop.js"></script>
<script src="/cebroad/webroot/assets/js/inputfile.js"></script>
<script src="/cebroad/webroot/assets/js/crop.js"></script>
