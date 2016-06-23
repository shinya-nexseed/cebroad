<?php
  session_start();
  define('DEBUG', TRUE); //環境切り替え用 TRUEで開発環境モード
  require('dbconnect.php');


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
    require('index.php');
  } else {
    if ($resource === 'signin') {
      require('signin.php');
    } else if ($resource === 'signout') {
      require('signout.php');
    } else if ($resource === 'join') {
      require('views/join/join_layout.php'); 
    } else {
      require('application.php');
    }
  }
?>
