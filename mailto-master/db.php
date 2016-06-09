<?php
 
// function db_connect(){
// 	$dsn = 'mysql:host=pre_member;dbname=localhost:8080;charset=utf8';
// 	$user = 'root';
// 	$password = 'sp4p09y6';
	
// 	try{
// 		$dbh = new PDO($dsn, $user, $password);
// 		return $dbh;
// 	}catch (PDOException $e){
// 	    	print('Error:'.$e->getMessage());
// 	    	die();
// 	}
// }
 
?>


<?php

// function db_connect(){
// 	//ステップ1.db接続
// 	$dsn='mysql:dbname=pre_member;host=localhost:8080';/*本来はIPアドレスを指定*/

// 	//接続するためのユーザー情報
// 	$user='root';
// 	$password='sp4p09y6';

// 	//DB接続オブジェクトを作成
// 	$dbh=new PDO($dsn,$user,$password);

// 	//接続したDBオブジェクトで文字コードutf8を使うように指定
// 	$dbh->query('SET NAMES utf8');


// 	return $dbh;
// }

?>

<?php

function db_connect(){
	//ステップ1.db接続
	$dsn='mysql:dbname=cebroad_premember;host=mysql532.db.sakura.ne.jp';/*本来はIPアドレスを指定*/

	//接続するためのユーザー情報
	$user='cebroad';
	$password='1365HAdK';

	//DB接続オブジェクトを作成
	$dbh=new PDO($dsn,$user,$password);

	//接続したDBオブジェクトで文字コードutf8を使うように指定
	$dbh->query('SET NAMES utf8');


	return $dbh;
}

?>