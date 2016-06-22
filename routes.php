<?php
	// echo 'routes通過';
	$params = explode('/', $_GET['url']);

	$resource = $params[0];
	$action = "";
	$id = 0;
	$post = array();

	if (isset($params[1])) {
		$action = $params[1];
		// if (strpos($action, '?'))
	}

	if (isset($params[2])) {
		$id = $params[2];
	}

	if (isset($_POST) && !empty($_POST)) {
		$post = $_POST;
	}
	// if (empty($resource)) {
	// 	echo 'リソースがから';
	// } else {
	// 	echo $resource;
	// }


	if ($resource === 'index' || $resource === '') {
		require('index.php');
	} else if ($resource === 'signin') {
		require('signin.php');
	} else if ($resource === 'join') {
		require('join/join_layout.php'); 
	} else {
		require('application.php');
	}
?>
