<?php 
//ログイン判定
	//セッションにidが存在し、かつオンのtimeと3600秒足した値が現在時刻より小さい時に
	//現在時刻より小さい時にログインしていると判定する
	if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()){
	//$_SESSIONに保存している時間更新
	//これがないとログインから１時間たったら再度ログインしないとindex.phpに入れなくなる。
	$_SESSION['time'] = time();
	//event/show.phpへ遷移
	header('Location: event/show.php'); 
    exit(); 
    }else{
    	echo'ログイン判定(ログインしていない)';
    	echo'<br>';
    }
 ?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
	<meta charset="UTF-8">
    <title>Cebroad</title>
		<link href="webroot/assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="webroot/assets/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
		<link href="webroot/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
		<link href="webroot/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="webroot/assets/js/bootstrap.min.js"></script>
		<script src="webroot/assets/js/jquery.min.js"></script>
	<!-- Custom files -->
		<link href="webroot/assets/css/sitetop_style.css" rel='stylesheet' type='text/css' />
   	<!-- Custom Theme files -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		</script>
	<!----//webfonts---->
		<link href='http://fonts.googleapis.com/css?family=Rokkitt:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>
	<!----//webfonts---->
		<script type="text/javascript">
				$(function() {
				  $('a[href*=#]:not([href=#])').click(function() {
				    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			
				      var target = $(this.hash);
				      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
				      if (target.length) {
				        $('html,body').animate({
				          scrollTop: target.offset().top
				        }, 1000);
				        return false;
				      }
				    }
				  });
				});
		</script>
</head>

<body>
  index.php通過
    <div id="top" class="navbar navbar-inverse" role="navigation">
    <div class="overlay">
		<div class="container">
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		       <a class="nav-icon" href="#"> <img src="webroot/assets/images/nav-icon.png " /> </a>
				<span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="index.php">Cebroad</a>
		    </div>
		    <div class="collapse navbar-collapse navbar-right">
		      <ul class="nav navbar-nav">
		        <!-- <li class="active"> -->
		        <li><a href="aboutus.php">About us</a></li>
		        <li><a href="join/signup.php">Sign up</a></li>
		        <li><a href="signin.php">Login</a></li>
		        <!-- <li><a href="#portfolio">Portfolio</a></li>
		        <li><a href="#contact">Contact</a></li> -->
		      </ul>
		    </div><!--/.nav-collapse -->
		    <!--start-slider-->
		     <!--slider-requried-files
		    slider-requried-files
		    start-image-slider-->
			<div class="slideshow">
			    <div>
			     <h1>Cebu local SNS</h1>
			     <span class="border"> </span>
			     <p>Join the getherings that interest you and meet new friends beyond school</p>
			    </div>
			    <!-- <div>
			     <h1>Get together beyond school</h1>
			     <span class="border"> </span>
			     <p>join and make your Cebu life more fun</p>
			    </div> -->
			</div>
			<div class="hero__content-footer">
			<div class="go_btn">
			    <a class="button" href="join/signup.php">Sign up</a>
			</div>
			</div>
			<!-- -start-slider-script- -->
			<!--<script>
				// $(function() {
				// 	$(".slideshow > div:gt(0)").hide();
				// 	setInterval(function() { 
				// 	  $('.slideshow > div:first')
				// 	    .fadeOut(1000)
				// 	    .next()
				// 	    .fadeIn(1000)
				// 	    .end()
				// 	    .appendTo('.slideshow');
				// 	},  3000);
					
				// });
			</script>-->
			<!---//End-slider-script-->
		    <!--//End-slider-->
			<script src="js/jquery.min.js"></script>
			<script src="js/bootstrap.min.js"></script>
		</div>
	</div>
	</div>
    <!----//End-container---->
  	<!----//-container---->
<div  class="about me" id="about">  
		<div class="container">
			<div class="row content-top">
				<div class="col-md-12  text-center">
 					<h2>SNS for foreign students in Cebu</h2>
 					 <p>If you're feeling like meeting up with new people beyond your network, search getherings that may interests you on Cebroad. Then you get to know new friends who are also studying here.</p>
 				</div>	
			</div>
		</div>
	</div>
		<!----//-container---->
<div  class="work" id="work">
		<div class="container">
			<div class="row">
				<div class="col-md-6 text-center">
					<div class="grid ">
						<!-- <img src="webroot/assets/images/icon1.png" alt=""/> -->
						<i class="fa fa-search fa-large" aria-hidden="true"></i>
						<h3>Search gatherings</h3>
						<p>You can search gatherings and contact the organizer. Join and meet new people. Don't be bored at your dorm.</p>
					</div>
				</div>
					<div class="col-md-6 text-center">
						<div class="grid ">
							<!-- <img src="webroot/assets/images/icon2.png" alt=""/> -->
							<i class="fa fa-users fa-large" aria-hidden="true"></i>
							<h3>Create gatherings</h3>
							<p>You can also create gatherings. It does't need to be formal events but anything including casual dinner, travel, study group etc. Have fun and meet new friends.</p>
						</div>
					</div>
					<!-- <div class="col-md-4 text-center">
						<div class="grid "> -->
							<!-- <img src="webroot/assets/images/icon3.png" alt=""/> -->
							<!-- <i class="fa fa-building" aria-hidden="true"></i>
							<h3>Finalize</h3>
							<p>Lorem ipsum dolor sit amet, lobortis scelerisque magna. Ut in nunc sem. Integer bibendum enim et erat molestie. Nullam sem diam. Duis adipiscing commodo ipsum dapibus elementum.</p>
							</div> -->
				<!-- 	</div> -->
					<div class="clearfix"></div>
			</div>
		</div>	
	</div>
