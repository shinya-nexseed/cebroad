<?php
 if (!isset($_SESSION['id']) || empty($_SESSION['events'])) {
 	echo '<script> location.replace("/portfolio/cebroad/events/index"); </script>';
 	exit();
 }

 $a = array();
 $a = $_SESSION['events'];

 if (isset($_POST['submit'])) {
 	for ($i=0; $i<4; $i++) {
 	 	if ($a['pic'.$i]['error'] === 0) {
 	$name = dirname(__FILE__).'/events_pictures/'.sha1(mt_rand() . microtime()).'.jpg';
 	if (file_put_contents($name, $a['pic'.$i]['content'], LOCK_EX)) {
 		${"path".$i} = mb_substr($name, strpos($name, 'portfolio')-1);
 		$a["pic".$i."_path"] = ${"path".$i};
 	} else {
 		die("Failed to upload pictures. I'm afraid please retry.");
 	}
 		
 	} else if ($a['pic'.$i]['error'] === 4) {
 		if ($i === 0) {
 		$a['pic0_path'] = '/portfolio/cebroad/webroot/assets/events/img/default.jpg';
 		} else {
 		 $a["pic".$i."_path"] = '';
 		} 
 	}
 }

 	if(!isset($a['closing_time'])) {
 		$a['closing_time'] = '';
 	}

  	if(!isset($a['capacity'])) {
 		$a['capacity'] = '';
 	}
$sql = sprintf("INSERT INTO events SET title='%s', detail='%s', date='%s', starting_time='%s', closing_time='%s', place_name='%s', latitude='%s', longitude='%s', picture_path_0='%s', picture_path_1='%s', picture_path_2='%s', picture_path_3='%s', capacity_num=%d, organizer_id=%d, event_category_id=%d, created=now()",
	mysqli_real_escape_string($db, $a['title']),
	mysqli_real_escape_string($db, $a['detail']),
	mysqli_real_escape_string($db, $a['date']),
	mysqli_real_escape_string($db, $a['starting_time']),
	mysqli_real_escape_string($db, $a['closing_time']),
	mysqli_real_escape_string($db, $a['place_name']),
	mysqli_real_escape_string($db, $a['latitude']),
	mysqli_real_escape_string($db, $a['longitude']),
	mysqli_real_escape_string($db, $a['pic0_path']),
	mysqli_real_escape_string($db, $a['pic1_path']),
	mysqli_real_escape_string($db, $a['pic2_path']),
	mysqli_real_escape_string($db, $a['pic3_path']),
	mysqli_real_escape_string($db, $a['capacity']),
	mysqli_real_escape_string($db, $_SESSION['id']),
	mysqli_real_escape_string($db, $a['category'])
	);
	mysqli_query($db, $sql) or die('<h1>Sorry, something wrong happened. Please retry.</h1>');

	unset($_SESSION['events']);

	$sql = sprintf("SELECT id FROM events WHERE organizer_id=%d ORDER BY created DESC",
	mysqli_real_escape_string($db, $_SESSION['id']));
	$rtn = mysqli_query($db, $sql) or die('<h1>Sorry, something wrong happened. Please retry.</h1>');
	$new_event = mysqli_fetch_assoc($rtn);

	echo '<script> location.replace("/portfolio/cebroad/events/show/'.$new_event['id'].'"); </script>';
	// header('Location: /portfolio/cebroad/events/show/'.$new_event['id']);
	exit();
}


$place_name = $a['place_name'];
$lat = $a['latitude'];
$lng = $a['longitude'];
$closing_time = '';
$capacity =  '';
$categoty = '';
$pic0 = '';
$pic1 = '';
$pic2 = '';
$pic3 = '';

$sql = "SELECT * FROM event_categories";
$rtn = mysqli_query($db, $sql) or die('<h1>Sorry, something wrong happened. Please retry.</h1>');

while ($cat = mysqli_fetch_assoc($rtn)) {
	if ($cat['id'] === $a['category']) {
		$category = 'Category:'.$cat['name'];
	}
}

if (!empty($a['closing_time'])) {
	$closing_time = 'Closing time:'.$a['closing_time'];
  }
if (!empty($a['capacity'])) {
	$capacity = 'Capacity:'.$a['capacity'];
}

for ($i=0; $i<4; $i++){
if ($a['pic'.$i]['error'] === 0) {
	$base64 = base64_encode($a['pic'.$i]['content']);
	$a['pic'.$i]['file'] = $base64;
	${"pic".$i} = "<img class='img-responsive events-pad' src=\"data:image/jpeg;base64,${base64}\">";
	}
}

?>
 <div class="container">
 	<div class="row">

 		<div class="col-sm-8 col-md-8 col-lg-8">
		 	<h2>Make sure all the contents below are correct.</h2>
			<h4>Title:<?=h($a['title'])?></h4>
			<h4>Date:<?=h($a['date'])?></h4>
			<h4><?=$category?></h4>
			<h4>Starting time:<?=h($a['starting_time'])?></h4>
			<h4><?=h($closing_time)?></h4>
			<h4>Place:<?=h($place_name)?></h4>
			<h4><?=h($capacity)?></h4>
			<h4>Detail:<?=h($a['detail'])?></h4>
			<h4>Map</h4>
			<img class="img-responsive events-pad" src="https://maps.googleapis.com/maps/api/staticmap?center=<?=h($lat)?>%2C<?=h($lng)?>&zoom=16&size=1000x600&key=AIzaSyDf24saS_c-qe8Qy4QPgVbTub1sJi02ov8&markers=<?=h($lat)?>%2C<?=h($lng)?>">
			<?php if ($pic0 !== ''): ?>
				<h4>Thumnail picture</h4>
			<?php endif; ?>

			<?=$pic0?>

			<?php if ($pic1 !== ''): ?>
				<h4>Picture1</h4>
			<?php endif; ?>
			
			<?=$pic1?>

			<?php if ($pic1 !== ''): ?>
				<h4>Picture2</h4>
			<?php endif; ?>

			<?=$pic2?>

			<?php if ($pic1 !== ''): ?>
				<h4>Picture3</h4>
			<?php endif; ?>

			<?=$pic3?>
		</div>
		<form method="post">
			<div class="col-sm-8 col-md-8 col-lg-8 events-pad">
				<a href="/portfolio/cebroad/events/add/rewrite">Rewrite</a>
					<button class="btn btn-cebroad" onclick="location.href=''" name="submit" type="submit">Submit</button>
			</div>
		</form>

	</div>
</div>