<link rel="stylesheet" href="../webroot/assets/css/bootstrap.css">
<?php 
function h($val) {
	return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
}
$place_name = $_POST['place_name'];
$lat = $_POST['lat'];
$lng = $_POST['lng'];

 ?>
 <h2>Make sure all the contents below are correct.</h2>
 <div class="container">
	 <p>Title:<?php echo h($_POST['title']); ?></p>
	 <p>Date,Time:<?php echo h($_POST['time']); ?></p>
	 <p>Place:<?php echo h($_POST['place_name']); ?></p>
	 <p>Detail:<?php echo h($_POST['detail']); ?></p>
	<label>Map</label>
	<br>
	<img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo h($_POST['lat']); ?>%2C<?php echo h($_POST['lng']); ?>&zoom=16&size=800x400&key=AIzaSyDf24saS_c-qe8Qy4QPgVbTub1sJi02ov8&markers=<?php echo h($_POST['lat']); ?>%2C<?php echo h($_POST['lng']); ?>">
</div>