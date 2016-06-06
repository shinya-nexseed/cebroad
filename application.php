<?php
  session_start();
  // require('dbconnect.php');
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
    <link rel="stylesheet" href="webroot/assets/font-awesome/css/font-awesome.css">
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="css/styles.css" rel="stylesheet">

  <script>
    $(document).ready(function(){
        //Handles menu drop down
        $('.dropdown-menu').find('form').click(function (e) {
            e.stopPropagation();
        });
    });
  </script>



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
                          <li style="display:inline-block" class="navbar-form navbar-left">
                            <form>
                                <div class="input-group input-group-sm" style="max-width:300px;">
                                  <input type="text" class="form-control" placeholder="Search Events as Title" name="srch-term-users" id="srch-term">
                                  <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                  </div>
                                </div>
                            </form>
                          </li>



                          <li style="display:inline-block;" class="navbar-form navbar-left">
                            <form>
                                <div class="input-group input-group-sm" style="max-width:200px;">
                                  <select class="form-control" name="srch-term-categorys" class="form-control" >
                                    <option value="0">Select Category</option>
                                    <option value="1">Club</option>            
                                  </select>
                                  <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                  </div>
                                </div>
                            </form>
                          </li>

                          <li style="display:inline-block" class="navbar-form navbar-right">
                            <a href="#"><span class="badge">SignOut</span></a>
                          </li>

                          <li style="display:inline-block;" class="navbar-form navbar-right">
                            <a href="#"><span class="badge"><i class="fa fa-bell-o fa-2x" aria-hidden="true"></i></span></a>
                          </li>

                          <li style="display:inline-block;" class="navbar-form navbar-right">
                            <a href="#"><img src="images/01.jpg" class="img-responsive" style="height:100%; width:30px;" alt=""></a>
                          </li>



                              <li class="dropdown navbar-right">
                                 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sign in <b class="caret"></b></a>
                                 <ul class="dropdown-menu" style="padding: 15px;min-width: 250px;">
                                    <li>
                                       <div class="row">
                                          <div class="col-md-12">
                                             <form class="form" role="form" method="post" action="login" accept-charset="UTF-8" id="login-nav">
                                                <div class="form-group">
                                                   <label class="sr-only" for="exampleInputEmail2">Email address</label>
                                                   <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Email address" required>
                                                </div>
                                                <div class="form-group">
                                                   <label class="sr-only" for="exampleInputPassword2">Password</label>
                                                   <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" required>
                                                </div>
                                                <div class="checkbox">
                                                   <label>
                                                   <input type="checkbox"> Remember me
                                                   </label>
                                                </div>
                                                <div class="form-group">
                                                   <button type="submit" class="btn btn-success btn-block">Sign in</button>
                                                </div>
                                             </form>
                                          </div>
                                       </div>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                       <input class="btn btn-primary btn-block" type="button" id="sign-in-google" value="Sign In with Google">
                                       <input class="btn btn-primary btn-block" type="button" id="sign-in-twitter" value="Sign In with Twitter">
                                    </li>
                                 </ul>
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
                                <img src="images/01.jpg" class="img-responsive" style="width:130px; height:100%;" alt=""><br>
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
                              // require($resource.'/'.$action.'.php');
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
