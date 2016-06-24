<?php
  if ( !function_exists('mime_content_type') ) {
      function mime_content_type($filename) {
          $mime_type = exec('file -Ib '.$filename);
          return $mime_type;
      }
  }

  if(isset($_SESSION['id'])) {
    //ログインしているユーザーのデータをDBから取得
    $sql = sprintf('SELECT *, schools.name AS school_name FROM `users` JOIN `schools` ON users.school_id=schools.id WHERE users.id=%d',
      $_SESSION['id']
      );

    $record = mysqli_query($db, $sql) or die('');
    $member = mysqli_fetch_assoc($record);

    //イベントカテゴリ呼び出し
    $sql=sprintf('SELECT * FROM `event_categories` WHERE 1');
    $record=mysqli_query($db, $sql) or die(mysqli_error($db));

    $categories=array();

    while($result = mysqli_fetch_assoc($record)) {
      //実行結果として得られたデータを取得
      $categories[] = $result;
    }

    //ログインしているユーザーが作成したイベントの表示用にデータを取得
    $sql=sprintf('SELECT *FROM `events` WHERE `organizer_id`='.$_SESSION['id'].' ORDER BY `date` DESC');

    $record=mysqli_query($db, $sql) or die('<h1>Sorry, something wrong happened. Please retry.</h1>');

    $event_users_makes = array();

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

    $sql=sprintf(
        'SELECT users.nick_name AS partner, events.title AS event, notification_topics.topic AS topic, events.id AS event_id, notifications.topic_id AS topic_id ,notifications.created AS created, notifications.id AS id
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
      
        echo '<script> location.replace("/portfolio/cebroad/events/show/' . $_POST['event_id'] . '"); </script>';
    }
    
    //通知画面に残っている項目数を表示するためにカウントする
    $sql=sprintf('SELECT COUNT(*) AS cnt FROM notifications WHERE click_flag=0 AND user_id='.$_SESSION['id']);
    $record=mysqli_query($db, $sql)or die(mysqli_error($db));
    $cnt_notification=mysqli_fetch_assoc($record);



  }else{
    //ログインしていない場合の処理
    header('Location: ../signin');
    exit();
  }

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Cebroad</title>
  <link rel="stylesheet" href="/portfolio/cebroad/webroot/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="/portfolio/cebroad/webroot/assets/font-awesome/css/font-awesome.min.css">
  <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <link rel="stylesheet" href="/portfolio/cebroad/webroot/assets/css/styles.css">
  <link rel="stylesheet" href="/portfolio/cebroad/webroot/assets/events/css/events.css">
  <link rel="stylesheet" href="/portfolio/cebroad/webroot/assets/events/css/users_show.css">
  <link rel="stylesheet" href="/portfolio/cebroad/webroot/assets/events/css/main.css">

  <style type="text/css">
    #target {
      background-color: #ccc;
      width: 500px;
      height: 330px;
      font-size: 24px;
      display: block;
    }
  </style>

  <!-- <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet"> -->
      <style type="text/css">
          @import url(https://fonts.googleapis.com/css?family=Oswald:400,300);
  @import url(https://fonts.googleapis.com/css?family=Open+Sans);
  body
  {
  font-family: 'Open Sans', sans-serif;
  }
  .chat_box .chat_message_wrapper ul.chat_message > li + li {
      margin-top: 4px;
  }
  .popup-box-on {
      display: block !important;
  }
  a:focus {
      outline: none;
      outline-offset: 0px;
  }
  .popup-head-left.pull-left h1 {
      color: #fff;
      float: left;
      font-family: oswald;
      font-size: 18px;
      margin: 2px 0 0 5px;
     
  }
  .popup-head-left a small {
      display: table;
      font-size: 11px;
      color: #fff;
      line-height: 4px;
      opacity: 0.5;
      padding: 0 0 0 7px;
  }
  .chat-header-button {
      background: transparent none repeat scroll 0 0;
      border: 1px solid #fff;
      border-radius: 7px;
      font-size: 15px;
      height: 26px;
      opacity: 0.9;
      padding: 0;
      text-align: center;
      width: 26px;
  }
  .popup-head-right {
      margin: 9px 0 0;
  }
  .popup-head .btn-group {
      margin: -5px 3px 0 -1px;
  }
  .gurdeepoushan .dropdown-menu {
      padding: 6px;
  }
  .gurdeepoushan .dropdown-menu li a span {
      border: 1px solid;
      border-radius: 50px;
      display: list-item;
      font-size: 19px;
      height: 40px;
      line-height: 36px;
      margin: auto;
      text-align: center;
      width: 40px;
  }
  .gurdeepoushan .dropdown-menu li {
      float: left;
      text-align: center;
      width: 33%;
  }
  .gurdeepoushan .dropdown-menu li a {
      border-radius: 7px;
      font-family: oswald;
      padding: 3px;
     transition: all 0.3s ease-in-out 0s;
  }
  .gurdeepoushan .dropdown-menu li a:hover {
      background:#ff2a50 none repeat scroll 0 0 !important;
      color: #fff;
  }
  .popup-head {
      background: #ff2a50 none repeat scroll 0 0 !important;
      border-bottom: 3px solid #ccc;
      color: #fff;
      display: table;
      width: 100%;
      padding: 8px;
  }
  .popup-head .md-user-image {
      border: 2px solid #5a7172;
      border-radius: 12px;
      float: left;
      width: 44px;
  }
  .uk-input-group-addon .glyphicon.glyphicon-send {
      color: #ffffff;
      font-size: 21px;
      line-height: 36px;
      padding: 0 6px;
  }
  .chat_box_wrapper.chat_box_small.chat_box_active {
      
      height: 342px;
      overflow-y: scroll;
      width: 316px;
  }
  aside {
       background-attachment: fixed;
      background-clip: border-box;
      background-color: rgba(0, 0, 0, 0);
      background-color:lightgrey ;
      background-origin: padding-box;
      background-position: center top;
      background-repeat: repeat;
      border: 1px solid #ff2a50;
      bottom: 0;
      display: none;
      height: 466px;
      position: fixed;
      right: 70px;
      width: 300px;
      font-family: 'Open Sans', sans-serif;
  }
  .chat_box {
      padding: 16px;
  }
  .chat_box .chat_message_wrapper::after {
      clear: both;
  }
  .chat_box .chat_message_wrapper::after, .chat_box .chat_message_wrapper::before {
      content: " ";
      display: table;
  }
  .chat_box .chat_message_wrapper .chat_user_avatar {
      float: left;
  }
  .chat_box .chat_message_wrapper {
      margin-bottom: 32px;
  }
  .md-user-image {
      border-radius: 50%;
      width: 34px;
  }
  img {
      border: 0 none;
      box-sizing: border-box;
      height: auto;
      max-width: 100%;
      vertical-align: middle;
  }
  .chat_box .chat_message_wrapper ul.chat_message, .chat_box .chat_message_wrapper ul.chat_message > li {
      list-style: outside none none;
      padding: 0;
  }
  .chat_box .chat_message_wrapper ul.chat_message {
      float: left;
      margin: 0 0 0 20px;
      max-width: 77%;
  }
  .chat_box.chat_box_colors_a .chat_message_wrapper ul.chat_message > li:first-child::before {
      border-right-color: #616161;
  }
  .chat_box .chat_message_wrapper ul.chat_message > li:first-child::before {
      border-color: transparent #ededed transparent transparent;
      border-style: solid;
      border-width: 0 16px 16px 0;
      content: "";
      height: 0;
      left: -14px;
      position: absolute;
      top: 0;
      width: 0;
  }
  .chat_box.chat_box_colors_a .chat_message_wrapper ul.chat_message > li {
      background: #FCFBF6 none repeat scroll 0 0;
      color: #000000;
  }
  .open-btn {
      border: 2px solid #ff2a50;
      border-radius: 32px;
      color: #ff2a50 !important;
      display: inline-block;
      margin: 10px 0 0;
      padding: 9px 16px;
      text-decoration: none !important;
      text-transform: uppercase;
  }
  .chat_box .chat_message_wrapper ul.chat_message > li {
      background: #ededed none repeat scroll 0 0;
      border-radius: 4px;
      clear: both;
      color: #212121;
      display: block;
      float: left;
      font-size: 13px;
      padding: 8px 16px;
      position: relative;
      word-break: break-all;
  }
  .chat_box .chat_message_wrapper ul.chat_message, .chat_box .chat_message_wrapper ul.chat_message > li {
      list-style: outside none none;
      padding: 0;
  }
  .chat_box .chat_message_wrapper ul.chat_message > li {
      margin: 0;
  }
  .chat_box .chat_message_wrapper ul.chat_message > li p {
      margin: 0;
  }
  .chat_box.chat_box_colors_a .chat_message_wrapper ul.chat_message > li .chat_message_time {
      color: rgba(185, 186, 180, 0.9);
  }
  .chat_box .chat_message_wrapper ul.chat_message > li .chat_message_time {
      color: #727272;
      display: block;
      font-size: 11px;
      padding-top: 2px;
      text-transform: uppercase;
  }
  .chat_box .chat_message_wrapper.chat_message_right .chat_user_avatar {
      float: right;
  }
  .chat_box .chat_message_wrapper.chat_message_right ul.chat_message {
      float: right;
      margin-left: 0 !important;
      margin-right: 24px !important;
  }
  .chat_box.chat_box_colors_a .chat_message_wrapper.chat_message_right ul.chat_message > li:first-child::before {
      border-left-color: #ffa5b5;
  }
  .chat_box.chat_box_colors_a .chat_message_wrapper ul.chat_message > li:first-child::before {
      border-right-color: #FCFBF6;
  }
  .chat_box .chat_message_wrapper.chat_message_right ul.chat_message > li:first-child::before {
      border-color: transparent transparent transparent #ededed;
      border-width: 0 0 29px 29px;
      left: auto;
      right: -14px;
  }
  .chat_box .chat_message_wrapper ul.chat_message > li:first-child::before {
      border-color: transparent #ededed transparent transparent;
      border-style: solid;
      border-width: 0 29px 29px 0;
      content: "";
      height: 0;
      left: -14px;
      position: absolute;
      top: 0;
      width: 0;
  }
  .chat_box.chat_box_colors_a .chat_message_wrapper.chat_message_right ul.chat_message > li {
      background: #ffa5b5 none repeat scroll 0 0;
  }
  .chat_box .chat_message_wrapper ul.chat_message > li {
      background: #ededed none repeat scroll 0 0;
      border-radius: 12px;
      clear: both;
      color: #212121;
      display: block;
      float: left;
      font-size: 13px;
      padding: 8px 16px;
      position: relative;
  }
  .gurdeep-chat-box {
      background: #fff none repeat scroll 0 0;
      border-radius: 5px;
      float: left;
      padding: 3px;
      width: 243px;
  }
  #submit_message {
      background: transparent none repeat scroll 0 0;
      border: medium none;
      padding: 4px;
  }
  .gurdeep-chat-box i {
      color: #333;
      font-size: 21px;
      line-height: 1px;
  }
  .chat_submit_box {
      bottom: 0;
      box-sizing: border-box;
      left: 0;
      overflow: hidden;
      padding: 10px;
      position: absolute;
      width: 100%;
  }
  .uk-input-group {
      border-collapse: separate;
      display: table;
      position: relative;
  }
      </style>
      <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
      <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="wrapper">
      <div class="box">
          <div class="row row-offcanvas row-offcanvas-left">
              <!-- main right col -->
              <div class="column col-sm-12 col-xs-12" id="main">
                  
                  <!-- top nav -->
                  <div class="navbar navbar-blue navbar-fixed-top">  
                    <a href="/portfolio/cebroad/events/index" class="navbar-brand logo">C</a>
                      <ul style="list-style:none;" class="hidden-xs">
                        <li style="display:inline-block; float:left;" class="navbar-form navbar-left">
                          <div class="input-group input-group-sm" style="max-width:600px;">
                          <form method="get">
                              <select class="form-control" name="srch-term-categories" class="form-control" >
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

                        <li style="display:inline-block; float:left;" class="navbar-form navbar-right">
                          <a href="/portfolio/cebroad/signout"><span class="badge">SignOut</span></a>
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
                                        <strong><?php echo $notification['partner'] ?></strong>
                                        <?php echo $notification['topic'] ?>
                                        <strong><?php echo $notification['event'] ?></strong>
                                      <?php } ?>
                                      <?php if($notification['topic_id']==3||$notification['topic_id']==4){?>
                                        <strong><?php echo $notification['event'] ?></strong>
                                        <?php echo $notification['topic'] ?>
                                      <?php } ?>
                                    </p>
                                    <form method="post" action="">
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
                       
                        <li style="display:inline-block;" class="navbar-right">
                            <ul class="nav navbar-right">
                              <li class="dropdown menu">
                                  <a href="" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="/portfolio/cebroad/views/users/profile_pictures/<?php echo $member['profile_picture_path']; ?>" class="img-responsive img-circle" style="height:auto; width:30px;" alt="">
                                  </a>
                                  <ul class="dropdown-menu"　style="word-wrap: break-word;">
                                      <li>
                                          <div class="navbar-login">
                                              <div class="row">
                                                  <div class="col-lg-4">
                                                      <p class="text-center">
                                                          <img src="/portfolio/cebroad/views/users/profile_pictures/<?php echo $member['profile_picture_path']; ?>" class="img-responsive" style="height:auto; width:150px;" alt="">
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
                                                           <a href="/portfolio/cebroad/users/edit"><button type="button" class="btn btn-success btn-sm">User Edit</button></a><br>
                                                          <a href="/portfolio/cebroad/events/add"><button type="button" class="btn btn-primary btn-sm">Make Event</button></a>
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

                        <div class="visible-xs">
                          <!-- <li style="display:inline-block;"> -->
                            <ul class="nav navbar-nav navbar-form navbar-right">
                              <li class="dropdown" style="display:inline-block;">

                                  <a href="" class="dropdown-toggle" data-toggle="dropdown"  class="navbar-right">
                                    <img src="/portfolio/cebroad/views/users/profile_pictures/<?php echo $member['profile_picture_path']; ?>" class="img-responsive" style="height:100%; width:30px;" alt="">
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

                                                              <select class="form-control" name="srch-term-categories" class="form-control">
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

                                                           <a href="/portfolio/cebroad/users/edit"><button type="button" class="btn btn-success btn-sm">User Edit</button></a><br>
                                                          <a href="/portfolio/cebroad/events/add"><button type="button" class="btn btn-primary btn-sm">Make Event</button></a>
                                                      </p>
                                                  </div>
                                              </div>
                                          </div>
                                      </li>
                                      <li>

                                        <a href="/portfolio/cebroad/logout"><span class="badge">SignOut</span></a>
                                      </li>
                                  </ul>
                              </li>
                          </ul>
                        <!-- </li> -->


                        </div>
                  </div>

                  <!-- /top nav -->

                  <div class="padding">
                      <div class="full col-sm-12">

                        <!-- sidebar -->
                        <div class="column col-sm-2 col-md-2 hidden-xs sidebar-offcanvas" id="sidebar">
                          
                          <div class="profile-sidebar">
                            <!-- SIDEBAR USERPIC -->
                            <div class="profile-userpic">

                              <img src="/portfolio/cebroad/views/users/profile_pictures/<?php echo $member['profile_picture_path']; ?>" class="img-responsive" alt=""><br>
                            </div>
                            <!-- END SIDEBAR USERPIC -->

                            <!-- SIDEBAR BUTTONS -->

                              <a href="/portfolio/cebroad/users/edit"><button type="button" class="btn btn-success btn-sm">User Edit</button></a>
                              <a href="/portfolio/cebroad/events/add"><button type="button" class="btn btn-primary btn-sm">Make Event</button></a>

                              <br>
                              <br>
                            
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

                                      <a href="/portfolio/cebroad/events/show/<?php echo $event_users_make['id']?>"><?php  echo $event_users_make['title'];?></a></p>
                                    <?php } ?>
                                  </div>
                                </div>
                            </div>

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

                                      <a href="/portfolio/cebroad/events/show/<?php echo $event_users_part['id']?>">
                                      <?php echo $event_users_part['title'];?></a></p>
                                    <?php } ?>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <!-- END SIDEBAR BUTTONS -->
                        </div>
                        <!-- /sidebar -->
                        
                      <!-- content -->                      
                      <div class="column col-sm-10">
                        <div class="row">
                          <?php
                              $url = dirname(__FILE__).'/views/'.$resource.'/'.$action.'.php';
                              // echo $url;
                          ?>

                          <?php if (@file_get_contents($url)):?>
                              <?php require($url); ?>
                          <?php else: ?>
                              <h1>Sorry, we couldn't find that page.</h1>
                              <a href="/portfolio/cebroad/events/index">Go to the top page</a>
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

  <?php 
    if ($resource === 'events' && $action === 'show') {
      require(dirname(__FILE__).'/views/events/chat.php');
    }
   ?>


  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
  <script type="text/javascript" src="/portfolio/cebroad/webroot/assets/js/bootstrap.js"></script>
</body>
</html>
