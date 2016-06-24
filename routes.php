<?php
  session_start();
  define('DEBUG', TRUE); //環境切り替え用 TRUEで開発環境モード
  require('dbconnect.php');

  //htmlspecialcharsのショートカット
  function h($value){
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
  }

  $params = explode('/', $_GET['url']);
  $resource = $params[0];
  $action = "";
  $id = 0;
  $post = array();
  if (isset($params[1])) {
    $action = $params[1];
  }
  if (isset($params[2])) {
    $id = $params[2];
  }
  if (isset($_POST) && !empty($_POST)) {
    $post = $_POST;
  }

  if ($resource === 'index' || $resource === '') {
    require('views/index.php');
  } else {
    if ($resource === 'signin') {
      require('views/signin.php');
    } else if ($resource === 'signout') {
      require('views/signout.php');
    } else if ($resource === 'join') {
      require('views/join/join_layout.php'); 
    } else {
      require('application.php');
    }
  }
?>
