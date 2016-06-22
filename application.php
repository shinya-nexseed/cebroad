<?php
session_start();
require('dbconnect.php');

  //セッションにidが存在し、かつセッションのtimeと3600秒足した値が
  //現在時刻より小さいときにログインをしていると判断する
if(isset($_SESSION['id'])&&$_SESSION['time']+3600>time()){
    //セッションに保存している期間更新
  $_SESSION['time']=time();


    //ログインしているユーザーのデータをDBから取得
  $sql=sprintf('SELECT *, schools.name AS school_name FROM `users` JOIN `schools` ON users.school_id=schools.id WHERE users.id=%d',
    mysqli_real_escape_string($db, $_SESSION['id'])
    );
  $record=mysqli_query($db, $sql)or die(mysqli_error($db));
  $member=mysqli_fetch_assoc($record);


    //イベントカテゴリ呼び出し
  $sql=sprintf('SELECT * FROM `event_categories` WHERE 1');
  $record=mysqli_query($db, $sql)or die(mysqli_error($db));

  $categories=array();

  while($result=mysqli_fetch_assoc($record)){
    //実行結果として得られたデータを取得
    $categories[]=$result;
  }

  //ログインしているユーザーが作成したイベントの表示用にデータを取得
  $sql=sprintf('SELECT *FROM `events` WHERE `organizer_id`='.$_SESSION['id'].' ORDER BY `date` DESC');

  $record=mysqli_query($db, $sql)or die(mysqli_error($db));

  $event_users_makes=array();

  while($result=mysqli_fetch_assoc($record)){
    //実行結果として得られたデータを取得
    $event_users_makes[]=$result;
  }


  //ログインしているユーザーが参加するイベントの表示用にデータを取得
  $sql=sprintf('SELECT *FROM `events` 
    INNER JOIN `participants` ON events.id=participants.event_id
    WHERE participants.user_id='.$_SESSION['id'].
    ' ORDER BY `date` DESC'
    );

  $record=mysqli_query($db, $sql)or die(mysqli_error($db));

  $event_users_parts=array();

  while($result=mysqli_fetch_assoc($record)){
    //実行結果として得られたデータを取得
    $event_users_parts[]=$result;
  }

  //通知機能で表示するデータを取得
  $sql=sprintf(
    'SELECT users.nick_name AS partner, events.event_name AS event, notification_topics.topic AS topic, events.id AS event_id, notifications.topic_id AS topic_id ,notifications.created AS created, notifications.id AS id
    FROM `notifications` 
    LEFT JOIN `users` ON users.id=notifications.partner_id
    LEFT JOIN `notification_topics` ON notifications.topic_id=notification_topics.id
    LEFT JOIN `events` ON notifications.event_id=events.id
    WHERE notifications.user_id=%d
    AND `click_flag`=0 ORDER BY notifications.created DESC',
    $_SESSION['id']
    );

  $record=mysqli_query($db, $sql)or die(mysqli_error($db));

  $notifications=array();

  while($result=mysqli_fetch_assoc($record)){
    //実行結果として得られたデータを取得
    $notifications[]=$result;
  }

  //通知内容からevent_idが呼び出されたとき、クリックした履歴としてフラグを0⇒1にする
  if(isset($_POST['event_id'])){
    $sql=sprintf('UPDATE `notifications` SET `click_flag`=1 WHERE `id`='.$_POST['id']);
    $record=mysqli_query($db, $sql)or die(mysqli_error($db));

    header('Location: /cebroad/events/show/'.$_POST['event_id']);
  }

  //通知画面に残っている項目数を表示するためにカウントする
  $sql=sprintf('SELECT COUNT(*) AS cnt FROM notifications WHERE click_flag=0 AND user_id='.$_SESSION['id']);
  $record=mysqli_query($db, $sql)or die(mysqli_error($db));
  $cnt_notification=mysqli_fetch_assoc($record);


}else{
    //ログインしていない場合の処理
  header('Location: ../login');
  exit();
}
  //データベースから切断
