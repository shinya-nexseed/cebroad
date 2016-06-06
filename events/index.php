<?php 
	$sql = 'SELECT * FROM events ORDER BY created DESC';
	$records = mysqli_query($db, $sql) or die(mysqli_error($db));
	$rtn = array();
	while($result = mysqli_fetch_assoc($records)) {
	  $rtn[] = $result;

	 }
 ?>



   <link rel="stylesheet" href="../webroot/assets/css/bootstrap.css">
   <link rel="stylesheet" href="../webroot/assets/css/events.css">
    <style type="text/css">
            @import url("http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,400italic");
    </style>

    <div class="container">
		<div class="row">
				<ul class="event-list">
				<?php foreach ($rtn as $event): ?>
					<div class="[col-xs-12 col-sm-5 well]">
					<div class="pic">
						<h2 class="title"><?php echo $event['event_name']; ?></h2>
							<p class="day"><?php echo $event['date']; ?></p>
						<img alt="sea" width="300" height="200" src="https://okinawa-labo.com/wp-content/uploads/2014/07/seaofoka.jpg" />
					</div>
						<div class="info">
							<ul class="list-inline">
								<li style="width:33%;">10 go</li>
								<li style="width:34%;">1 like</li>
								<li style="width:33%;">1 not go</li>
							</ul>
						</div>
					</div>
				<?php endforeach; ?>

				</ul>
		</div>
	</div>
