<?php

$url = sha1(mt_rand());//sha1、mt_rand関数を用いて、urlを作成

require_once ( 'PHPMailer/PHPMailerAutoload.php' );
 
// 外部SMTPサーバーのホスト名
$smtp_host = "ssl://smtp.gmail.com";
 
// 外部SMTPのポート番号
$smtp_port = "587";
 
// 外部SMTPに接続するユーザー名
$smtp_user = "kyoshino4626@gmail.com";
 
// 外部SMTPに接続するパスワード
$smtp_password = "1365HAdK";

//$to = $_SESSION['email'];
$to = 'rikutech@gmail.com';

$subject = 'A confirmation email for the registration';

$body = 'cebroad/join/thanks/'. $url;

$fromname = 'cebroad';

$fromaddress = $smtp_user; 

$ccadress = 'rikutech@gmail.com';

$bccadress = 'rikutech@gmail.com';
// Phpmailerを使ってメールを送信する関数の呼び出し
$res = phpmailersend ( $to, $subject, $body, $fromname, $fromaddress, $ccadress, $bccadress );
 
if ( $res == "Message has been sent" ){
  echo 'Message has been sent. '; // 正常処理
} else {
  echo 'error'; // エラー処理
}
 
 
// SMTPを使ってメール送信関数
function phpmailersend ( $to, $subject, $body, $fromname, $fromaddress, $ccadress="", $bccadress="" ){
 
  global $smtp_host, $smtp_port, $smtp_user, $smtp_password;
 
  $to_array  = explode ( ',', preg_replace ( '/\s/', '', $to  ) );
  $cc_array  = explode ( ',', preg_replace ( '/\s/', '', $ccadress  ) );
  $bcc_array = explode ( ',', preg_replace ( '/\s/', '', $bccadress ) );
 
  $mailer = new PHPMailer();
 
  $mailer -> CharSet = "iso-2022-jp";
  $mailer -> Encoding = "7bit";
  $mailer -> SMTPSecure = 'tls';
  $mailer -> IsSMTP();
  $mailer -> SMTPDebug = 2;
  $mailer -> Host = $smtp_host . ":" . $smtp_port;
  $mailer -> SMTPAuth = TRUE;
  $mailer -> Username = $smtp_user;        // Gmailのアカウント名
  $mailer -> Password = $smtp_password;    // Gmailのパスワード
  $mailer -> From     = $fromaddress;      // Fromのメールアドレス
  $mailer -> FromName = mb_encode_mimeheader ( mb_convert_encoding ( $fromname, "JIS", "UTF-8" ) );
  $mailer -> Subject  = mb_encode_mimeheader ( mb_convert_encoding ( $subject, "JIS", "UTF-8" ) );
  $mailer -> Body     = mb_convert_encoding ( $body, "JIS", "UTF-8" );
  foreach ( $to_array as $to ) {
    $mailer -> AddAddress ( $to );         // TO
  }
  foreach ( $cc_array as $cc ) {
    $mailer -> AddCC  ( $cc );             // CC
  }
  foreach ( $bcc_array as $bcc ) {
    $mailer -> AddBCC ( $bcc );            // BCC
  }
 
  if( !$mailer -> Send() ){
    $message  = "Message was not sent<br/ >";
    $message .= "Mailer Error: " . $mailer->ErrorInfo;
  } else {
    $message  = "Message has been sent";
  }
  return $message;
 }




// $to      = 's-e.a.w_0626@ezweb.ne.jp';//仮登録で得たメールアドレスをSESSION等を用いて、入力。
// $subject = 'A confirmation email for the registration';
// $message = 'cebroad/join/thanks/'. $url;
// $headers = 'kokiyoshino4626@gmail.com' . "\r\n";//メールアドレスの設定

// echo $message;
// mail($to, $subject, $message, $headers);

//$sql = 'INSERT INTO users SET url='. $url;
//mysqli_query($db, $sql) or die(mysqli_error($db));

//url $url(sha1とrandを使って作った文字列)を格納する
//confirmed_flag 本会員登録されたかどうかを判定する
?>

<p>Thank you for pre-registering. A confirmation email has been sent to your email address. Please click on the link for your registration.</p>