<div  class="about me" id="about">  
		<div class="container">
			<div class="row content-top">
				<div class="col-md-12  text-center">
 					<h2>Upcomming gatherings</h2>
			</div>
		</div>
	</div>





		<link rel="stylesheet" type="text/css" href="webroot/assets/css/sitetop_component.css" />
		<script src="webroot/assets/js/modernizr.custom.js"></script>
	<div  class="portfolio" id="portfolio">
		<div class="container demo-3">
				<ul class="col-md-12 grid cs-style-3">
						<li class="col-md-6">
							<figure>
								<img class="responsive-img img1" src="webroot/assets/images/cala.jpg" alt="img03">
								<figcaption>
									<h4>Lorem ipsum dolor sit </h4>
									<span>amet conseteter sadipscing elitr</span>
								</figcaption>
							</figure>
							<a data-toggle="modal" data-target=".bs-example-modal-md" href="#"><!-- <label class="search-icon"> </label> --></a>
						</li>
						<li class="col-md-6">
							<figure>
								<img class="responsive-img img1" src="webroot/assets/images/cala.jpg	" alt="img01">
								<figcaption>
									<h4>Lorem ipsum dolor sit </h4>
									<span>amet conseteter sadipscing elitr</span>
								</figcaption>
							</figure>
							<a data-toggle="modal" data-target=".bs-example-modal-md" href="#"><!-- <label class="search-icon"> </label> --></a>
						</li>
						<li class="col-md-6">
							<figure>
								<img class="responsive-img img1" src="webroot/assets/images/cala2.jpg" alt="img02">
								<figcaption>
									<h4>Lorem ipsum dolor sit </h4>
									<span>amet conseteter sadipscing elitr</span>
								</figcaption>
							</figure>
							<a data-toggle="modal" data-target=".bs-example-modal-md" href="#"><!-- <label class="search-icon"> </label> --></a>
						</li> 
						<li class="col-md-6">
							<figure>
								<img class="responsive-img img1" src="webroot/assets/images/cala2.jpg" alt="img04">
								<figcaption>
									<h4>Calamansi Night </h4>
									<span>vol 2.0</span>
								</figcaption>
							</figure>
							<a data-toggle="modal" data-target=".bs-example-modal-md" href="#"><!-- <label class="search-icon"> </label> --></a>
						</li>
						<li>
					</ul>
					<div class="view">
						<a class="view-btn" href="#">View More</a>
					</div>
				</div>
		</div>
		<!-- /container -->
		<script src="webroot/assets/js/toucheffects.js"></script>
<!----//End-container---->
<!----start-model-box---->
						<div class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
						  <div class="modal-dialog modal-lg">
						    <div class="modal-content light-box-info">
						    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="webroot/assets/images/close.png" alt="" /></button>
						     <h3>Place Yours content here</h3>
						    <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut adipiscing, sapien a ullamcorper pharetra, sem lectus faucibus ante, ac aliquam sem nisl ac lorem. Integer posuere neque sem, non egestas quam scelerisque in. Maecenas ut vestibulum justo. Suspendisse id tortor eu lorem pharetra suscipit pellentesque in sem. Fusce et urna posuere, elementum augue sed, euismod risus. Pellentesque pulvinar quam felis, rutrum blandit magna malesuada non. Aenean sapien felis, vulputate gravida elementum quis, dignissim ut libero. Quisque eget euismod augue. Aliquam nunc odio, ultricies quis tristique sit amet, mattis non justo. Nunc pharetra ut eros at ultricies.</p>
						    </div>
						  </div>
						</div>
						<!----start-model-box---->
<!----start-contact---->
<!--  <div  class="contact" id="contact">
		<div class="container contact">
				<h5>Get in touch!</h5>
					<div class="row contact-form">
				  			<form>
				  				<div class="col-md-6 text-box">
									<input type="text" placeholder="Name" />
								</div>
								<div class="col-md-6 text-box ">
									<input type="text" placeholder="Email" />
								</div>
								<div class="col-md-12 textarea">
										<textarea>How can I help you?</textarea>
								</div>
								<input class="con-button " type="submit" value="Send" />
							</form>
						</div>
				</div>
			</div> -->
		<!----//End-contact---->
		<div class="footer">
			<div class="container">
			<!-- 	<div class="row social-icons">
					<div class="col-xs-4 text-center">
						<a href="#"><img class="responsive-img" src="webroot/assets/images/footr-twb.png" alt=""/></a>
					</div>
					<div class="col-xs-4 text-center">
						<a href="#"><img class="responsive-img" src="webroot/assets/images/footr-dbl.png" alt=""/> </a>
						
					</div>
					<div class="col-xs-4 text-center">
						<a href="#"><img class="responsive-img" src="webroot/assets/images/footr-fb.png" alt=""/> </a>
					</div>
				</div> -->
				<div class="row copy-right">
					<div class="col-md-12 text-center">
						<p>Copyright &#169; 2014 All Rights Reserved | Team 0404<!-- Template by &nbsp;<a href="http://w3layouts.com">W3Layouts --></a></p>
					</div>
				</div>
			</div>
		</div>
					<a href="#top" id="toTop" style="display: block;"><span id="toTopHover" style="opacity: 1;"> </span></a>
</body>
</html>
