<?php
$now = date('Y-m-d');
$year = date('Y-m-d', strtotime("+1year"));

 ?>
<link rel="stylesheet" href="../webroot/assets/css/bootstrap.css">
<link rel="stylesheet" href="../webroot/assets/css/add.css">
<script src="http://maps.googleapis.com/maps/api/js?libraries=places&output?json&region=ph&language=en&key=AIzaSyDf24saS_c-qe8Qy4QPgVbTub1sJi02ov8"></script>
<div class="container">
    <form action="/cebroad/events/confirm.php" method="post" enctype="multipart/form-data">

      <div class="row">

        <div class="col-sm-8 col-md-8 col-md-offset-2 col-sm-offset-2">
            <h1>New event</h1>
            <h3>Red items are necessarily required</h3>
        </div>

        <div class="col-sm-8 col-md-8 col-md-offset-2 col-sm-offset-2">
            <div class="form-group">
                <label class="red">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
        </div>

        <div class="col-sm-4 col-md-4 col-sm-offset-2 col-md-offset-2">
            <label class="red">Date</label>
            <div class="form-group">
                <input type="date" name="date" class="form-control " min="<?php echo $now; ?>" max="<?php echo $year; ?>"  required>
            </div>
        </div>

        <div class="col-sm-4 col-md-4 col-sm-offset-2 col-md-offset-2">
            <label class="red">Starting time</label>
            <div class="form-group">
                <input type="time" name="start_time" class="form-control" required>
            </div>
                <label id="closing_time_label">Closing time</label>
                <div class="form-group">
                    <input type="time" name="closing_time" class="form-control" id="closing_time">
                </div>
<!--             <div class="form-group">
                <a id="time_button" onclick="closingTime()">Add closing time</a>
            </div> -->

        </div>


        <div class="col-sm-4 col-md-4 col-sm-offset-2 col-md-offset-2">
            <label>Capacity</label>
            <div class="form-group">
                <input type="number" name="capacity" class="form-control " min="1" required>
            </div>
        </div>

        <div class="col-sm-8 col-md-8 col-md-offset-2 col-sm-offset-2">
            <label class="red">Place</label>
            <div class="form-group">
                <input id="searchTextField" type="text" name="place" class="form-control" onkeydown="disabling()" required>
            </div>
        </div>
        
        <div class="col-sm-8 col-md-8 col-md-offset-2 col-sm-offset-2">
            <div class="form-group">
                <label class="red">detail</label>
                <textarea name="detail" class="form-control" rows="6" required></textarea>
            </div>
        </div>

        <div class="col-sm-8 col-md-2 col-md-offset-2 col-sm-offset-2">
            <div class="form-group">
                <label>Picture1</label>
                <input type="file" name="pic1">
            </div>
        </div>

        <div class="form-group">
            <input id=place_name type="hidden" name="place_name" value="">
            <input id=lat type="hidden" name="lat" value="">
            <input id=lng type="hidden" name="lng" value="">
        </div>

        <div class="col-sm-8 col-md-8 col-md-offset-2 col-sm-offset-2";>
            <div class="form-group">
                <input type="submit" id="confirm" class="btn btn-primary" disabled="disabled" value="confirm">
            </div>
        </div>

      </div>
    </form>
</div>



<script>
function initialize() {
    var input = document.getElementById('searchTextField');

    var options = {
        componentRestrictions: {country: 'ph'}
    };
    var autocomplete = new google.maps.places.Autocomplete(input, options);
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var place = autocomplete.getPlace();
        document.getElementById('place_name').value = place.name;
        document.getElementById('lat').value = place.geometry.location.lat();
        document.getElementById('lng').value = place.geometry.location.lng();
        document.getElementById('confirm').disabled = false;
        });
}

google.maps.event.addDomListener(window, 'load', initialize);

function disabling() {
    document.getElementById('confirm').disabled = true;
}
</script>




<!-- <script src="https://maps.google.com/maps/api/js?key=AIzaSyDf24saS_c-qe8Qy4QPgVbTub1sJi02ov8&language=en&region=ph"></script> -->

<!-- <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDf24saS_c-qe8Qy4QPgVbTub1sJi02ov8&language=en"></script> -->

<script src="../webroot/assets/js/jquery-1.12.4.min.js"></script>
<!-- <script src="../webroot/assets/js/gmap.js"></script> -->


<script src="../webroot/assets/js/bootstrap.js"></script>