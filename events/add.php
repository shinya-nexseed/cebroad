<?php 


 ?>
<link rel="stylesheet" href="../webroot/assets/css/bootstrap.css">

<div class="container">
    <form>
        <div class="form-group">
            <label>title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

            <div class="form-group">
                    <input type="datetime-local" class="form-control" required="">
                </div>
            </div>

        <div class="form-group">
            <label>detail</label>
            <textarea name="detail" class="form-control" required></textarea>
        </div>

		<div class="form-group">
            <label>place</label>
            <input type="text" name="title" class="form-control" required>  
        </div>

		<div class="form-group">
  		</div>

        <button type="submit">confirm</button>
    </form>
</div>
  			<input id="searchTextField" type="text" name="city" placeholder="Enter a location" autocomplete="off">

<script type="text/javascript">
function initialize() {
    var input = document.getElementById('searchTextField');
    var options = {
        types: ['(regions)'],
    };
    autocomplete = new google.maps.places.Autocomplete( input, options);
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>



<!-- <script src="https://maps.google.com/maps/api/js?key=AIzaSyDf24saS_c-qe8Qy4QPgVbTub1sJi02ov8&language=en&region=ph"></script> -->

<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDf24saS_c-qe8Qy4QPgVbTub1sJi02ov8&libraries=places&language=en"></script>

<script src="../webroot/assets/js/jquery-1.12.4.min.js"></script>
<!-- <script src="../webroot/assets/js/gmap.js"></script> -->


<script src="../webroot/assets/js/bootstrap.js"></script>