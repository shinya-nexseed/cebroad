<?php
 
header("Content-type: text/html; charset=utf-8");
 
//クロスサイトリクエストフォージェリ（CSRF）対策のトークン判定
if ($_POST['token'] !== $_SESSION['token']){
	echo "不正アクセスの可能性あり";
	exit();
}
 
//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

 
//エラーメッセージの初期化
$errors = array();
 
if(empty($_POST)) {
	header("Location: /cebroad/join/regist_form.php");
	exit();
}else{
	//POSTされたデータを変数に入れる
	$mail = isset($_POST['mail']) ? $_POST['mail'] : NULL;
	
	//メール入力判定
	if ($mail === ''){
		$errors['mail'] = "メールが入力されていません。";
	}else{
		if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mail)){
			//$errors['mail_check'] = "メールアドレスの形式が正しくありません。";
		}
		
		/*
		ここで本登録用のmemberテーブルにすでに登録されているmailかどうかをチェックする。
		$errors['member_check'] = "このメールアドレスはすでに利用されております。";
		*/
	}
}
 
if (count($errors) === 0){
	
	$urltoken = hash('sha256',uniqid(rand(),1));
	$url = "192.168.33.10/cebroad/join/signup/".$urltoken;
	
	//ここでデータベースに登録する
		$sql=sprintf('INSERT INTO pre_member SET urltoken="%s", mail="%s"',
			mysqli_real_escape_string($db, $urltoken),
			mysqli_real_escape_string($db, $mail)
			);
		mysqli_query($db, $sql) or die(mysqli_error($db));
		//プレースホルダへ実際の値を設定する

			
		//データベース接続切断
		$db = null;
		
	
	//メールの宛先
	$mailTo = $mail;
 
	//Return-Pathに指定するメールアドレス
	$returnMail = 'pre_member@cebroad.sakura.ne.jp';
 
	$name = "Cebroad";
	$mail = 'pre_member@cebroad.sakura.ne.jp';
	$subject = "[Cebroad]Call for registration";
 
$body = <<< EOM
送信実験
24時間以内に下記のURLからご登録下さい。
{$url}
EOM;
 
	mb_language('ja');
	mb_internal_encoding('UTF-8');
 
	//Fromヘッダーを作成
	$header = 'From: ' . mb_encode_mimeheader($name). ' <' . $mail. '>';
 
	if (mb_send_mail($mailTo, $subject, $body, $header, '-f'. $returnMail)) {
	
	 	//セッション変数を全て解除
		$_SESSION = array();
	
		//クッキーの削除
		if (isset($_COOKIE["PHPSESSID"])) {
			setcookie("PHPSESSID", '', time() - 1800, '/');
		}
	
 		//セッションを破棄する
 		session_destroy();
 	
 		$message = "A confirmation email has been sent to your email address. Please click on the link for your registration within 24hours. Thank you.";
 	
	 } else {
		$errors['mail_error'] = "Failed to send a confirmation email";
	}	
}
 
?>
 
<h1>email confirmation screen</h1>
 
<?php if (count($errors) === 0): ?>
 
<p><?=$message?></p>
 
<?php elseif(count($errors) > 0): ?>
 
<?php
foreach($errors as $value){
	echo "<p>".$value."</p>";
}
?>
 
<input type="button" value="戻る" onClick="history.back()">
 
<?php endif; ?>