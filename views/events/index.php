<?php 
	$sql = 'SELECT * FROM events ORDER BY date DESC';
	$records = mysqli_query($db, $sql) or die(mysqli_error($db));
	$rtn = array();
	while($result = mysqli_fetch_assoc($records)) {
	  $rtn[] = $result;
	 }
 ?>

    <div class="container">
		<div class="row">
		    <div class="testvar hidden-xs col-sm-2 col-md-2">
    		</div>

            <div class="col-sm-10 col-md-10">
        		<div class="col-sm-12 col-md-12 events-pad">
        			<button class="btn btn-cebroad pull-right "onclick="location.href='/portfolio/cebroad/events/add'">Create a new event</button>
        		</div>
    			<?php foreach ($rtn as $event): ?>

    				<div class="col-sm-6 col-md-4">				
                        <div class="panel panel-default">
                        	<div class="panel-thumbnail"><img class="img-responsive" src="<?=h($event['picture_path_0'])?>"></div>
                                <div class="panel-body">
                                    <a href="/portfolio/cebroad/events/show/<?=h($event['id'])?>"><p class="lead"><?=h($event['title'])?></p></a>
                                    <p><?=h($event['date'])?></p>
                                   	<p class="event_people"><i class="fa fa-users fa-lg"></i>:100</p>
    								<p class="event_like"><i class="fa fa-thumbs-o-up fa-lg"></i>:52</p>
                                </div>
                            </div>
    				</div>
    			<?php endforeach; ?>
            </div>
		</div>
	</div>