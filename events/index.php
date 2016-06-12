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
				<?php foreach ($rtn as $event): ?>
					<div class="col-xs-12 col-sm-6 col-md-4 panel panel-primary">
						<div class="panel-heading">
							<h2 class="panel-title"><?php echo $event['event_name']; ?></h2>
						</div>
						<div class="panel-body">
							<p class="day"><?php echo $event['date']; ?></p>
							<img alt="sea" width="300" height="200" src="https://okinawa-labo.com/wp-content/uploads/2014/07/seaofoka.jpg" />
							<div class="info">
								<ul class="list-inline">
									<li style="width:33%;">1</li>
									<li style="width:34%;">1</li>
									<li style="width:33%;">1</li>
								</ul>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
		</div>
	</div>
