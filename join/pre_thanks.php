<?php

$url = sha1(mt_rand());
$to      = 'to@hoge.co.jp';
$subject = 'title';
$message = 'cebroad/join/thanks/'. $url;
$headers = 'From: from@hoge.co.jp' . "\r\n";

echo $message;
mail($to, $subject, $message, $headers);

$sql = 'INSERT INTO users SET url='. $url;
mysqli_query($db, $sql) or die(mysqli_error($db));

//url $url(sha1とrandを使って作った文字列)を格納する
//confirmed_flag 本会員登録されたかどうかを判定する
?>