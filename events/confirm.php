

<link rel="stylesheet" href="../webroot/assets/css/bootstrap.css">
<?php 
function h($val) {
	return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
}
$place_name = $_SESSION['events']['place_name'];
$lat = $_SESSION['events']['lat'];
$lng = $_SESSION['events']['lng'];

 ?>
 <h2>Make sure all the contents below are correct.</h2>
 <div class="container">
	 <p>Title:<?php=h($['title'])?></p>
	 <p>Starting time:<?php=h($_POST['starting_time'])?></p>
	 <?php if (isset($_POST['closing_time'])): ?>
	 <h5>Closing time:<?php=h($_POST[''])?></h5>
	 <p>Place:<?php=h($_POST['place_name'])?></p>
	 <p>Detail:<?php=h($_POST['detail'])?></p>
	<label>Map</label>
	<br>
	<img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php=h($_POST['lat'])?>%2C<?php=h($_POST['lng'])?>&zoom=16&size=800x400&key=AIzaSyDf24saS_c-qe8Qy4QPgVbTub1sJi02ov8&markers=<?php=h($_POST['lat'])?>%2C<?php=h($_POST['lng'])?>">
</div>