<?php 
//ログイン判定
    //セッションにidが存在し、かつオンのtimeと3600秒足した値が現在時刻より小さい時に
    //現在時刻より小さい時にログインしていると判定する
    if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()){
        //$_SESSIONに保存している時間更新
        //これがないとログインから１時間たったら再度ログインしないとindex.phpに入れなくなる。
        $_SESSION['time'] = time();
        //event/show.phpへ遷移
        header('Location: events/show.php'); 
        exit(); 
    }else{
        // echo'ログイン判定(ログインしていない場合にサイトトップ表示)';
        // echo'<br>';
    }
 ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Cebroad</title>
        <meta name="description" content="company is a free job board template">
        <meta name="author" content="Ohidul">
        <meta name="keyword" content="html, css, bootstrap, job-board">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800' rel='stylesheet' type='text/css'>

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="icon" href="favicon.ico" type="image/x-icon">

        <link rel="stylesheet" href="webroot/assets/css/normalize.css">
        <link rel="stylesheet" href="webroot/assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="webroot/assets/css/fontello.css">
        <link rel="stylesheet" href="webroot/assets/css/animate.css">        
        <link rel="stylesheet" href="webroot/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="webroot/assets/css/owl.carousel.css">
        <link rel="stylesheet" href="webroot/assets/css/owl.theme.css">
        <link rel="stylesheet" href="webroot/assets/css/owl.transitions.css">
        <link rel="stylesheet" href="webroot/assets/css/style.css">
        <link rel="stylesheet" href="webroot/assets/css/responsive.css">
        <script src="webroot/assets/js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body>
        <div id="preloader">
            <div id="status">&nbsp;</div>
        </div>
        <!-- Body content -->
		
        <!-- <div class="header-connect">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-sm-8 col-xs-8">
                        <div class="header-half header-call">
                            <p>
                                <span><i class="icon-cloud"></i>+019 4854 8817</span>
                                <span><i class="icon-mail"></i>ohidul.islam951@gmail.com</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-2 col-md-offset-5  col-sm-3 col-sm-offset-1  col-xs-3  col-xs-offset-1">
                        <div class="header-half header-social">
                            <ul class="list-inline">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-vine"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 -->
        <!-- <nav class="navbar navbar-default">
          <div class="container"> -->
            <!-- Brand and toggle get grouped for better mobile display -->
            <!-- <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#"><img src="" alt=""></a>
            </div>
         </div>
        </nav> -->

        
        <div class="slider-area">
            <div class="slider">
                <div id="bg-slider" class="owl-carousel owl-theme">
                        <div class="item"><img src="webroot/assets/images/club.jpg" alt="Mirror Edge"></div>
                        <div class="item"><img src="webroot/assets/images/sand.jpg" alt="The Last of us"></div>
                        <div class="item"><img src="" alt="GTA V"></div>
                </div>
            </div>
            <div class="container slider-content">
                <div class="row">
                   <!--  <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12"> -->
                        <h2 class="text-center">Cebu Local SNS</h2>
                        <p>Join the getherings that interest you and meet new friends beyond school!</p>
                        <div class="search-form wow pulse" data-wow-delay="0.8s">
                            <a href="join/signup.php"><button class="navbar-btn nav-button wow bounceInRight login" data-wow-delay="0.8s">Sing up</button></a>
                            <!-- <form action="" class=" form-inline">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Job Key Word">
                                </div>
                                <div class="form-group">
                                    <select name="" id="" class="form-control">
                                        <option>Select Your City</option>
                                        <option selected>New york, CA</option>
                                        <option>New york, CA</option>
                                        <option>New york, CA</option>
                                        <option>New york, CA</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="" id="" class="form-control">
                                        <option>Select Your Category</option>
                                        <option selected>Graphic Design</option>
                                        <option>Web Design</option>
                                        <option>App Design</option>
                                    </select>
                                </div>
                                <input type="submit" class="btn" value="Search">
                            </form> -->
                        </div>
                    <!-- </div> -->
                </div>
            </div>
        </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="navbar-collapse">
            <a href="index.php" id="special2" data-wow-delay="0.8s">Cebroad</a>
        </div>
        <div class="navbar-collapse" id="special">
            <div class="button navbar-right">
                <a href="signin.php"><button class="navbar-btn nav-button wow bounceInRight signup" id="login" data-wow-delay="0.8s">Login</button></a>
                  <!-- <button class="navbar-btn nav-button wow fadeInRight" data-wow-delay="0.6s">Sign up</button> -->
            </div>
             <!--  <ul class="main-nav nav navbar-nav navbar-right">
                <li class="wow fadeInDown" data-wow-delay="0s"><a class="active" href="#">Home</a></li>
                <li class="wow fadeInDown" data-wow-delay="0.1s"><a href="#">Job Seekers</a></li>
                <li class="wow fadeInDown" data-wow-delay="0.2s"><a href="#">Employeers</a></li>
                <li class="wow fadeInDown" data-wow-delay="0.3s"><a href="#">About us</a></li>
                <li class="wow fadeInDown" data-wow-delay="0.4s"><a href="#">Blog</a></li>
                <li class="wow fadeInDown" data-wow-delay="0.5s"><a href="#">Contact</a></li>
              </ul> -->
        </div><!-- /.navbar-collapse -->
          <!-- </div> --><!-- /.container-fluid
        <! </nav> -->

        <div class="content-area">
            <div class="container">
                <div class="row page-title text-center wow zoomInDown" data-wow-delay="1s">
                    <h5>What is this?</h5>
                    <h2>SNS for foreign students in Cebu</h2>
                    <p>If you're feeling like meeting up with new people beyond your network, search getherings that may interests you on Cebroad. Then you get to know new friends who are also studying here.</p>
                </div>
                <div class="row how-it-work text-center">
                    <div class="col-md-6">
                        <div class="single-work wow fadeInUp" data-wow-delay="0.8s">
                            <i class="fa fa-search fa-large" aria-hidden="true"></i>
                            <h3>Search gatherings</h3>
                            <p>You can search gatherings and contact the organizer. Join and meet new people. Don't be bored at your dorm.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="single-work  wow fadeInUp"  data-wow-delay="0.9s">
                            <i class="fa fa-users fa-large" aria-hidden="true"></i>
                            <h3>Create gatherings</h3>
                            <p>You can also create gatherings. It does't need to be formal events but anything including casual dinner, travel, study group etc.</p>
                        </div>
                    </div>
                    <!-- <div class="col-md-4">
                        <div class="single-work wow fadeInUp"  data-wow-delay="1s">
                            <img src="img/how-work3.png" alt="">
                            <h3>Searching for the best job</h3>
                            <p>Using the outcomes from the job, we will put together a plan for the most effective marketing strategy to get the best results.</p>
                        </div>
                    </div> -->
                </div>
            </div>
            <hr>

            <div class="container">
                <div class="row job-posting wow fadeInUp" data-wow-delay="1s">
                    <div role="tabpanel">
                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#job-seekers" aria-controls="home" role="tab" data-toggle="tab">Upcoming gatherings</a></li>
                       <!--  <li role="presentation"><a href="#employeers" aria-controls="profile" role="tab" data-toggle="tab">Employeers</a></li> -->
                      </ul>

                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="job-seekers">
                            <ul class="list-inline job-seeker">
                                <li>
                                    <a href="">
                                        <img src="webroot/assets/images/sand.jpg" alt="">
                                        <div class="overlay"><h3>Ohidul Islam</h3><p>Web Designer</p></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <img src="webroot/assets/images/mali.jpg" alt="">
                                        <div class="overlay"><h3>Mohidul Islam</h3><p>CEO</p></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <img src="webroot/assets/images/cala.jpg" alt="">
                                        <div class="overlay"><h3>Unknown girl</h3><p>Graphic Designer</p></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <img src="webroot/assets/images/friends_ac.jpg" alt="">
                                        <div class="overlay"><h3>Eftakher Alam</h3><p>Graphic Designer</p></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <img src="webroot/assets/images/cala2.jpg" alt="">
                                        <div class="overlay"><h3>Mark Otto</h3><p>Founder</p></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <img src="webroot/assets/images/experience.jpg" alt="">
                                        <div class="overlay"><h3>Rasel Ahmed</h3><p>Web Developer</p></div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- <div role="tabpanel" class="tab-pane fade" id="employeers">
                            <ul class="list-inline">
                                <li>
                                    <a href="">
                                        <img src="img/employee4.png" alt="">
                                        <div class="overlay"><h3>Instagram</h3></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <img src="img/employee5.png" alt="">
                                        <div class="overlay"><h3>Microsoft</h3></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <img src="img/employee6.png" alt="">
                                        <div class="overlay"><h3>Dribbble</h3></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <img src="img/employee1.png" alt="">
                                        <div class="overlay"><h3>Beats Music</h3></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <img src="img/employee2.png" alt="">
                                        <div class="overlay"><h3>Facebook</h3></div>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <img src="img/employee3.png" alt="">
                                        <div class="overlay"><h3>Twitter</h3></div>
                                    </a>
                                </li>
                            </ul>
                        </div> -->
                      </div>

                    </div>
                </div>
            </div>
            <div class="wow pulse" data-wow-delay="0.8s">
                            <a href="event/show.php"><button class="navbar-btn nav-button wow bounceInRight viewmore" data-wow-delay="0.8s">View More</button></a>
            </div>
            <hr>

            <!-- <div class="container">
                <div class="row page-title text-center wow bounce"  data-wow-delay="1s">
                    <h5>Recent Jobs</h5>
                    <h2><span>54716</span> Available jobs for you</h2>
                </div>
                <div class="row jobs">
                    <div class="col-md-9">
                        <div class="job-posts table-responsive">
                            <table class="table">
                                <tr class="odd wow fadeInUp" data-wow-delay="1s">
                                    <td class="tbl-logo"><img src="img/job-logo1.png" alt=""></td>
                                    <td class="tbl-title"><h4>Web Designer <br><span class="job-type">full time</span></h4></td>
                                    <td><p>dribbble community</p></td>
                                    <td><p><i class="icon-location"></i>San Franciso, USA</p></td>
                                    <td><p>&dollar; 14000</p></td>
                                    <td class="tbl-apply"><a href="#">Apply now</a></td>
                                </tr>
                                <tr class="even wow fadeInUp" data-wow-delay="1.1s">
                                    <td class="tbl-logo"><img src="img/job-logo2.png" alt=""></td>
                                    <td class="tbl-title"><h4>Front End Developer <br><span class="job-type">full time</span></h4></td>
                                    <td><p>Jolil corporation</p></td>
                                    <td><p><i class="icon-location"></i>San Franciso, USA</p></td>
                                    <td><p>&dollar; 14000</p></td>
                                    <td class="tbl-apply"><a href="#">Apply now</a></td>
                                </tr>
                                <tr class="odd wow fadeInUp" data-wow-delay="1.2s">
                                    <td class="tbl-logo"><img src="img/job-logo3.png" alt=""></td>
                                    <td class="tbl-title"><h4>HR Manager <br><span class="job-type">full time</span></h4></td>
                                    <td><p>Fanta bevarage</p></td>
                                    <td><p><i class="icon-location"></i>San Franciso, USA</p></td>
                                    <td><p>&dollar; 14000</p></td>
                                    <td class="tbl-apply"><a href="#">Apply now</a></td>
                                </tr>
                                <tr class="even wow fadeInUp" data-wow-delay="1.3s">
                                    <td class="tbl-logo"><img src="img/job-logo4.png" alt=""></td>
                                    <td class="tbl-title"><h4>Internship Designer <br><span class="job-type">full time</span></h4></td>
                                    <td><p>Google</p></td>
                                    <td><p><i class="icon-location"></i>San Franciso, USA</p></td>
                                    <td><p>&dollar; 14000</p></td>
                                    <td class="tbl-apply"><a href="#">Apply now</a></td>
                                </tr>
                                <tr class="odd wow fadeInUp" data-wow-delay="1.4s">
                                    <td class="tbl-logo"><img src="img/job-logo5.png" alt=""></td>
                                    <td class="tbl-title"><h4>Software Designer <br><span class="job-type">full time</span></h4></td>
                                    <td><p>Microsoft</p></td>
                                    <td><p><i class="icon-location"></i>San Franciso, USA</p></td>
                                    <td><p>&dollar; 14000</p></td>
                                    <td class="tbl-apply"><a href="#">Apply now</a></td>
                                </tr>
                                <tr class="even hide-jobs">
                                    <td class="tbl-logo"><img src="img/job-logo4.png" alt=""></td>
                                    <td class="tbl-title"><h4>Internship Designer <br><span class="job-type">full time</span></h4></td>
                                    <td><p>Google</p></td>
                                    <td><p><i class="icon-location"></i>San Franciso, USA</p></td>
                                    <td><p>&dollar; 14000</p></td>
                                    <td class="tbl-apply"><a href="#">Apply now</a></td>
                                </tr>
                                <tr class="odd hide-jobs">
                                    <td class="tbl-logo"><img src="img/job-logo5.png" alt=""></td>
                                    <td class="tbl-title"><h4>Software Designer <br><span class="job-type">full time</span></h4></td>
                                    <td><p>Microsoft</p></td>
                                    <td><p><i class="icon-location"></i>San Franciso, USA</p></td>
                                    <td><p>&dollar; 14000</p></td>
                                    <td class="tbl-apply"><a href="#">Apply now</a></td>
                                </tr>
                                <tr class="even hide-jobs">
                                    <td class="tbl-logo"><img src="img/job-logo4.png" alt=""></td>
                                    <td class="tbl-title"><h4>Internship Designer <br><span class="job-type">full time</span></h4></td>
                                    <td><p>Google</p></td>
                                    <td><p><i class="icon-location"></i>San Franciso, USA</p></td>
                                    <td><p>&dollar; 14000</p></td>
                                    <td class="tbl-apply"><a href="#">Apply now</a></td>
                                </tr>
                                <tr class="odd hide-jobs">
                                    <td class="tbl-logo"><img src="img/job-logo5.png" alt=""></td>
                                    <td class="tbl-title"><h4>Software Designer <br><span class="job-type">full time</span></h4></td>
                                    <td><p>Microsoft</p></td>
                                    <td><p><i class="icon-location"></i>San Franciso, USA</p></td>
                                    <td><p>&dollar; 14000</p></td>
                                    <td class="tbl-apply"><a href="#">Apply now</a></td>
                                </tr>
                            </table>
                        </div>
                        <div class="more-jobs">
                            <a href=""> <i class="fa fa-refresh"></i>View more jobs</a>
                        </div>
                    </div>
                    <div class="col-md-3 hidden-sm">
                        <div class="job-add wow fadeInRight" data-wow-delay="1.5s">
                            <h2>Seeking a job?</h2>
                            <a href="#">Create a Account</a>
                        </div>
                    </div>
                </div>
            </div>
            <hr> -->
