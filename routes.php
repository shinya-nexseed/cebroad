<?php

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
		      // echo 'route1';

		require('index.php');
	} else {
		if($resource === 'login'){
			// echo 'route2';
			require('login.php');
		}

		else if($resource === 'logout'){
			require('logout.php');
		}
		else{
			// echo 'route3';
		require('application.php'); 
		}
	}
?>
