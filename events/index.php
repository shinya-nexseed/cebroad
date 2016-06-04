<?php 
	$sql = 'SELECT * FROM events ORDER BY created DESC';
	$records = mysqli_query($db, $sql) or die(mysqli_error($db));
	$rtn = array();
	while($result = mysqli_fetch_assoc($records)) {
	  $rtn[] = $result;

	 }
 ?>



   <link rel="stylesheet" href="../webroot/assets/css/bootstrap.css">
   <link rel="stylesheet" href="../webroot/assets/css/style.css">
   <link rel="stylesheet" href="../webroot/assets/font-awesome/css/font-awesome.css">
    <style type="text/css">
            @import url("http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,400italic");
    </style>

    <div class="container">
		<div class="row">
			<div class="[ col-xs-12 col-sm-offset-2 col-sm-8 ]">
				<ul class="event-list">
				<?php foreach ($rtn as $event): ?>

					<li>
						<time datetime="">
							<span class="day">20</span>
							<span class="month">Jan</span>
							<span class="year">2014</span>
							<span class="time">8:00 PM</span>
						</time>
						<img alt="My 24th Birthday!" src="https://farm5.staticflickr.com/4150/5045502202_1d867c8a41_q.jpg" />
						<div class="info">
							<h2 class="title"><?php echo $event['event_name']; ?></h2>
							<p class="desc"><?php echo $event['detail']; ?></p>
							<ul>
								<li style="width:33%;">10 go</li>
								<li style="width:34%;">1 like</li>
								<li style="width:33%;">1 not go</li>
							</ul>
						</div>
					</li>

				<?php endforeach; ?>

				</ul>
			</div>
		</div>
	</div>
