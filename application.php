<?php
  session_start();
  require('dbconnect.php');
  //セッションにidが存在し、かつセッションのtimeと3600秒足した値が
  //現在時刻より小さいときにログインをしていると判断する
  if(isset($_SESSION['id'])&&$_SESSION['time']+3600>time()){
    //セッションに保存している期間更新
    $_SESSION['time']=time();


    //ログインしているユーザーのデータをDBから取得
    $sql=sprintf('SELECT *, schools.name AS school_name FROM `members` JOIN `schools` ON members.school_id=schools.id WHERE `member_id`=%d',
      mysqli_real_escape_string($db, $_SESSION['id'])
      );
    $record=mysqli_query($db, $sql)or die(mysqli_error($db));
    $member=mysqli_fetch_assoc($record);


    //イベントカテゴリ
    $sql=sprintf('SELECT * FROM `event_categories` WHERE 1');
    $record=mysqli_query($db, $sql)or die(mysqli_error($db));

    $categories=array();

    while($categories[]=mysqli_fetch_assoc($record)){
    //実行結果として得られたデータを取得
    if($categories==false){
      break;
    }
    // $categories[]=mysqli_fetch_assoc($record);
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
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../webroot/assets/font-awesome/css/font-awesome.css">
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="../css/styles.css" rel="stylesheet">

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



                        <ul class="hidden-xs" style="list-style:none;">
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
                                  <select class="form-control" name="srch-term-categorys" class="form-control" >
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
                            <a href="../logout"><span class="badge">SignOut</span></a>
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
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                      <img src="../images/01.jpg" class="img-responsive" style="height:100%; width:30px;" alt="">
                                    </a>
                                    <ul class="dropdown-menu">
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
                                    </ul>
                                </li>
                            </ul>
                          </li>


                          </ul>
                    </div>

                    <!-- /top nav -->

                    <div class="padding">
                        <div class="full col-sm-9">

                          <!-- sidebar -->
                          <div class="column col-sm-2 col-md-2 hidden-xs sidebar-offcanvas" id="sidebar">
                            
                            <div class="profile-sidebar">
                              <!-- SIDEBAR USERPIC -->
                              <div class="profile-userpic">
                                <img src="../images/01.jpg" class="img-responsive" style="width:130px; height:100%;" alt=""><br>
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
                        <div class="row">

                            <?php
                              require($resource.'/'.$action.'.php');
                            ?>     
                          
                        </div><!-- /col-9 -->
                    </div><!-- /padding -->
                </div>
                <!-- /main -->

                  </div>             
            </div>
        </div>
    </div>


    <!--post modal-->
    <div id="postModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          Update Status
          </div>
          <div class="modal-body">
              <form class="form center-block">
                <div class="form-group">
                  <textarea class="form-control input-lg" autofocus="" placeholder="What do you want to share?"></textarea>
                </div>
              </form>
          </div>
          <div class="modal-footer">
              <div>
              <button class="btn btn-primary btn-sm" data-dismiss="modal" aria-hidden="true">Post</button>
                <ul class="pull-left list-inline"><li><a href=""><i class="glyphicon glyphicon-upload"></i></a></li><li><a href=""><i class="glyphicon glyphicon-camera"></i></a></li><li><a href=""><i class="glyphicon glyphicon-map-marker"></i></a></li></ul>
          </div>  
          </div>
      </div>
      </div>
    </div>
      <!-- script references -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script type="text/javascript" src="../webroot/assets/js/bootstrap.js"></script>

</body>
</html>
