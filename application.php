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

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
  <script type="text/javascript" src="/portfolio/cebroad/webroot/assets/js/bootstrap.js"></script>
  <script src="/portfolio/cebroad/webroot/assets/js/jquery.min.js"></script>
  <script src="/portfolio/cebroad/webroot/assets/js/jquery.Jcrop.js"></script>
  <script src="/portfolio/cebroad/webroot/assets/js/inputfile.js"></script>
  <script src="/portfolio/cebroad/webroot/assets/js/crop.js"></script>
</body>
</html>

