<?php
  session_start();
  require('dbconnect.php');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Cebroad</title>
    <link href="/cebroad/webroot/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/cebroad/webroot/assets/font-awesome/css/font-awesome.css">
    <link href="/cebroad/webroot/assets/css/styles.css" rel="stylesheet">
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
