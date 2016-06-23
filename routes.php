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

  if ($resource === 'index' || $resource === '') {
    require('index.php');
  } else {
    if($resource === 'login'){
      require('login.php');
    }
    else if($resource === 'logout'){
      require('logout.php');
    } else{
      require('application.php');
    }
  }
?>
