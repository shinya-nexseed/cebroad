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
  <script src="/cebroad/webroot/assets/js/jquery.min.js"></script>
  <script src="/cebroad/webroot/assets/js/jquery.Jcrop.js"></script>
  <script type="text/javascript">
    $(function(){

      $('#cropbox').Jcrop({
        aspectRatio: 1,
        onSelect: updateCoords
      });

    });

    function updateCoords(c)
    {
      $('#x').val(c.x);
      $('#y').val(c.y);
      $('#w').val(c.w);
      $('#h').val(c.h);
    };

    function checkCoords()
    {
      if (parseInt($('#w').val())) return true;
      alert('Please select a crop region then press submit.');
      return false;
    };
  </script>
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
    function h($value){
      return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
  ?>
</head>
<body>
  <?php
    echo 'application通過';
    echo '<br>';
    require($resource.'/'.$action.'.php');
  ?>
</body>
</html>
