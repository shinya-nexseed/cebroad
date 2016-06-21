<?php 
	$sql = 'SELECT * FROM events ORDER BY created DESC';
	$records = mysqli_query($db, $sql) or die(mysqli_error($db));
	$rtn = array();
	while($result = mysqli_fetch_assoc($records)) {
	  $rtn[] = $result;
	 }
 ?>


			<?php foreach ($rtn as $event): ?>
				<div class="col-sm-4 col-md-4">
                    <div class="panel panel-default">
                    	<div class="panel-thumbnail"><img class="img-responsive" src="https://okinawa-labo.com/wp-content/uploads/2014/07/seaofoka.jpg" /></div>
                            <div class="panel-body">
                                <p class="lead"><?php echo h($event['event_name']); ?></p>
                               	<p class="event_people"><i class="fa fa-users fa-lg"></i>:100</p>
								<p class="event_like"><i class="fa fa-thumbs-o-up fa-lg"></i>:52</p>
                            </div>
                        </div>
				</div>
			<?php endforeach; ?>