<!-- 
            <div class="container">
                <div class="row page-title text-center  wow bounce"  data-wow-delay=".7s">
                    <h5>TESTIMONIALS</h5>
                    <h2>WHAT PEOPLES ARE SAYING</h2>
                </div>
                <div class="row testimonial">
                    <div class="col-md-12">
                        <div id="testimonial-slider">
                            <div class="item">
                                <div class="client-text">                                
                                    <p>Jobify offer an amazing service and I couldn’t be happier! They 
                                    are dedicated to helping recruiters find great candidates, wonderful service!</p>
                                    <h4><strong>Ohidul Islam, </strong><i>Web Designer</i></h4>
                                </div>
                                <div class="client-face wow fadeInRight" data-wow-delay=".9s"> 
                                    <img src="img/client-face1.png" alt="">
                                </div>
                            </div>
                            <div class="item">
                                <div class="client-text">                                
                                    <p>Jobify offer an amazing service and I couldn’t be happier! They 
                                    are dedicated to helping recruiters find great candidates, wonderful service!</p>
                                    <h4><strong>Ohidul Islam, </strong><i>Web Designer</i></h4>
                                </div>
                                <div class="client-face">
                                    <img src="img/client-face2.png" alt="">
                                </div>
                            </div>
                            <div class="item">
                                <div class="client-text">                                
                                    <p>Jobify offer an amazing service and I couldn’t be happier! They 
                                    are dedicated to helping recruiters find great candidates, wonderful service!</p>
                                    <h4><strong>Ohidul Islam, </strong><i>Web Designer</i></h4>
                                </div>
                                <div class="client-face">
                                    <img src="img/client-face1.png" alt="">
                                </div>
                            </div>
                            <div class="item">
                                <div class="client-text">                                
                                    <p>Jobify offer an amazing service and I couldn’t be happier! They 
                                    are dedicated to helping recruiters find great candidates, wonderful service!</p>
                                    <h4><strong>Ohidul Islam, </strong><i>Web Designer</i></h4>
                                </div>
                                <div class="client-face">
                                    <img src="img/client-face2.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

        </div>
        <div class="footer-area">
            <div class="container">
                <div class="row footer">
                <!--     <div class="col-md-4">
                        <div class="single-footer">
                            <img src="img/footer-logo.png" alt="" class="wow pulse" data-wow-delay="1s">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati architecto quaerat facere blanditiis tempora sequi nulla accusamus, possimus cum necessitatibus suscipit quia autem mollitia, similique quisquam molestias. Vel unde, blanditiis.</p>
                        </div>
                    </div> -->
                    <!-- <div class="col-md-6">
                        <div class="single-footer">
                            <h4>Twitter update</h4>
                            <div class="twitter-updates">
                                <div class="single-tweets">
                                    <h5>ABOUT 9 HOURS</h5>
                                    <p><strong>AGOMeet Aldous</strong> - a Brave New World for #rails with more cohesion, less coupling and greater dev speed <a href="http://t.co/rsekglotzs">http://t.co/rsekglotzs</a></p>
                                </div>
                                <div class="single-tweets">
                                    <h5>ABOUT 9 HOURS</h5>
                                    <p><strong>AGOMeet Aldous</strong> - a Brave New World for #rails with more cohesion, less coupling and greater dev speed <a href="http://t.co/rsekglotzs">http://t.co/rsekglotzs</a></p>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-md-6">
                        <div class="single-footer">
                            <h4>Useful lnks</h4>
                            <div class="footer-links">
                                <ul class="list-unstyled">
                                    <!-- <li><a href="">About Us</a></li>
                                    <li><a href="" class="active">Services</a></li>
                                    <li><a href="">Work</a></li>
                                    <li><a href="">Our Blog</a></li> -->
                                    <li><a href="aboutus.php">About us</a></li>
                                    <li><a href="">Terms and Conditions</a></li>
                                    <li><a href="">Privacy policy</a></li>
                                    <li><a href="">Contact us</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row footer-copy">
                    <p><span>(C) All rights reserved</span> | <span><a href="aboutus.php">Team0404</a></span> <!-- | <span> Web Designed by <a href="http://ohidul.me">Ohidul Islam</a></span> </p> -->
                </div>
            </div>
        </div>
		
		
		
		
		
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="webroot/assets/js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
        <script src="webroot/assets/js/bootstrap.js"></script>
        <script src="webroot/assets/js/owl.carousel.min.js"></script>
        <script src="webroot/assets/js/wow.js"></script>
        <script src="webroot/assets/js/main.js"></script>
    </body>
</html>