$dbh = null;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Cebroad</title>
  <meta name="generator" content="Bootply" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- CSS -->
  <link href="/cebroad/webroot/assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/cebroad/webroot/assets/font-awesome/css/font-awesome.css">
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->
      <link href="/cebroad/webroot/assets/css/styles.css" rel="stylesheet">

      <!-- ドロップダウンメニュー表示用関数 -->
      <script>
        $(document).ready(function(){
        //Handles menu drop down
        $('.dropdown-menu').find('form').click(function (e) {
          e.stopPropagation();
        });
      });
    </script>

    <!--  サニタイズ処理-->
    <?php
    function h($value){
      return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    ?>


  </head>
  <body>
    <div class="wrapper">
      <div class="box">
        <div class="row row-offcanvas row-offcanvas-left">
          <!-- main right col -->
          <div class="column col-sm-12 col-xs-12" id="main">
            
            <!-- top nav ヘッダー-->
            <div class="navbar navbar-blue navbar-fixed-top">  
              <a href="/cebroad/events/index" class="navbar-brand logo">C</a>
              <ul style="list-style:none;" class="hidden-xs">
                <li style="display:inline-block; float:left;" class="navbar-form navbar-left">

                  <!-- 検索窓 -->
                  <div class="input-group input-group-sm" style="max-width:600px;">
                    <form method="post" action="/cebroad/events/index_show">
                      <select class="form-control" name="srch-categories" class="form-control" >
                        <option value="0" selected>Select Category</option>
                        <?php
                        foreach ($categories as $category) {
                          echo '<option value="'.$category['id'].'">'.$category['name'].'</option>';
                        }
                        
                        ?>
                      </select>
                      <input type="text" class="form-control" placeholder="Search Events as Title" name="srch-word" id="srch-term">
                      <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                      </div>
                    </div>
                  </form>
                </li>

                <!-- サインアウトボタン -->
                <li style="display:inline-block; float:left;" class="navbar-form navbar-right">
                  <a href="/cebroad/logout"><span class="badge">SignOut</span></a>
                </li>

                <!-- 通知ボタン -->
                <li style="display:inline-block; float:left;" class="navbar-form navbar-right">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="badge"><i class="fa fa-bell-o fa-2x" aria-hidden="true"></i></span></a><span class="badge"><?php echo $cnt_notification['cnt']; ?></span>
                  <ul class="dropdown-menu">
                    <?php foreach ($notifications as $notification) { ?>
                    <li>
                      <div class="navbar-login">
                        <div class="row">
                          <div class="col-lg-12" style="color:#000000">
                           <p class="text-left">
                            <?php if($notification['topic_id']==1||$notification['topic_id']==2){?>
                            <strong>                                     <?php echo $notification['partner'] ?></strong>
                            <?php echo $notification['topic'] ?>
                            <strong><?php echo $notification['event'] ?>
                            </strong>
                            <?php } ?>
                            <?php if($notification['topic_id']==3||$notification['topic_id']==4){?>
                            <strong>                                     <?php echo $notification['event'] ?></strong>
                            <?php echo $notification['topic'] ?>
                            <?php } ?>
                          </p>
                          <form method="post" action="/cebroad/events/show/<?php echo $notification['event_id']; ?>">
                           <input type="hidden" name="event_id" value="<?php echo $notification['event_id']; ?>">
                           <input type="hidden" name="id" value="<?php echo $notification['id']; ?>">
                           <input type="submit" class="text-right btn btn-default btn-xs" value="Detail>>">
                         </form>
                         <p class="text-right"><?php echo $notification['created'] ?></p>
                       </div>
                     </div>
                   </div>
                 </li>
                 <?php }?> 
               </ul>
             </li>

             <!-- ユーザー情報表示 -->
             <li style="display:inline-block;" class="navbar-right">
              <ul class="nav navbar-right">
                <li class="dropdown menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="/cebroad/users/profile_pictures/<?php echo $member['profile_picture_path']; ?>" class="img-responsive img-circle" style="height:auto; width:30px;" alt="">
                  </a>
                  <ul class="dropdown-menu"　style="word-wrap: break-word;">
                    <li>
                      <div class="navbar-login">
                        <div class="row">
                          <div class="col-lg-4">
                            <p class="text-center">
                              <img src="/cebroad/users/profile_pictures/<?php echo $member['profile_picture_path']; ?>" class="img-responsive" style="height:auto; width:150px;" alt="">
                            </p>
                          </div>
                          <div class="col-lg-8" style="color:#c0c0c0">
                            <p class="text-left"><strong><?php echo h($member['nick_name']);?></strong></p>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li class="divider"></li>
                    <li>
                      <div class="navbar-login navbar-login-session">
                        <div class="row">
                          <div class="col-lg-12">
                            <p>
                             <a href="/cebroad/users/edit"><button type="button" class="btn btn-success btn-sm">User Edit</button></a><br>
                             <a href="/cebroad/events/add"><button type="button" class="btn btn-primary btn-sm">Make Event</button></a>
                           </p>
                         </div>
                       </div>
                     </div>
                   </li>
                 </ul>
               </li>
             </ul>
           </li>


         </ul>

         <!-- スマホ用アイコン -->
         <div class="visible-xs">
          <!-- <li style="display:inline-block;"> -->
          <ul class="nav navbar-nav navbar-form navbar-right">
            <li class="dropdown" style="display:inline-block;">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"  class="navbar-right">
                <img src="/cebroad/users/profile_pictures/<?php echo $member['profile_picture_path']; ?>" class="img-responsive img-circle" style="height:100%; width:30px;" alt="">
              </a>
              <ul class="dropdown-menu">
                <li>
                  <div class="navbar-login">
                    <div class="row">
                      <div class="col-lg-8">
                        <p class="text-center">
                         <form method="get">
                          <div class="input-group input-group-sm" style="max-width:300px;">
                            <input type="text" class="form-control" placeholder="Search Events as Title" name="srch-word" id="srch-term">
                            <div class="input-group-btn">
                              <button class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </div>
                          </div>
                        </form> 
                      </p>
                    </div>
                    <div class="col-lg-8">
                      <p class="text-center">
                       <form method="get">
                        <div class="input-group input-group-sm" style="max-width:200px;">
                          <select class="form-control" name="srch-term-categories" class="form-control" >
                            <option value="0" selected>Select Category</option>
                            <?php
                            foreach ($categories as $category) {
                              echo '<option value="'.$category['id'].'">'.$category['name'].'</option>';
                            }
                            
                            ?>
                            
                          </select>
                          <div class="input-group-btn">
                            <button class="btn btn-default" type="submit" name="srch-category"><i class="fa fa-search" aria-hidden="true"></i></button>
                          </div>
                        </div>
                      </form> 
                    </p>
                  </div>
                  <div class="col-lg-8" style="color:#c0c0c0">
                    <p class="text-left"><strong><?php echo h($member['nick_name']);?></strong></p>  
                  </div>
                </div>
              </div>
            </li>
            <li class="divider"></li>
            <li>
              <div class="navbar-login navbar-login-session">
                <div class="row">
                  <div class="col-lg-12">
                    <p>
                     <a href="/cebroad/users/edit"><button type="button" class="btn btn-success btn-sm">User Edit</button></a><br>
                     <a href="/cebroad/events/add"><button type="button" class="btn btn-primary btn-sm">Make Event</button></a>
                   </p>
                 </div>
               </div>
             </div>
           </li>
           <li>
            <a href="/cebroad/logout"><span class="badge">SignOut</span></a>
          </li>
        </ul>
      </li>
    </ul>
    <!-- </li> -->


  </div>
</div>

<!-- /top nav ヘッダー-->

<div class="padding">
  <div class="full col-sm-12">

    <!-- sidebar サイドバー-->
    <div class="column col-sm-2 col-md-2 hidden-xs sidebar-offcanvas" id="sidebar">
      
      <div class="profile-sidebar">
        <!-- SIDEBAR USERPIC -->
        <div class="profile-userpic">
          <img src="/cebroad/users/profile_pictures/<?php echo $member['profile_picture_path']; ?>" class="img-responsive" alt=""><br>
        </div>
        <!-- END SIDEBAR USERPIC -->

        <!-- ユーザー情報編集、イベント新規作成画面 -->
        <!-- SIDEBAR BUTTONS -->
        <a href="/cebroad/users/edit"><button type="button" class="btn btn-success btn-sm">User Edit</button></a>
        <a href="/cebroad/events/add"><button type="button" class="btn btn-primary btn-sm">Make Event</button></a>
        <br>
        <br>
        
        <!-- ログインユーザーに関係しているイベントの表示 -->
        <!-- ログインユーザーが主催するイベント -->
        <div class="profile-event">
          <div class="panel panel-default">
            <!-- <div class="panel-heading"><a href="#" class="pull-right"></a> <h4>Bootstrap Examples</h4></div> -->
            <div class="panel-body">
              <p class="lead">You created</p>
              <div class="list-group">
                <?php foreach($event_users_makes as $event_users_make){ ?>
                <p>
                  <?php
                  $date = substr($event_users_make['date'],5,5);
                  echo $date;
                  echo '：';
                  ?>
                  <a href="/cebroad/events/show/<?php echo $event_users_make['id']?>"><?php  echo $event_users_make['event_name'];?></a></p>
                  <?php } ?>
                </div>
              </div>
            </div>

            <!-- ログインユーザーが参加するイベント -->
            <div class="panel panel-default">
              <!-- <div class="panel-heading"> profile-event<a href="#" class="pull-right"></a> <h4>Bootstrap Examples</h4></div> -->
              <div class="panel-body">
                <p class="lead">You are going</p>
                <div class="list-group">
                  <?php foreach($event_users_parts as $event_users_part){ ?>
                  <p>
                    <?php
                    $date = substr($event_users_part['date'],5,5);
                    echo $date;
                    echo '：';
                    ?>
                    <a href="/cebroad/events/show/<?php echo $event_users_part['id']?>">
                      <?php echo $event_users_part['event_name'];?></a></p>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- END SIDEBAR BUTTONS -->
          </div>
          <!-- /sidebar サイドバー-->
          
          <!-- content 各ページの読み込み-->                      
          <div class="column col-sm-10">
            <div class="row">
              <?php
                              // require($resource.'/'.$action.'.php');
              ?> 
              <?php
              $url = dirname(__FILE__).'/'.$resource.'/'.$action.'.php';
              if (@file_get_contents($url) !== false):?>
              <?php require($url); ?>
            <?php else: ?>
              <h1>Sorry, we couldn't find that page.</h1>
              <a href="/cebroad/events/index">Go to the top page</a>
            <?php endif; ?>
            
          </div>
        </div><!-- /col-9 -->
      </div><!-- padding -->
    </div>
    <!-- /main -->

  </div>             
</div>
</div>
</div>

<!-- script references JSのテンプレ読み込み-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script type="text/javascript" src="/cebroad/webroot/assets/js/bootstrap.js"></script>

</body>
</html>
