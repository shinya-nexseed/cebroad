

<link rel="stylesheet" href="../webroot/assets/css/bootstrap.css">
<link rel="stylesheet" href="../webroot/assets/events/css/events.css">
<?php 
function h($val) {
	return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
}

$place_name = $_SESSION['events']['place_name'];
$lat = $_SESSION['events']['lat'];
$lng = $_SESSION['events']['lng'];

 ?>
 <div class="container">
 	<div class="row">

 		<div class="col-sm-8 col-md-8">
		 	<h2>Make sure all the contents below are correct.</h2>
			<p>Title:<?=h($_SESSION['events']['title'])?></p>
			<p>Starting time:<?=h($_SESSION['events']['starting_time'])?></p>
			<?php if (isset($_SESSION['events']['closing_time'])): ?>
			<p>Closing time:<?=h($_SESSION['events']['closing_time'])?></p>
			<?php endif; ?>
			<p>Place:<?=h($place_name)?></p>
			<p>Detail:<?=h($_SESSION['events']['detail'])?></p>
			<label>Map</label>
			<br>
			<img src="https://maps.googleapis.com/maps/api/staticmap?center=<?=h($lat)?>%2C<?=h($lng)?>&zoom=16&size=800x400&key=AIzaSyDf24saS_c-qe8Qy4QPgVbTub1sJi02ov8&markers=<?=h($lat)?>%2C<?=h($lng)?>">
		</div>

	</div>
</div>