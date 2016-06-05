<?php
  session_start();
  require('dbconnect.php');
  // 仮ログインデータ
  // DBのusersテーブルにid = 1のデータを登録しておく
  $_SESSION['id'] = 1;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Cebroad</title>
  <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <div class="box">
            <div class="row row-offcanvas row-offcanvas-left">

                <!-- main right col -->
                <div class="column col-sm-12 col-xs-12" id="main">
                    
                    <!-- top nav -->
                    <div class="navbar navbar-blue navbar-static-top">  
                          <a href="/" class="navbar-brand logo">C</a>
                        <ul style="list-style:none;">
                          <li style="display:inline-block">
                            <form class="navbar-form navbar-left">
                                <div class="input-group input-group-sm" style="max-width:300px;">
                                  <input type="text" class="form-control" placeholder="Search Events as Title" name="srch-term-users" id="srch-term">
                                  <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                  </div>
                                </div>
                            </form>
                          </li>

                          <li style="display:inline-block;">
                            <form class="navbar-form navbar-left">
                                <div class="input-group input-group-sm" style="max-width:200px;">
                                  <select class="form-control" name="srch-term-categorys" class="form-control" >
                                    <option value="0">Select Category</option>
                                    <option value="1">Club</option>            
                                  </select>
                                  <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                  </div>
                                </div>
                            </form>
                          </li>

                          <li style="display:inline-block;">
                            <a href="#"><i class="fa fa-bell-o fa-2x" aria-hidden="true"></i></a>
                          </li>

                          <li style="display:inline-block;">
                            <a href="#">SignOut</a>
                          </li>

                          </ul>
                    </div>

                    <!-- /top nav -->

                    <div class="padding">
                        <div class="full col-sm-9">

                          <!-- sidebar -->
                          <div class="column col-sm-2 col-xs-1 sidebar-offcanvas" id="sidebar">
                            
                            <div class="profile-sidebar">
                              <!-- SIDEBAR USERPIC -->
                              <div class="profile-userpic">
                                <img src="http://keenthemes.com/preview/metronic/theme/assets/admin/pages/media/profile/profile_user.jpg" class="img-responsive" alt="">
                              </div>
                              <!-- END SIDEBAR USERPIC -->

                              <!-- SIDEBAR BUTTONS -->
                              <div class="profile-userbuttons">
                                <button type="button" class="btn btn-success btn-sm">User Edit</button>
                                <button type="button" class="btn btn-danger btn-sm">Make Event</button>
                                <br>
                                <br>
                              </div>
                              <!-- END SIDEBAR BUTTONS -->
                              <!-- SIDEBAR MENU -->
                              <div class="profile-usermenu">
                                <ul class="nav">
                                  <li class="active">

                                    <i class="glyphicon glyphicon-home"></i>
                                    NAME:<br>【nick_name】<br>
                                  </li>
                                  <li>

                                    <i class="glyphicon glyphicon-user"></i>
                                    BIRTH:<br>MM/DD/YY【birthday】<br>
                                  </li>
                                  <li>
                                    <i class="glyphicon glyphicon-ok"></i>
                                    SCHOOL:<br>【name】<br>
                                  </li>
                                  <li>
                                    <i class="glyphicon glyphicon-flag"></i>
                                    INTRODUCTION:<br>【introduction】<br>
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
        <script src="js/bootstrap.min.js"></script>
        <script src="js/scripts.js"></script>



</body>
</html>
