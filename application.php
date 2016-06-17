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

    while($categories[]=mysqli_fetch_assoc($record)){
    //実行結果として得られたデータを取得
    if($categories==false){
      break;
    }
  }


    if(!empty($id)){//events/showを読み込んで$idがあった場合
      //対象IDのイベントデータを取得
      $sql=sprintf('SELECT * FROM `events` JOIN `event_categories` ON events.event_category_id=event_categories.id WHERE events.id='.$id);
      $record=mysqli_query($db, $sql)or die(mysqli_error($db));
      $event=mysqli_fetch_assoc($record);


      //対象IDのイベントデータを取得
      $sql=sprintf('SELECT * FROM `users` WHERE `id`='.$event['organizer_id']);
      $record=mysqli_query($db, $sql)or die(mysqli_error($db));
      $organizer=mysqli_fetch_assoc($record);


      //対象イベントの参加者情報を取得
      $sql=sprintf('SELECT * FROM `users` JOIN `participants` ON `id`=participants.user_id WHERE participants.event_id='.$id);



      $record=mysqli_query($db, $sql)or die(mysqli_error($db));
      
      $event_participants=array();

      while($event_participants[]=mysqli_fetch_assoc($record)){
        //実行結果として得られたデータを取得
        if($event_participants==false){
          break;
        }
      }

      //対象イベントに対するコメントを取得
      $sql=sprintf('SELECT *FROM `comments` JOIN `users` ON `user_id`=users.id WHERE event_id='.$id);

      $record=mysqli_query($db, $sql)or die(mysqli_error($db));
      
      $comments=array();

      while($comments[]=mysqli_fetch_assoc($record)){
        //実行結果として得られたデータを取得
        if($comments==false){
          break;
        }
      }


      //対象のイベントIDのいいねを押している数を取得する
        $sql = sprintf('SELECT COUNT(*) AS cnt FROM likes WHERE event_id=%d',
        $id
        );

        $record = mysqli_query($db, $sql) or die(mysqli_error($db));
        $cnt_like = mysqli_fetch_assoc($record);


      //対象のイベントIDの参加ボタンを押している数を取得する
        $sql = sprintf('SELECT COUNT(*) AS cnt FROM participants WHERE event_id=%d',
          $id
          );


        $record = mysqli_query($db, $sql) or die(mysqli_error($db));
        $cnt_paticipant = mysqli_fetch_assoc($record);



     //すでにいいねされているかどうかを判定(いいねボタン中間テーブルのON/OFF、ボタンの色の切り替え用)
        $sql = sprintf('SELECT COUNT(*) AS cnt FROM likes WHERE user_id=%d AND event_id=%d',
        $_SESSION['id'],
        $id
        );



        $record = mysqli_query($db, $sql) or die(mysqli_error($db));
        $table_like = mysqli_fetch_assoc($record);


      //すでに参加ボタンを押しているかどうかを判定(参加ボタンのON/OFF中間テーブルのON/OFF、ボタンの色の切り替え用)
        $sql = sprintf('SELECT COUNT(*) AS cnt FROM participants WHERE user_id=%d AND event_id=%d',
          $_SESSION['id'],
          $id
          );

        $record = mysqli_query($db, $sql) or die(mysqli_error($db));
        $table_paticipant = mysqli_fetch_assoc($record);


      //いいねデータ更新
      if(isset($_POST['like'])){
        if($table_like['cnt']>0){//すでにデータが存在している場合
          $sql_like = sprintf('DELETE FROM `likes` WHERE user_id=%d AND event_id=%d',
          $_SESSION['id'],
          $id
          );

          $record=mysqli_query($db, $sql_like)or die(mysqli_error($db));
        }
        else{//データが存在しない場合
          $sql_like=sprintf('INSERT INTO `likes`(`user_id`, `event_id`) VALUES('.$_SESSION['id'].','.$id.')');
          $record=mysqli_query($db, $sql_like)or die(mysqli_error($db));
          }

          $sql = sprintf('SELECT COUNT(*) AS cnt FROM likes WHERE user_id=%d AND event_id=%d',
        $_SESSION['id'],
        $id
        );



        $record = mysqli_query($db, $sql) or die(mysqli_error($db));
        $table_like = mysqli_fetch_assoc($record);
          header('Location: /cebroad/'.$resource.'/'.$action.'/'.$id);
     
      }
       else if(isset($_POST['paticipant'])){
      
        if($table_paticipant['cnt']>0){//すでにデータが存在している場合
          $sql = sprintf('DELETE FROM `participants` WHERE user_id=%d AND event_id=%d',
          $_SESSION['id'],
          $id
          );
          $record=mysqli_query($db, $sql)or die(mysqli_error($db));


        }
        else{//データが存在しない場合
          $sql=sprintf('INSERT INTO `participants`(`user_id`, `event_id`) VALUES('.$_SESSION['id'].','.$id.')');
          $record=mysqli_query($db, $sql)or die(mysqli_error($db));
          }

          $sql = sprintf('SELECT COUNT(*) AS cnt FROM participants WHERE user_id=%d AND event_id=%d',
          $_SESSION['id'],
          $id
          );


        $record = mysqli_query($db, $sql) or die(mysqli_error($db));
        $table_paticipant = mysqli_fetch_assoc($record);

          header('Location: /cebroad/'.$resource.'/'.$action.'/'.$id);
      }

      //commentが送信された場合
      if(isset($_POST['comment'])){
        //コメントを保存
        $sql = sprintf('INSERT INTO `comments`(`event_id`, `user_id`, `comment`, `delete_flag`, `created`) VALUES (%d,%d,"%s",0,now())',
          $id,
          $_SESSION['id'],
          $_POST['comment']
          );
        $record = mysqli_query($db, $sql) or die(mysqli_error($db));
      }

      if(isset($_POST['comment_delete'])){
        //コメントを保存
        $sql = sprintf('DELETE FROM `comments` WHERE `id`='.$_POST['comment_delete']);
        $record = mysqli_query($db, $sql) or die(mysqli_error($db));
        echo $sql;
      }
  }

 
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
    <link href="/cebroad/webroot/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/cebroad/webroot/assets/font-awesome/css/font-awesome.css">
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="/cebroad/webroot/assets/css/styles.css" rel="stylesheet">

  <script>
    $(document).ready(function(){
        //Handles menu drop down
        $('.dropdown-menu').find('form').click(function (e) {
            e.stopPropagation();
        });
    });
  </script>

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
                    
                    <!-- top nav -->
                    <div class="navbar navbar-blue navbar-static-top">  
                      <a href="/cebroad/events/index" class="navbar-brand logo">C</a>
                        <ul style="list-style:none;" class="hidden-xs">
                          <li style="display:inline-block" class="navbar-form navbar-left">
                            <form method="get">
                                <div class="input-group input-group-sm" style="max-width:300px;">
                                  <input type="text" class="form-control" placeholder="Search Events as Title" name="srch-word" id="srch-term">
                                  <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                  </div>
                                </div>
                            </form>
                          </li>



                          <li style="display:inline-block;" class="navbar-form navbar-left">
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
                          </li>

                          <li style="display:inline-block" class="navbar-form navbar-right">
                            <a href="/cebroad/logout"><span class="badge">SignOut</span></a>
                          </li>


                            <li style="display:inline-block;" class="navbar-form navbar-right">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="badge"><i class="fa fa-bell-o fa-2x" aria-hidden="true"></i></span></a>
                                <ul class="dropdown-menu">
                                          <li>
                                              <div class="navbar-login">
                                                  <div class="row">
                                                      <div class="col-lg-12" style="color:#c0c0c0">
                                                          <p class="text-left"><strong>【nick_name】</strong> edit 【title】<a href="#">Detail>></a></p>
                                                            
                                                      </div>
                                                  </div>
                                              </div>
                                          </li>

                                          <li>
                                              <div class="navbar-login">
                                                  <div class="row">
                                                      <div class="col-lg-12" style="color:#c0c0c0">
                                                          <p class="text-left">You are received Message from<strong>【nick_name】</strong> <a href="#">Detail>></a></p>
                                                            
                                                      </div>
                                                  </div>
                                              </div>
                                          </li>
                                      </ul>
                            </li>
                         
                          <li style="display:inline-block;" class="navbar-right">
                              <ul class="nav navbar-right">
                                <li class="dropdown menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                      <img src="/cebroad/images/<?php echo $member['picture_path']; ?>" class="img-responsive" style="height:100%; width:30px;" alt="">
                                    </a>
                                    <ul class="dropdown-menu"　style="word-wrap: break-word;">
                                        <li>
                                            <div class="navbar-login">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <p class="text-center">
                                                            <img src="../images/01.jpg" class="img-responsive" style="height:100%; width:100px;" alt="">
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-8" style="color:#c0c0c0">
                                                        <p class="text-left"><strong><?php echo h($member['nick_name']);?></strong></p>
                                                        <p cl_pathass="text-left small"><?php echo h($member['email']);?></p>   
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

                          <div class="visible-xs">
                            <!-- <li style="display:inline-block;"> -->
                              <ul class="nav navbar-nav">
                                <li class="dropdown navbar-right" style="display:inline-block;">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"  class="navbar-right">
                                      <img src="/cebroad/images/01.jpg" class="img-responsive" style="height:100%; width:30px;" alt="">
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
                                                        <p class="text-left small"><?php echo h($member['email']);?></p>   
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

                    <!-- /top nav -->

                    <div class="padding">
                        <div class="full col-sm-12">

                          <!-- sidebar -->
                          <div class="column col-sm-2 col-md-2 hidden-xs sidebar-offcanvas" id="sidebar">
                            
                            <div class="profile-sidebar">
                              <!-- SIDEBAR USERPIC -->
                              <div class="profile-userpic">
                                <img src="/cebroad/images/<?php echo $member['picture_path']; ?>" class="img-responsive" style="width:130px; height:100%;" alt=""><br>
                              </div>
                              <!-- END SIDEBAR USERPIC -->

                              <!-- SIDEBAR BUTTONS -->
                              <div class="profile-userbuttons">
                                <a href="/cebroad/users/edit"><button type="button" class="btn btn-success btn-sm">User Edit</button></a>
                                <a href="/cebroad/events/add"><button type="button" class="btn btn-primary btn-sm">Make Event</button></a>
                                <br>
                                <br>
                              </div>
                              <!-- END SIDEBAR BUTTONS -->
                              <!-- SIDEBAR MENU -->
                              <div class="profile-usermenu">
                                <ul class="nav">
                                  <li class="active">
                                    <i class="glyphicon glyphicon-home"></i>
                                    NAME:<br><?php echo h($member['nick_name']);?><br>
                                  </li>
                                  <li>

                                    <i class="glyphicon glyphicon-user"></i>
                                    BIRTH:<br><?php echo h($member['birthday']);?><br>
                                  </li>
                                  <li>
                                    <i class="glyphicon glyphicon-ok"></i>
                                    SCHOOL:<br><?php echo h($member['school_name']);?><br>
                                  </li>
                                  <li>
                                    <i class="glyphicon glyphicon-flag"></i>
                                    INTRODUCTION:<br><?php echo h($member['introduction']);?><br>
                                  </li>
                                </ul>
                              </div>
                              <!-- END MENU -->
                            </div>
                            
                          </div>
                          <!-- /sidebar -->
                          
                        <!-- content -->                      
                        <div class="column col-sm-10">
                          <div class="row">
                            <?php
                              require($resource.'/'.$action.'.php');
                            ?>     
                          </div>
                        </div><!-- /col-9 -->
                    </div><!-- padding -->
                </div>
                <!-- /main -->

                  </div>             
            </div>
        </div>
    </div>

      <!-- script references -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script type="text/javascript" src="/cebroad/webroot/assets/js/bootstrap.js"></script>

</body>
</html>
