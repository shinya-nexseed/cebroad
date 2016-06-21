<?php
 if (!isset($_SESSION['id']))
 if (empty($_SESSION['events'])) {
 	header('Location: /cebroad/events/index');
 }

 $a = array();
 $a = $_SESSION['events'];
 if (isset($_POST['submit'])) {

 	 	if ($a['pic0']['error'] === 0) {
 	$name0 = dirname(__FILE__).'/events_pictures/'.sha1(mt_rand() . microtime()).'.jpg';
 	$decoded0 = $a['pic0']['content'];
 	file_put_contents($name0, $decoded0, LOCK_EX);
 	$path0 = mb_substr($name0, strpos($name0, 'cebroad')-1);
 	$a['pic0_path'] = $path0;
 		
 	} else if ($a['pic0']['error'] === 4) {
 		$a['pic0_path'] = '/cebroad/webroot/assets/events/img/default.jpg';
 	}

 	if ($a['pic1']['error'] === 0) {
 	$name1 = dirname(__FILE__).'/events_pictures/'.sha1(mt_rand() . microtime()).'.jpg';
 	$decoded1 = $a['pic1']['content'];
 	file_put_contents($name1, $decoded1, LOCK_EX);
 	$path1 = mb_substr($name1, strpos($name1, 'cebroad')-1);
 	$a['pic1_path'] = $path1;
 		
 	} else if ($a['pic1']['error'] === 4) {
 		$a['pic1_path'] = '';
 	}

 	if ($a['pic2']['error'] === 0) {
 	$name2 = dirname(__FILE__).'/events_pictures/'.sha1(mt_rand() . microtime()).'.jpg';
 	$decoded2 = $a['pic2']['content'];
 	file_put_contents($name2, $decoded2, LOCK_EX);
 	$path2 = mb_substr($name2, strpos($name2, 'cebroad')-1);
 	$a['pic2_path'] = $path2;
 		
 	} else if ($a['pic2']['error'] === 4) {
 		$a['pic2_path'] = '';
 	}

 	if ($a['pic3']['error'] === 0) {
 	$name3 = dirname(__FILE__).'/events_pictures/'.sha1(mt_rand() . microtime()).'.jpg';
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
$sql = sprintf("INSERT INTO events SET title='%s', detail='%s', date='%s', starting_time='%s', closing_time='%s', place_name='%s', latitude='%s', longitude='%s', thumbnail_path='%s', picture_path_1='%s', picture_path_2='%s', picture_path_3='%s', capacity_num=%d, organizer_id=%d, event_category_id=%d, created=now()",
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
	mysqli_query($db, $sql) or die('Sorry, something wrong happened. Please try again.');

	unset($_SESSION['events']);

	//本来は自分の作ったイベント一覧のページに飛ばすが、一時的にindexにしている
	header('Location:/cebroad/events/index');
	exit();

// 	//exit();
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
$rtn = mysqli_query($db, $sql) or die('Sorry, something wrong happened. Please retry.');

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

if ($a['pic0']['error'] === 0) {
	$base64_0 = base64_encode($a['pic0']['content']);
	$a['pic0']['file'] = $base64_0;
	$pic0 = "<img class='img-responsive events-pad' src=\"data:image/jpeg;base64,${base64_0}\">";
}

if ($a['pic1']['error'] === 0) {
	$base64_1 = base64_encode($a['pic1']['content']);
	$a['pic1']['file'] = $base64_1;
	$pic1 = "<img class='img-responsive events-pad' src=\"data:image/jpeg;base64,${base64_1}\">";
}
if ($a['pic2']['error'] === 0) {
	$tmp_name2 = $a['pic2']['tmp_name'];
	$base64_2 = base64_encode($a['pic2']['content']);
	$a['pic2']['file'] = $base64_2;
	$pic2 = "<img class='img-responsive events-pad' src=\"data:image/jpeg;base64,${base64_2}\">";
}
if ($a['pic3']['error'] === 0) {
	$tmp_name3 = $a['pic3']['tmp_name'];
	$base64_3 = base64_encode($a['pic3']['content']);
	$a['pic3']['file'] = $base64_3;
	$pic3 = "<img class='img-responsive events-pad' src=\"data:image/jpeg;base64,${base64_3}\">";
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
				<a href="/cebroad/events/add/rewrite">Rewrite</a>
					<button class="btn btn-cebroad" onclick="location.href=''" name="submit" type="submit">Submit</button>
			</div>
		</form>

	</div>
</div>