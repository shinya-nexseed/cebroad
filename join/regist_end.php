<?php
 
header("Content-type: text/html; charset=utf-8");

if(empty($_SESSION['join'])) {
	header("Location: /cebroad/join/regist_form");
	exit();
}
//クロスサイトリクエストフォージェリ（CSRF）対策のトークン判定
if ($_SESSION['join']['token'] !== $_SESSION['join']['token']) {
	echo "There is a possibility of unauthorized access";
	exit();
}
 
//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');

 
//エラーメッセージの初期化
$errors = array(); 
	//POSTされたデータを変数に入れる
	$mail = $_SESSION['join']['email'];
	

 
if (count($errors) === 0){
	
	$urltoken = hash('sha256',uniqid(rand(),1));
	$url = "192.168.33.10/cebroad/join/signup/".$urltoken;
	
	//ここでデータベースに登録する
		$sql=sprintf('INSERT INTO pre_users SET urltoken="%s", email="%s"',
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

Please click on the link for your registration within 24hours. Thank you.
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
		// if (isset($_COOKIE["PHPSESSID"])) {
		// 	setcookie("PHPSESSID", '', time() - 1800, '/');
		// }
	
 		//セッションを破棄する
 		session_destroy();
 	
 		$message = "Thank you for your registration. A confirmation email has been sent to your email address. Please click on the link for your registration within 24hours. Thank you.";
 	
	 } else {
		$errors['mail_error'] = "Failed to send a confirmation email";
	}	
}
 
?>
 
 
<!-- <input type="button" value="back" onClick="history.back()"> -->
 

<div class="container">
          <div class="row">
            <div class="col-md-6 col-md-offset-3">
              <div class="panel panel-login">
                <div class="panel-heading">
                	<h2>Email Confirmation</h2>
                  <div class="row">
                    <a href="#" id="register-form-link"></a>
                  </div>
                  <hr>
                </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-lg-12">
                  <!-- 登録完了を表示 -->
                <center>
                <?php if (count($errors) === 0): ?>
                	<p><?=$message?></p>
                <?php elseif (count($errors) > 0): ?>
                <p>Failed to send an email.</p>
            	<?php endif; ?>


                <br><br>
              </tbody>
            </table>
            </center>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

      