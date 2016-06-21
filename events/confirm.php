<?php 

 if (!isset($_SESSION['id']))
 if (empty($_SESSION['events'])) {
 	header('Location: /cebroad/events/index');
 }
 if (isset($_POST['submit'])) {
 	$a = array();
 	$a = $_SESSION['events'];


 	if ($a['pic1']['error'] === 0) {
 	$name1 = dirname(__FILE__).'/events_pictures/'.sha1(mt_rand() . microtime()).'.'.$a['pic1']['ext'];
 	$decoded1 = $a['pic1']['content'];
 	file_put_contents($name1, $decoded1, LOCK_EX);
 	$path1 = mb_substr($name1, strpos($name1, 'cebroad')-1);
 	$a['pic1_path'] = $path1;
 		
 	} else if ($a['pic1']['error'] === 4) {
 		$a['pic1_path'] = '/cebroad/webroot/assets/events/img/default.jpg';
 	}

 	if ($a['pic2']['error'] === 0) {
 	$name2 = dirname(__FILE__).'/events_pictures/'.sha1(mt_rand() . microtime()).'.'.$a['pic2']['ext'];
 	$decoded2 = $a['pic2']['content'];
 	file_put_contents($name2, $decoded2, LOCK_EX);
 	$path2 = mb_substr($name2, strpos($name2, 'cebroad')-1);
 	$a['pic2_path'] = $path2;
 		
 	} else if ($a['pic2']['error'] === 4) {
 		$a['pic2_path'] = '';
 	}

 	if ($a['pic3']['error'] === 0) {
 	$name3 = dirname(__FILE__).'/events_pictures/'.sha1(mt_rand() . microtime()).'.'.$a['pic3']['ext'];
 	$decoded3 = $a['pic3']['content'];
 	file_put_contents($name3, $decoded3, LOCK_EX);
 	$path3 = mb_substr($name3, strpos($name3, 'cebroad')-1);
 	$a['pic3_path'] = $path3;
 		
 	} else if ($a['pic3']['error'] === 4) {
 		$a['pic3_path'] = '';
 	}

 	if(!isset($a['closing_time'])) {
 		$a['closing_time'] = '';
 	}

  	if(!isset($a['capacity'])) {
 		$a['capacity'] = '';
 	}
$sql = sprintf("INSERT INTO events SET title='%s', detail='%s', date='%s', starting_time='%s', closing_time='%s', place_name='%s', latitude='%s', longitude='%s', picture_path_1='%s', picture_path_2='%s', picture_path_3='%s', capacity_num=%d, organizer_id=%d, event_category_id=1, created=now()",
	mysqli_real_escape_string($db, $a['title']),
	mysqli_real_escape_string($db, $a['detail']),
	mysqli_real_escape_string($db, $a['date']),
	mysqli_real_escape_string($db, $a['starting_time']),
	mysqli_real_escape_string($db, $a['closing_time']),
	mysqli_real_escape_string($db, $a['place_name']),
	mysqli_real_escape_string($db, $a['latitude']),
	mysqli_real_escape_string($db, $a['longitude']),
	mysqli_real_escape_string($db, $a['pic1_path']),
	mysqli_real_escape_string($db, $a['pic2_path']),
	mysqli_real_escape_string($db, $a['pic3_path']),
	mysqli_real_escape_string($db, $a['capacity']),
	mysqli_real_escape_string($db, $_SESSION['id'])
	);
	mysqli_query($db, $sql) or die('Sorry, something wrong happened. Please try again.');
	unset($_SESSION['events']);

	//本来は自分の作ったイベント一覧のページに飛ばすが、一時的にindexにしている
	header('Location:/cebroad/events/index');
	exit();

// 	//exit();
}

$place_name = $_SESSION['events']['place_name'];
$lat = $_SESSION['events']['latitude'];
$lng = $_SESSION['events']['longitude'];
$closing_time = '';
$capacity =  '';
$pic1 = '';
$pic2 = '';
$pic3 = '';
if (!empty($_SESSION['events']['closing_time'])) {
	$closing_time = 'Closing time:'.$_SESSION['events']['closing_time'];
  }
if (!empty($_SESSION['events']['capacity'])) {
	$capacity = 'Capacity:'.$_SESSION['events']['capacity'];
}

if ($_SESSION['events']['pic1']['error'] === 0) {
	$base64_1 = base64_encode($_SESSION['events']['pic1']['content']);
	$_SESSION['events']['pic1']['file'] = $base64_1;
	$pic1 = "<img class='img-responsive events-pad' src=\"data:image/jpeg;base64,${base64_1}\">";
}
if ($_SESSION['events']['pic2']['error'] === 0) {
	$tmp_name2 = $_SESSION['events']['pic2']['tmp_name'];
	$base64_2 = base64_encode($_SESSION['events']['pic2']['content']);
	$_SESSION['events']['pic2']['file'] = $base64_2;
	$pic2 = "<img class='img-responsive events-pad' src=\"data:image/jpeg;base64,${base64_2}\">";
}
if ($_SESSION['events']['pic3']['error'] === 0) {
	$tmp_name3 = $_SESSION['events']['pic3']['tmp_name'];
	$base64_3 = base64_encode($_SESSION['events']['pic3']['content']);
	$_SESSION['events']['pic3']['file'] = $base64_3;
	$pic3 = "<img class='img-responsive events-pad' src=\"data:image/jpeg;base64,${base64_3}\">";
}

?>
 <div class="container">
 	<div class="row">

 		<div class="col-sm-8 col-md-8 col-lg-8">
		 	<h2>Make sure all the contents below are correct.</h2>
			<p>Title:<?=h($_SESSION['events']['title'])?></p>
			<p>Date:<?=h($_SESSION['events']['date'])?></p>
			<p>Starting time:<?=h($_SESSION['events']['starting_time'])?></p>
			<p><?=h($closing_time)?></p>
			<p>Place:<?=h($place_name)?></p>
			<p><?=h($capacity)?></p>
			<p>Detail:<?=h($_SESSION['events']['detail'])?></p>
			<label>Map</label>
			<br>
			<img class="img-responsive events-pad" src="https://maps.googleapis.com/maps/api/staticmap?center=<?=h($lat)?>%2C<?=h($lng)?>&zoom=16&size=1000x600&key=AIzaSyDf24saS_c-qe8Qy4QPgVbTub1sJi02ov8&markers=<?=h($lat)?>%2C<?=h($lng)?>">
			<label>Picture1</label>
			<?=$pic1?>
			<label>Picture2</label>
			<?=$pic2?>
			<label>Picture3</label>
			<?=$pic3?>
		</div>
		<form method="post">
			<div class="col-sm-8 col-md-8 col-lg-8 events-pad">
				<a href="/cebroad/events/add/rewrite">Rewrite</a>
					<button class="btn btn-cebroad" onclick="location.href=''" name="submit" type="submit">Submit</button>
			</div>
		</form>

	</div>
</div>