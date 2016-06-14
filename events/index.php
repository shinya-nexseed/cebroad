<?php 
	$sql = 'SELECT * FROM events ORDER BY created DESC';
	$records = mysqli_query($db, $sql) or die(mysqli_error($db));
	$rtn = array();
	while($result = mysqli_fetch_assoc($records)) {
	  $rtn[] = $result;

	 }
 ?>



   <link rel="stylesheet" href="../webroot/assets/css/bootstrap.min.css">
   <link rel="stylesheet" href="../webroot/assets/events/css/events.css">
   <link rel="stylesheet" href="../webroot/assets/font-awesome/css/font-awesome.min.css">
   <link href="../webroot/assets/events/css/events/styles.css" rel="stylesheet">
    <style type="text/css">
            @import url("http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,400italic");
    </style>


    <div class="container">
		<div class="row">
		    <div class="testvar hidden-xs col-sm-2 col-md-2">
    		</div>
			<?php foreach ($rtn as $event): ?>
				<div class="col-sm-4 col-md-4">
                    <div class="panel panel-default">
                    	<div class="panel-thumbnail"><img class="img-responsive" src="https://okinawa-labo.com/wp-content/uploads/2014/07/seaofoka.jpg" /></div>
                            <div class="panel-body">
                                <p class="lead"><?php echo $event['event_name']; ?></p>
                               	<p class="event_people"><i class="fa fa-users fa-lg"></i>:100</p>
								<p class="event_like"><i class="fa fa-thumbs-o-up fa-lg"></i>:52</p>
                            </div>
                        </div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
