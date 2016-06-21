<?php
  session_start();
  require('dbconnect.php');
  // //セッションにidが存在し、かつセッションのtimeと3600秒足した値が
  // //現在時刻より小さいときにログインをしていると判断する
  // if(isset($_SESSION['id'])&&$_SESSION['time']+3600>time()){
  //   //セッションに保存している期間更新
  //   $_SESSION['time']=time();


  //   //ログインしているユーザーのデータをDBから取得
  //   $sql=sprintf('SELECT *, schools.name AS school_name FROM `users` JOIN `schools` ON users.school_id=schools.id WHERE users.id=%d',
  //     mysqli_real_escape_string($db, $_SESSION['id'])
  //     );
  //   $record=mysqli_query($db, $sql)or die(mysqli_error($db));
  //   $member=mysqli_fetch_assoc($record);


    //イベントカテゴリ呼び出し
    $sql=sprintf('SELECT * FROM `event_categories` WHERE 1');
    $record=mysqli_query($db, $sql)or die(mysqli_error($db));

    $categories=array();

    while($categories[]=mysqli_fetch_assoc($record)){
    //実行結果として得られたデータを取得
    if($categories==false){
      break;
      }
    }

  //ログインしているユーザーが作成したイベントの表示用にデータを取得
  $sql=sprintf('SELECT *FROM `events` WHERE `organizer_id`='.$_SESSION['id'].' ORDER BY `date` DESC');

  $record=mysqli_query($db, $sql)or die(mysqli_error($db));

  $event_users_makes=array();

  while($event_users_makes[]=mysqli_fetch_assoc($record)){
    //実行結果として得られたデータを取得
    if($event_users_makes==false){
      break;
      }
    }


  //ログインしているユーザーが参加するイベントの表示用にデータを取得
  $sql=sprintf('SELECT *FROM `events` 
    INNER JOIN `participants` ON events.id=participants.event_id
    WHERE participants.user_id='.$_SESSION['id'].
    ' ORDER BY `date` DESC'
    );

  $record=mysqli_query($db, $sql)or die(mysqli_error($db));

  $event_users_parts=array();

  while($event_users_parts[]=mysqli_fetch_assoc($record)){
    //実行結果として得られたデータを取得
    if($event_users_parts==false){
      break;
      }
    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Cebroad</title>
    <link href="/cebroad/webroot/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/cebroad/webroot/assets/font-awesome/css/font-awesome.css">
    <link href="/cebroad/webroot/assets/css/styles.css" rel="stylesheet">
  <?php
    function h($value){
      return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
  ?>
</head>
<body>
                
    <?php
    require($resource.'/'.$action.'.php');
    ?>     
  
</body>
</html>
