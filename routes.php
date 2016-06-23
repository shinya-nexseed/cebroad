<?php
  session_start();
  define('DEBUG', TRUE); //環境切り替え用 TRUEで開発環境モード

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

  echo '<br>';
  echo '<br>';
  echo '<br>';
  echo '<br>';

  echo 'resource = '.$resource;
  echo '<br>';
  echo 'action = '.$action;
  echo '<br>';
  echo 'id = '.$id;
  echo '<br>';

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
      echo 'application';
      require('application.php');
    }
  }
?>
