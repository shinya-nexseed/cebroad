<?php
  session_start();
  require('dbconnect.php');
  // 仮ログインデータ
  // DBのusersテーブルにid = 1のデータを登録しておく
  $_SESSION['id'] = 1;
  function h($val) {
  return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
}

if ( !function_exists('mime_content_type') ) {
    function mime_content_type($filename) {
        $mime_type = exec('file -Ib '.$filename);
        return $mime_type;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Cebroad</title>
  <link rel="stylesheet" href="/cebroad/webroot/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="/cebroad/webroot/assets/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="/cebroad/webroot/assets/events/css/events.css">
</head>
<body>
  <?php
   $url = dirname(__FILE__).'/'.$resource.'/'.$action.'.php';
     if (@file_get_contents($url) !== false):?>
    <?php require($url); ?>
    <?php else: ?>
      <h1>Sorry, we couldn't find that page.</h1>
      <a href="/cebroad/index">Go to the top page</a>
    <?php endif; ?>

    ?>



</body>
</html>
